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
        $ks = new \app\kaoshi\model\Kaoshi;
        $ksinfo = $ks->where('id',$kaoshi)
            ->with([
                'KsNianji'
                ,'ksSubject'=>function($query){
                    $query->field('kaoshiid,subjectid,manfen')
                        ->with(['subjectName'=>function($q){
                            $q->field('id,title,lieming');
                        }]
                    );
                }
            ])
            ->field('id,title')
            ->find();

        if(count($ksinfo->ks_nianji)>0)
        {
            $list['nianji'] = $ksinfo->ks_nianji[0]->nianji;
        }else{
            $list['nianji'] = "一年级";
        }
        $list['subject'] = $ksinfo->ksSubject->toArray();
        // 设置要给模板赋值的信息
        $list['webtitle'] = '各年级的班级成绩列表';
        $list['kaoshi'] = $kaoshi;
        $list['kaoshititle'] = $ksinfo->title;
        $list['dataurl'] = '/chengji/bjtj/data';


        // 模板赋值
        $this->view->assign('list',$list);

        // 渲染模板
        return $this->view->fetch();
    }
    

}
