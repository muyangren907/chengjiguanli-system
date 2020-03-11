<?php
namespace app\kaoshi\controller;

// 引用控制器基类
use app\BaseController;
// 引用考号数据模型类
use app\kaoshi\model\KaoshiSet as ksset;
// 考试控制器
use app\kaoshi\controller\Kaoshi as kscon;


class KaoshiSet extends BaseController
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    // 显示考试列表
    public function index($kaoshi)
    {

        // 设置要给模板赋值的信息
        $list['webtitle'] = '参加考试学科';
        $list['dataurl'] = '/kaoshi/kaoshiset/data';
        $list['kaoshi'] = $kaoshi;

        $ksset = new ksset;
        $list['subject'] = $ksset->srcSubject($kaoshi);
        $nj = $ksset->srcNianji($kaoshi);

        // 模板赋值
        $this->view->assign('list',$list);

        // 渲染模板
        return $this->view->fetch();
    }


    // 获取考试信息列表
    public function ajaxData()
    {

        // 获取参数
        $src = $this->request
                ->only([
                    'kaoshi'=>0,
                    'nianji'=>array(),
                    'subject'=>array(),
                    'page'=>'1',
                    'limit'=>'10',
                    'field'=>'id',
                    'order'=>'desc',
                    'searchval'=>''
                ],'POST');


        // 实例化
        $kssbj = new ksset;

        // 查询要显示的数据
        $data = $kssbj->search($src);


        // 获取符合条件记录总数
        $cnt = $data->count();
        // 获取当前页数据
        $limit_start = $src['page'] * $src['limit'] - $src['limit'];
        $limit_length = $src['limit'];
        $data = $data->slice($limit_start,$limit_length);

        // 重组返回内容
        $data = [
            'code'=> 0 , // ajax请求次数，作为标识符
            'msg'=>"",  // 获取到的结果数(每页显示数量)
            'count'=>$cnt, // 符合条件的总数据量
            'data'=>$data, //获取到的数据结果
        ];


        return json($data);
    }


    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create($kaoshi)
    {

        // 设置页面标题
        $list['set'] = array(
            'webtitle'=>'设置考试',
            'butname'=>'设置',
            'formpost'=>'POST',
            'url'=>'/kaoshi/kaoshiset/save',
            'kaoshi'=>$kaoshi,
        );

        // 获取参加考试年级
        $ks = new \app\kaoshi\model\Kaoshi;
        $ksend = $ks->where('id',$kaoshi)->value('enddate');
        $list['set']['nianji'] = nianjiList($ksend);

        // 模板赋值
        $this->view->assign('list',$list);
        // 渲染
        return $this->view->fetch();
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save()
    {
        // 获取参数
        $src = $this->request
                ->only([
                    'kaoshi',
                    'nianji',
                    'nianjiname',
                    'subject'=>array(),
                    'manfen'=>array(),
                    'youxiu'=>array(),
                    'jige'=>array(),
                    // 'lieming'=>array()
                ],'POST');

        event('kslu',$src['kaoshi']);

        // 验证表单数据
        $validate = new \app\kaoshi\validate\Kaoshiset;
        $result = $validate->scene('create')->check($src);
        $msg = $validate->getError();
        // 如果验证不通过则停止保存
        if(!$result){
            return json(['msg'=>$msg,'val'=>0]);;
        }

        // 整理参数
        $list = array();
        foreach ($src['subject'] as $key => $value) {
            $list[] = [
                'kaoshi_id'=>$src['kaoshi'],
                'nianji'=>$src['nianji'],
                'nianjiname'=>$src['nianjiname'],
                'subject_id'=>$value,
                'manfen'=>$src['manfen'][$key],
                'youxiu'=>$src['youxiu'][$key],
                'jige'=>$src['jige'][$key],
                // 'lieming'=>$src['lieming'][$key]
            ];
        }


        // 查询已经存在数据删除并添加新数据
        $ksset = new ksset;
        $nianji = $src['nianji'];
        $kaoshi_id = $src['kaoshi'];

        ksset::destroy(function($query)use($nianji,$kaoshi_id){
            $query->where('kaoshi_id',$kaoshi_id)
                ->where('nianji',$nianji);
            ;
        },true);

        $data = $ksset->saveAll($list);

        // 根据更新结果设置返回提示信息
        $data ? $data=['msg'=>'设置成功','val'=>1] : $data=['msg'=>'数据处理错误','val'=>0];

        // 返回信息
        return json($data);

    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        // 获取考试信息
        $ksset = new ksset;
        $list['data'] = $ksset::where('id',$id)
            ->field('id,kaoshi_id,nianjiname,subject_id,manfen,youxiu,jige')
            ->with([
                'subjectName' => function($query){
                    $query->field('id,title,jiancheng');
                }
            ])
            ->find()->toArray();

        // 设置页面标题
        $list['set'] = array(
            'webtitle'=>'编辑考试设置',
            'butname'=>'修改',
            'formpost'=>'PUT',
            'url'=>'/kaoshi/kaoshiset/update/'.$id,
        );

        // 模板赋值
        $this->view->assign('list',$list);
        // 渲染
        return $this->view->fetch('edit');
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update($id)
    {
        $validate = new \app\kaoshi\validate\KaoshiSetEdit;
        // 获取表单数据
        $list = request()->only(['id','kaoshi','manfen','youxiu','jige'],'post');

        // 验证表单数据
        $result = $validate->scene('edit')->check($list);
        $msg = $validate->getError();
        // 如果验证不通过则停止保存
        if(!$result){
            return json(['msg'=>$msg,'val'=>0]);;
        }
        event('kslu',$list['kaoshi']);

        // 更新数据
        $ksset = new ksset();
        $ksdata = $ksset::update($list);


        // 根据更新结果设置返回提示信息
        $ksdata ? $data=['msg'=>'更新成功','val'=>1] : $data=['msg'=>'数据处理错误','val'=>0];

        // 返回信息
        return json($data);
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    // 删除考号
    public function delete($id)
    {

        if($id == 'm')
        {
            $id = request()->delete('ids');// 获取delete请求方式传送过来的数据并转换成数据
        }

        $id = explode(',', $id);

        // 判断考试结束时间是否已过
        $ksset = new ksset;
        $ksid = $ksset::where('id',$id[0])->value('kaoshi_id');
        event('kslu',$ksid);

        $data = ksset::destroy($id,true);
        // 根据更新结果设置返回提示信息
        $data ? $data=['msg'=>'删除成功','val'=>1] : $data=['msg'=>'数据处理错误','val'=>0];
        // 返回信息
        return json($data);
    }


    // 设置荣誉状态
    public function setStatus()
    {
        //  获取id变量
        $id = request()->post('id');
        $value = request()->post('value');

        $ksid = ksset::where('id',$id)->value('kaoshi_id');
        event('kslu',$ksid);

        // 获取学生信息
        $data = ksset::where('id',$id)->update(['status'=>$value]);

        // 根据更新结果设置返回提示信息
        $data ? $data=['msg'=>'状态设置成功','val'=>1] : $data=['msg'=>'数据处理错误','val'=>0];

        // 返回信息
        return json($data);
    }

}
