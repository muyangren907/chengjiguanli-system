<?php
declare (strict_types = 1);

namespace app\teach\controller;

// 引用控制器基类
use app\BaseController;
// 引用班级数据模型类
use app\teach\model\BanjiChengji as bjcj;

class BanjiChengji extends BaseController
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index($banji)
    {
        // 设置要给模板赋值的信息
        $list['webtitle'] = '班级历次考试成绩';
        $list['dataurl'] = '/teach/banjicj/data';
        $list['banji_id'] = $banji;

        $sbj = new \app\teach\model\Subject;
        $list['subject'] = $sbj->searchKaoshi()->toArray();

        // 模板赋值
        $this->view->assign('list',$list);

        // 渲染模板
        return $this->view->fetch();
    }


    // 获取班级成绩数组
    public function ajaxData()
    {
        // 获取参数
        $src = $this->request
            ->only([
                'page'=>'1',
                'limit'=>'10',
                'field'=>'ks_id',
                'order'=>'desc',
                'banji'=>'',
                'category'=>'',
                'xueqi'=>'',
                'bfdate'=>'',
                'enddate'=>'',
            ],'POST');


        // 实例化班级成绩数据模型
        $bjcj = new \app\chengji\model\TongjiBj;
        $data = $bjcj->srcBanjiChengji($src);
        $bjcj = new bjcj;
        $data = $bjcj->banjiChengjiList($data);


        // 获取符合条件记录总数
        $cnt = count($data);

        $src['order'] == 'desc' ? $src['order'] =SORT_DESC :$src['order'] = SORT_ASC;
        if($cnt > 0){
            $data = sortArrByManyField($data,$src['field'],$src['order']);
        }

        // 获取当前页数据
        $limit_start = $src['page'] * $src['limit'] - $src['limit'];
        $limit_length = $src['limit'];
        $data = array_slice($data,$limit_start,$limit_length);

        // 重组返回内容
        $data = [
            'code'=> 0 , // ajax请求次数，作为标识符
            'msg'=>"",  // 获取到的结果数(每页显示数量)
            'count'=>$cnt, // 符合条件的总数据量
            'data'=>$data, //获取到的数据结果
        ];

        return json($data);
    }


    // 获取条形统计图数据
    public function ajaxDataTiaoXing()
    {
        // 获取参数
        $src = $this->request
            ->only([
                'field'=>'ks_id',
                'order'=>'desc',
                'banji'=>'',
                'subject' => '',
                'category'=>'',
                'xueqi'=>'',
                'bfdate'=>'',
                'enddate'=>'',
            ],'POST');


        // 实例化班级成绩数据模型
        $bjcj = new \app\chengji\model\TongjiBj;
        $data = $bjcj->srcBanjiChengji($src);
        $bjcj = new bjcj;
        $data = $bjcj->tiaoXing($data, $src['subject']);

        return json($data);

    }

}
