<?php

namespace app\chengji\model;

// 引用基类
use \app\BaseModel;


class Chengji extends BaseModel
{
    // 学科关联
    public function subjectName()
    {
        return $this->belongsTo('\app\teach\model\Subject','subject_id','id');
    }


    // 学科关联
    public function userName()
    {
        return $this->belongsTo('\app\admin\model\Admin','user_id','id');
    }


    // 考号关联
    public function cjKaohao()
    {
        return $this->belongsTo('\app\kaohao\model\Kaohao','kaohao_id','id');
    }


    // 查询成绩
    public function searchBase($srcfrom)
    {
        // 初始化参数
        $src = array(
            'kaoshi_id' => ''
            ,'banji_id' => array()
            ,'subject_id' => ''
            ,'searchval' => ''
            ,'user_id' => ''
        );
        $src = array_cover($srcfrom, $src) ;
        $src['kaoshi_id'] = strToarray($src['kaoshi_id']);
        $src['banji_id'] = strToarray($src['banji_id']);
        $src['subject_id'] = strToarray($src['subject_id']);

        $khid = array();
        if(count($src['kaoshi_id']) > 0 || count($src['banji_id']) > 0 || strlen($src['searchval']) > 0)
        {
            $kh = new \app\kaohao\model\Kaohao;
            $khid = $kh
                ->when(count($src['kaoshi_id']) > 0, function ($query) use($src){
                    $query->where('kaoshi_id', 'in', $src['kaoshi_id']);
                })
                ->when(count($src['banji_id']) > 0, function ($query) use($src){
                    $query->where('banji_id', 'in', $src['banji_id']);
                })
                ->when(strlen($src['searchval']) > 0, function ($query) use($src){
                    $query->where('student_id', 'in', function ($q) use($src) {
                        $q->name('student')
                            ->where('xingming', 'like', '%' . $src['searchval'] . '%')
                            ->field('id');
                    });
                })
                ->column('id');
        }

        $cjList = $this
            ->when(count($src['kaoshi_id']) == 0 && count($src['banji_id']) ==0, function($query) {
                $query->whereMonth('update_time');
            })
            ->when(strlen($src['user_id']) > 0, function ($query) use($src){
                $query->where('user_id', $src['user_id']);
            })
            ->when(count($src['subject_id']) > 0, function ($query) use ($src) {
                $query->where('subject_id', 'in', $src['subject_id']);
            })
            ->when(count($khid) > 0, function ($query) use ($khid) {
                $query->where('kaohao_id', 'in', $khid);
            })
            ->with([
                'subjectName' => function($query){
                    $query->field('id, title, lieming');
                }
                ,'cjKaohao' => function($query){
                    $query->field('id, kaoshi_id, school_id, ruxuenian, nianji, banji_id, paixu, student_id')
                        ->append(['banjiTitle'])
                        ->with([
                            'cjSchool' => function($query){
                                $query->field('id, jiancheng, paixu');
                            }
                            ,'cjStudent' => function($query){
                                $query->field('id, xingming, sex');
                            }
                            ,'cjKaoshi' => function($query){
                                $query->field('id, title');
                            }
                        ]);
                }
            ])
            ->select();

        return $cjList;
    }


    // 列出已录成绩列表
    public function searchLuru($srcfrom)
    {
        $nianji = nianJiNameList();
        $cjList = $this->searchBase($srcfrom);

        // 重新整理成绩
        $data = array();
        foreach ($cjList as $key => $value) {
            $data[$key] = [
                'id' => $value->id
                ,'kaoshi_title' => $value->cjKaohao->cjKaoshi->title
                ,'kaoshi_id' => $value->cjKaohao->cjKaoshi->id
                ,'kaohao_id' => $value->cjKaohao->id
                ,'school_jiancheng' => $value->cjKaohao->cjSchool->jiancheng
                ,'school_id' => $value->cjKaohao->cjSchool->paixu
                ,'banji_title' => $value->cjKaohao->banjiTitle
                ,'banji_id' => $value->cjKaohao->banji_id
                ,'subject_title' => $value->subjectName->title
                ,'subject_id' => $value->subjectName->id
                ,'subject_lieming' => $value->subjectName->lieming
                ,'defen' => $value->defen
                ,'status' => $value->status
                ,'update_time' => $value->update_time
            ];
            $value->cjKaohao->cjStudent ? $data[$key]['student_name']=$value->cjKaohao->cjStudent->xingming : $data[$key]['student_name']= '';
        }

        return $data;
    }


    // 列出已录成绩列表
    public function searchTeacher($srcfrom)
    {
        $nianji = nianJiNameList();
        $cjList = $this->searchBase($srcfrom);

        // 重新整理成绩
        $data = array();
        foreach ($cjList as $key => $value) {
            $data[$key] = [
                'id' => $value->id
                ,'kaohao_id' => $value->cjKaohao->id
                ,'student' => $value->cjKaohao->cjStudent->xingming
                ,'subject_title' => $value->subjectName->title
                ,'subject_id' => $value->subjectName->id
                ,'banji_title' => $value->cjKaohao->banjiTitle
                ,'subject_lieming' => $value->subjectName->lieming
                ,'defen' => $value->defen
                ,'defenlv' => $value->defenlv
                ,'bweizhi' => $value->bweizhi
                ,'xweizhi' => $value->xweizhi
            ];
            $value->cjKaohao->cjStudent ? $data[$key]['student_name']=$value->cjKaohao->cjStudent->xingming : $data[$key]['student_name']= '';
        }

        return $data;
    }


    // 根据条件查询学生所有学科成绩
    public function search($srcfrom)
    {
        // 初始化参数
        $src = array(
            'kaoshi_id' => ''
            ,'banji_id' => array()
            ,'searchval' => ''
        );
        $src = array_cover($srcfrom, $src);

        // 实例化考号数据模型
        $khSrc = new \app\kaohao\model\SearchMore;
        $chengjilist = $khSrc->srcChengjiList($src);

        return $chengjilist;
    }


    // 成绩排序
    public function saveOrder($cj, $col)
    {
        $cnt = count($cj);      # 获取元素数量
        if ($cnt == 0) {
            return true;
        }

        arsort($cj);
        $khids = array_keys($cj);   # 获取考号即键值
        $data = array();    # 新数据容器

        foreach ($khids as $key => $value) {
            $data[$key]['id'] = $value;
            $data[$key][$col[0]] = $key +1 ;
            if($key > 0 && $cj[$khids[$key-1]] == $cj[$value])
            {
                $data[$key][$col[0]] = $data[$key-1][$col[0]];
            }
            $data[$key][$col[1]] = 1 - ($data[$key][$col[0]]-1)/$cnt;
            $data[$key][$col[1]] = round($data[$key][$col[1]] * 100 , 2) ;
        }
        $temp = $this->saveAll($data);

        return true;
    }

}
