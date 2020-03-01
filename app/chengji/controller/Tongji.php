<?php

namespace app\chengji\controller;

// 引用控制器基类
use app\BaseController;
// 引用成绩统计数据模型
use app\chengji\model\Tongji as TJ;

class Tongji extends BaseController
{

    // 统计已经录入成绩数量
    public function yiluCnt($kaoshi)
    {
        // 获取考试信息
        $ks = new \app\kaoshi\model\Kaoshi;
        $ksinfo = $ks->where('id',$kaoshi)
            ->field('id,title')
            ->find();

        // 获取参加考试的年级和学科
        $ksset = new \app\kaoshi\model\KaoshiSet;
        $list['nianji'] = $ksset->srcNianji($kaoshi);
        $list['subject'] = $ksset->srcSubject($kaoshi);

       
        // 获取参与班级
        if(count($list['nianji'])>0)
        {
            $kh = new \app\kaoshi\model\Kaohao;
            $src['ruxuenian'] = [$list['nianji'][0]['nianji']];
            $src['kaoshi'] = $kaoshi;
            $list['school'] = $kh->cySchool($src);
        }

        // 设置要给模板赋值的信息
        $list['webtitle'] = '各年级的班级成绩列表';
        $list['kaoshi'] = $kaoshi;
        $list['kaoshititle'] = $ksinfo->title;
        $list['dataurl'] = '/chengji/tongji/data';


        // 模板赋值
        $this->view->assign('list',$list);

        // 渲染模板
        return $this->view->fetch();
    }


        // 获取年级成绩统计结果
    public function ajaxData()
    {
        // 获取参数
        $src = $this->request
                ->only([
                    'page'=>'1',
                    'limit'=>'10',
                    'kaoshi'=>'',
                    'ruxuenian'=>'',
                    'school'=>array(),
                    'banji'=>array(),
                ],'POST');     

        // 统计成绩
        $btj = new \app\chengji\model\TongjiBj;

        $data = $btj->tjBanjiCnt($src);
       
        // 获取记录总数
        $cnt = count($data);
        // 截取当前页数据
        $data = array_slice($data,($src['page']-1)*$src['limit'],$src['limit']);

        // 重组返回内容
        $data = [
            'code'=> 0 , // ajax请求次数，作为标识符
            'msg'=>"",  // 获取到的结果数(每页显示数量)
            'count'=>$cnt, // 符合条件的总数据量
            'data'=>$data, //获取到的数据结果
        ];

        return json($data);
    }


    public function newJieguo()
    {
        // 获取成绩最后修改时间
        $cj = new \app\chengji\model\Chengji;
        $cj = $cj->order(['update_time'=>'desc'])->find();
        $cj = $cj->getData('update_time');

        // 分别获取班级、年级、学校统计结果更新时间
        $bj = new \app\chengji\model\TongjiBj;
        $bj = $bj->order(['update_time'=>'desc'])->find();
        $bj = $bj->getData('update_time');

        $nj = new \app\chengji\model\TongjiNj;
        $nj = $nj->order(['update_time'=>'desc'])->find();
        $nj = $nj->getData('update_time');

        $sch = new \app\chengji\model\TongjiSch;
        $sch = $sch->order(['update_time'=>'desc'])->find();
        $sch = $sch->getData('update_time');

        if($cj>=$bj || $cj>=$nj || $cj>=$sch)
        {
            $data=['msg'=>'不是最新结果,重算一下！','val'=>0];
        }else{
            $data=['msg'=>'是最新结果，不用算啦~','val'=>1];
        }

        return json($data);

    }


}
