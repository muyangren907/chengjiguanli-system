<?php

namespace app\kaoshi\model;

// 引用数据模型基类
use app\BaseModel;

class KaoshiSet extends BaseModel
{
    // 关联学科
    public function subjectName()
    {
    	return $this->belongsTo('\app\teach\model\Subject', 'subject_id', 'id');
    }


    // 查询参加考试学科
    public function search($srcfrom = array())
    {
    	// 初始化参数
        $src = array(
            'kaoshi_id' => '0'
            ,'nianji' => array()
            ,'subject_id' => array()
            ,'searchval' => ''
        );
        $src = array_cover($srcfrom, $src);
        $src['nianji'] = strToarray($src['nianji']);
        $src['subject_id'] = strToarray($src['subject_id']);

        $data = $this->where('kaoshi_id', $src['kaoshi_id'])
            ->when(count($src['nianji']) > 0, function($query) use($src){
                $query->where('nianji', 'in', $src['nianji']);
            })
            ->when(count($src['subject_id']) > 0, function($query) use($src){
                $query->where('subject_id', 'in', $src['subject_id']);
            })
        	->with([
        		'subjectName' => function($query){
        			$query->field('id, title, jiancheng');
        		}
        	])
        	->select();

        return $data;

    }


    /**
     * 查询参加考试学科
     *
     * @return \think\Response
     */
    // 显示考试列表
    public function srcSubject($kaoshi_id, $subject_id = array(), $nianji = '')
    {
        $subject_id = strToarray($subject_id);

        $sbjList = $this->where('kaoshi_id', $kaoshi_id)
            ->when(count($subject_id) > 0, function($query) use($subject_id){
                $query->where('subject_id', 'in', $subject_id);
            })
            ->when($nianji > 0, function($query) use($nianji){
                $query->where('nianji', $nianji);
            })
            ->group('subject_id')
            ->field("subject_id
                ,any_value(manfen) as manfen
                ,any_value(youxiu) as youxiu
                ,any_value(jige) as jige")
            ->with([
                'subjectName'=>function($query){
                    $query->field('id, title, jiancheng, paixu, lieming');
                }
            ])
            ->where('status', 1)
            ->select();


        // 重新整理学科信息
        $data = array();
        foreach ($sbjList as $key => $value) {
            # code...
            $data[$value->subjectName->id] = [
                'id'=>$value->subjectName->id,
                'title'=>$value->subjectName->title,
                'jiancheng'=>$value->subjectName->jiancheng,
                'paixu'=>$value->subjectName->paixu,
                'lieming'=>$value->subjectName->lieming,
                'fenshuxian'=>[
                    'manfen'=>$value->manfen,
                    'youxiu'=>$value->youxiu,
                    'jige'=>$value->jige,
                ],
            ];
        }

        // 按条件排序
        if(count($data)>0){
            $data = sortArrByManyField($data,'paixu',SORT_ASC);
        }
        return $data;
    }


    /**
     * 查询参加考试年级
     *
     * @return \think\Response
     */
    // 显示考试列表
    public function srcNianji($kaoshi)
    {
        $njList = $this->where('kaoshi_id',$kaoshi)
            ->group('nianji')
            ->field("nianji
                ,any_value(nianjiname) as nianjiname")
            // ->cache(true)
            ->select();

        // 重新整理学科信息
        $data = array();
        foreach ($njList as $key => $value) {
            # code...
            $data[] = [
                'nianji'=>$value->nianji,
                'nianjiname'=>$value->nianjiname
            ];
        }
        // 按条件排序
        if(count($data)>0){
            $data = sortArrByManyField($data,'nianji',SORT_ASC);
        }
        return $data;
    }


}
