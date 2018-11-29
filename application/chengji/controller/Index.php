<?php
namespace app\chengji\controller;

// 引用控制器基类
use app\common\controller\Base;
// 引用学生数据模型
use app\renshi\model\Student;
// 引用成绩数据模型
use app\chengji\model\Chengji;
// 引用学科数据模型
use app\teach\model\Subject;
// 引用文件信息存储数据模型类
use app\system\model\Fields;
// 引用phpspreadsheet类
use app\renshi\controller\Myexcel;

class Index extends Base
{
    // 使用二维码录入成绩
    public function malu()
    {
    	return $this->fetch();
    }

    // 保存使用二维码录入的成绩
    public function malusave()
    {
        // 获取表单数据
        $list = request()->only(['id','ziduan','defen'],'post');
        // 声明学科数组
        $subject = array('1'=>'yuwen','2'=>'shuxue','3'=>'waiyu');
        $zd = $subject[$list['ziduan']];

        // 更新成绩
        $cj = Chengji::update(['id'=>$list['id'], $zd=>$list['defen']]);

        empty($cj) ? $data = ['val' => 0] : $data = ['val' => 1,'defen'=>$cj->$zd];

        return json($data);


    }


    
    // 根据考号获取学生信息
    public function read()
    {
        // 获取表单数据 
        $list = request()->only(['id','ziduan'],'post');
        // 声明学科数组
        $subject = array('1'=>array('yuwen','语文'),'2'=>array('shuxue','数学'),'3'=>array('waiyu','外语'));


        $zd = $subject[$list['ziduan']][0];
        $zdname = $subject[$list['ziduan']][1];
        $stuinfo = Chengji::where('id',$list['id'])
                    ->field('id,school,student,banji,'.$zd)
                    // ->append(['banjiname'])
                    ->find();
        $stuinfo['zdname'] = $zdname;
        $stuinfo['zdstr'] = $zd;
        return json($stuinfo->visible(['student','school','banji',$zd,'zdstr','zdname']));
    }


    // 表格录入成绩上传页面
    public function biaolu()
    {
        return $this->fetch();
    }

    

    // 保存表格批量上传的成绩 
    public function saveAll()
    {
        // 获以电子表格存储位置
        $url = input('post.url');

        // 实例化操作表格类
        $excel = new Myexcel();

        // 读取表格数据
        $cjinfo = $excel->readXls($url);

        // 获取成绩采集学科信息
        $xk = $cjinfo[1];
        array_splice($xk,0,4);
        $xklie = Subject::where('id','in',$xk)->column('id,lieming');
       
        // 删除成绩采集表标题行
        array_splice($cjinfo,0,3);

        // 获取学科满分
        if($cjinfo[0][1] !=null)
        {
            $manfen = getmanfen($cjinfo[0][1],$xk);
        }else{
            $data = ['msg'=>'上传失败','val' => 0];
            return json($data);
        }
        $cj = array();
        $i = 0;
        // 重新组合成绩信息
        foreach ($cjinfo as $key => $value) {
            $x = 1;
            foreach ($xklie as $k => $val) {
                if(!empty($value[3+$x]) && manfenvalidate($value[3+$x],$manfen[$k])){
                    $cj[$i][$xklie[$k]] = number_format($value[3+$x],1);
                    $cj[$i]['id'] = $value[1];  
                }
                $x++;
            }
            $i++;
        }

        // 实例成绩模块
        $cjmod = new Chengji();
        // 保存成绩
        $data = $cjmod->saveAll($cj);

        // 判断成绩更新结果
        empty($cj) ? $data = ['msg'=>'上传失败','val' => 0] : $data = ['msg'=>'上传成功','val' => 1,];

        // 返回成绩结果
        return json($data);
    }


    // 上传成绩采集表格
    public function upload()
    {
        // 获取文件信息
        $list['text'] = '成绩采集';
        $list['oldname']=input('post.name');
        $list['bianjitime'] = input('post.lastModifiedDate');
        $list['fieldsize'] = input('post.size');

        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('file');
        // 移动到框架应用根目录/uploads/ 目录下
        $info = $file->move( '..\public\uploads\chengji');
        if($info){
            // 成功上传后 获取上传信息
            $list['category'] = $info->getExtension();
            $list['url'] = $info->getSaveName();
            $list['newname'] = $info->getFilename(); 

            //将文件信息保存
            $data = Fields::create($list);

            $data ? $data = array('msg'=>'上传成功','val'=>true,'url'=>'..\public\uploads\chengji\\'.$list['url']) : $data = array('msg'=>'保存文件信息失败','val'=>false,'url'=>null);
        }else{
            // 上传失败获取错误信息
            $data = array('msg'=>$file->getError(),'val'=>false,'url'=>null);
        }

        // 返回信息
        return json($data);
    }


