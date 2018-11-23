<?php
namespace app\chengji\controller;

// 引用控制器基类
use app\common\controller\Base;
// 引用学生数据模型
use app\renshi\model\Student;
// 引用成绩数据模型
use app\chengji\model\Chengji;
// 引用学科数据模型
use app\teach\model\subject;
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
                    ->append(['studentname','schooljian','banjiname'])
                    ->find();
        $stuinfo['zdname'] = $zdname;
        $stuinfo['zdstr'] = $zd;
        return json($stuinfo->visible(['studentname','schooljian','banjiname','banji',$zd,'zdstr','zdname']));
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
       
        // 删除成绩采集表标题行
        array_splice($cjinfo,0,3);
        dump($xk);

        
        $cj = array();
        $i = 0;
        // 重新组合成绩信息
        foreach ($cjinfo as $key => $value) {
            $cj[$i]['id'] = $value[1];
            foreach ($xk as $k => $val) {
                $cj[$i][$xk[$k]] = $value[4+$k];
            }
            $i++;
        }

        return $cj;
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


    

    
}
