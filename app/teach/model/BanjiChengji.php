<?php
declare (strict_types = 1);

namespace app\teach\model;

// 引用数据模型基类
use app\BaseModel;

/**
 * @mixin think\Model
 */
class BanjiChengji extends BaseModel
{
    /**
    * 整理班级成绩表
    */
    public function banjiChengjiList($cjlist)
    {
        $data = array();
        foreach ($cjlist as $key => $value) {

            if(!isset($data[$value->kaoshi_id]))
            {
                $data[$value->kaoshi_id] = [
                    'ks_title' => $value->bjKaoshi->title,
                    'stu_cnt' => $value->stu_cnt,
                    'ks_id' => $value->kaoshi_id,
                ];
            }

            if($value->subject_id == 0)
            {
                $data[$value->kaoshi_id]['quanke'] = [
                    'avg' => $value->avg,
                    'jige' => $value->jige,
                ];
            }else{
                $data[$value->kaoshi_id]['chengji'][$value->bjSubject->lieming] = [
                    'cj_cnt' => $value->chengji_cnt,
                    'avg' => $value->avg,
                    'defenlv' => $value->defenlv,
                    'youxiu' => $value->youxiu,
                    'jige' => $value->jige,
                    'biaozhuncha' => $value->biaozhuncha,
                    'sifenwei' => [
                        'min' => $value->min,
                        'q1' => $value->q1,
                        'q2' => $value->q2,
                        'q3' => $value->mq3,
                        'max' => $value->max,
                    ],
                ];
            }
        }

        return $data;
    }




    // 本班级、X学科历次得分率。
    public function tiaoXing($cjlist,$subject){

        // 整理数据
        $data = array();
        $xAxis = array();
        $series = [
            0 => [
                'name'=>'班级得分率%',
                'type'=>'line',
                'data'=>array(),
            ],
            1 => [
                'name'=>'全部得分率%',
                'type'=>'line',
                'data'=>array(),
            ],
        ];


        foreach ($cjlist as $key => $value) {

            if($subject == $value->subject_id){
                $xAxis[] = $value->bjKaoshi->title;
                $series['0']['data'][] = $value->defenlv;
                $series['1']['data'][] = $value->quJieguo->defenlv;
            }
        }

        $data = [
            'xAxis' => $xAxis,
            'series' => $series,
            'legend' => ['班级得分率%','全部得分率%'],
        ];

        return $data;
    }


}
