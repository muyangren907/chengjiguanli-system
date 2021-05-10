<?php
// 命令空间
namespace app\kaohao\model;

// 引用数据模型基类
use \app\BaseModel;

// 引用数据模型
use \app\kaohao\model\Kaohao as kh;

class SearchCanyu extends BaseModel
{
    // 获取参加考试学校
    public function school($srcfrom)
    {
        // 初始化参数
        $src = array(
            'kaoshi_id' => ''
            ,'ruxuenian' => ''
        );
        $src = array_cover($srcfrom, $src);
        $src['ruxuenian'] = strToarray($src['ruxuenian']);

        $kh = new kh;
        $schoolList = $kh->where('kaoshi_id', $src['kaoshi_id'])
            ->when(count($src['ruxuenian']) > 0, function($query) use($src){
                $query->where('ruxuenian', 'in', $src['ruxuenian']);
            })
            ->with(['cjSchool' => function($query){
                    $query->field('id, jiancheng, paixu, title')
                    ->order(['paixu' => 'asc']);
                }
            ])
            ->distinct(true)
            ->field('school_id')
            ->select();

        // 重新整理参加学校信息
        $data = array();
        foreach ($schoolList as $key => $value) {
            $data[] = [
                'paixu' => $value->cjSchool->paixu,
                'id' => $value->cjSchool->id,
                'title' => $value->cjSchool->title,
                'jiancheng' => $value->cjSchool->jiancheng,
            ];
        }

        if(count($data) > 0)
        {
            $data = \app\facade\Tools::sortArrByManyField($data, 'paixu', SORT_ASC);
        }

        return $data;
    }


    /**
    * 获取参加考试的班级
    * @access public
    * @param number $kaoshi 考试id
    * @param number $ruxuenian 入学年
    * @return array 返回班级数据模型
    */
    public function class($srcfrom)
    {
        // 初始化参数
        $src = array(
            'kaoshi_id' => ''
            ,'ruxuenian' => array()
            ,'school_id' => array()
            ,'banji_id' => array()
        );
        $src = array_cover($srcfrom, $src);
        $src['school_id'] = strToarray($src['school_id']);
        $src['banji_id'] = strToarray($src['banji_id']);
        $src['ruxuenian'] = strToarray($src['ruxuenian']);

        // 通过给定参数，从考号表中获取参加考试的班级
        $kh = new kh;
        $bjids = $kh
                ->where('kaoshi_id', $src['kaoshi_id'])
                ->when(count($src['ruxuenian'] ) > 0, function($query) use($src){
                    $query->where('ruxuenian', 'in', $src['ruxuenian'] );
                })
                ->when(count($src['school_id']) > 0, function($query) use($src){
                    $query->where('school_id', 'in', $src['school_id']);
                })
                ->when(count($src['banji_id']) > 0, function($query) use($src){
                    $query->where('banji_id', 'in', $src['banji_id']);
                })
                ->with([
                    'cjSchool' => function($query){
                        $query->field('id, jiancheng, title, paixu');
                    }
                ])
                ->field('banji_id
                    ,any_value(id) as id
                    ,any_value(nianji) as nianji
                    ,any_value(paixu) as paixu
                    ,any_value(school_id) as school_id')
                ->group('banji_id')
                ->append(['banjiTitle', 'banTitle'])
                ->select();

        $bj = new \app\teach\model\Banji;
        $data = array();
        foreach ($bjids as $key => $value) {
            $data[] = [
                'id'=>$value->banji_id,
                'paixu'=>$value->paixu,
                'schTitle'=>$value->cjSchool->title,
                'schJiancheng'=>$value->cjSchool->jiancheng,
                'schPaixu'=>$value->cjSchool->paixu,
                'banTitle'=>$value->banTitle,
                'banjiTitle'=>$value->banjiTitle,
            ];
        }
        if(count($data) > 0)
        {
            $data = \app\facade\Tools::sortArrByManyField($data, 'schPaixu', SORT_ASC, 'paixu', SORT_ASC);
        }

        return $data;
    }

}