    // 成绩列表
    public function Chengjilist($id)
    {
        // 设置数据总数
        $list['count'] = Chengji::where('kaoshi',$id)->count();
        // 设置页面标题
        $list['title'] = '成绩列表';
        $list['kaoshi'] = $id;

        // 模板赋值
        $this->assign('list', $list);

        // 渲染模板
        return $this->fetch();
    }


    // 获取考试信息
    public function ajaxData()
    {
        // 获取DT的传值
        $getdt = request()->param();

        //得到排序的方式
        $order = $getdt['order'][0]['dir'];
        //得到排序字段的下标
        $order_column = $getdt['order'][0]['column'];
        //根据排序字段的下标得到排序字段
        $order_field = $getdt['columns'][$order_column]['data'];
        //得到limit参数
        $limit_start = $getdt['start'];
        $limit_length = $getdt['length'];
        //得到搜索的关键词
        $search = $getdt['search']['value'];


        // 获取记录集总数
        $cnt = Chengji::where('kaoshi',$getdt['kaoshi'])->count();
        //查询数据
        $data =Chengji::field('id,kaoshi,school,banji,student,nianji,yuwen,shuxue,waiyu,stuSum,stuAvg,status')
            ->where('kaoshi',$getdt['kaoshi'])
            ->append(['cj_school.jiancheng','cj_banji.title','cj_student.xingming'])
            ->order([$order_field=>$order])
            ->limit($limit_start,$limit_length)
            ->select();
      

        // 如果需要查询
        if($search){
            $data =Chengji::where('kaoshi',$getdt['kaoshi'])
            ->where(function ($query) use($search){
                $query->whereOr('student','in',function ($query) use($search){
                    $query->name('student')->where('xingming','like','%'.$search.'%')->field('id');
                })
                ->whereOr('school','in',function ($query) use($search){
                $query->name('school')->where('title|jiancheng','like','%'.$search.'%')->field('id');
            });
            })

            ->append(['cj_school.jiancheng','cj_banji.title','cj_student.xingming'])
            ->order([$order_field=>$order])
            ->limit($limit_start,$limit_length)
            ->select();
        }
        // $data = $data->visible(['cj_school.jiancheng','cj_banji.title']);

        $datacnt = $data->count();
        // $data = $data->append(['stuAvg','stuSum']);
        
        


        $data = [
            'draw'=> $getdt["draw"] , // ajax请求次数，作为标识符
            'recordsTotal'=>$datacnt,  // 获取到的结果数(每页显示数量)
            'recordsFiltered'=>$cnt,       // 符合条件的总数据量
            'data'=>$data, //获取到的数据结果
        ];

        return json($data);
    }




    // 删除成绩
    public function deletecj($id)
    {

        // 声明要删除成绩数组
        $data = array();

        if($id == 'm')
        {
            $id = request()->delete('ids/a');// 获取delete请求方式传送过来的数据并转换成数据
            $i=0;
            foreach ($id as $key => $value) {
                $data[$i]['id'] = $value;
                $data[$i]['yuwen'] = Null;
                $data[$i]['shuxue'] = Null;
                $data[$i]['wanyu'] = Null;
            }
        }else{
            $data[0]['id'] = $id; 
            $data[0]['yuwen'] = Null;
            $data[0]['shuxue'] = Null;
            $data[0]['waiyu'] = Null;
            $data[0]['stuSum'] = Null;
            $data[0]['stuAvg'] = Null;
        }


        $cj = new Chengji();
        $data = $cj->saveAll($data);

        // 根据更新结果设置返回提示信息
        $data ? $data=['msg'=>'成绩删除成功','val'=>1] : $data=['msg'=>'数据处理错误','val'=>0];

        // 返回信息
        return json($data);
    }



    // 删除成绩
    public function delete($id)
    {

        if($id == 'm')
        {
            $id = request()->delete('ids/a');// 获取delete请求方式传送过来的数据并转换成数据
        }

        $data = Chengji::destroy($id);

        // 根据更新结果设置返回提示信息
        $data ? $data=['msg'=>'删除成功','val'=>1] : $data=['msg'=>'数据处理错误','val'=>0];

        // 返回信息
        return json($data);
    }




    // 设置成绩状态
    public function setStatus()
    {

        //  获取id变量
        $id = request()->post('id');
        $value = request()->post('value');

        // 获取班级信息
        $data = Chengji::where('id',$id)->update(['status'=>$value]);

        // 根据更新结果设置返回提示信息
        $data ? $data=['msg'=>'状态设置成功','val'=>1] : $data=['msg'=>'数据处理错误','val'=>0];

        // 返回信息
        return json($data);
    }

      
}
