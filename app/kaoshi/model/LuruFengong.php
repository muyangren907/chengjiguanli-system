<?php

namespace app\kaoshi\model;

// 引用数据模型基类
use \app\BaseModel;

/**
 * @mixin \think\Model
 */
class LuruFengong extends BaseModel
{
    // 查询统计记录
    public function search($srcfrom)
    {
        $src = [
            'kaoshi_id' => ''
            ,'banji_id' => ''
            ,'subject_id' => ''
            ,'ruxuenian' => ''
            ,'searchval' => ''
        ];
        $src = array_cover($srcfrom, $src) ;
        $src['kaoshi_id'] = strToarray($src['kaoshi_id']);
        $src['banji_id'] = strToarray($src['banji_id']); 

        $logList = self::where('kaoshi_id', 'in', $src['kaoshi_id'])
        			->when(count($src['banji_id']) > 0, function($query) use($src){
                        $query->where('banji_id', 'in', $src['banji_id']);
                    })
                    ->when(count($src['subject_id']) > 0, function($query) use($src){
                        $query->where('subject_id', 'in', $src['subject_id']);
                    })
        			->when(strlen($src['searchval']) > 0, function($query) use($src){
                        $query->where('admin_id', 'in', function ($q) use($src) {
                            $q->name('admin')
                                ->where('xingming', 'like', '%'. $src['searchval'] . '%')
                                ->field('id');
                        });
                    })
                    ->when(strlen($src['ruxuenian']) > 0, function($query) use($src){
                        $query->where('banji_id', 'in', function ($q) use($src) {
                            $q->name('banji')
                                ->where('ruxuenian', $src['ruxuenian'])
                                ->field('id');
                        });
                    })
                    ->with([
                        'fgKaoshi' => function ($query) {
                            $query->field('id, title');
                        }
                        ,'fgBanji' => function ($query) {
                            $query->field('id, ruxuenian, paixu, school_id')
                            	->with([
                            		'glSchool' => function($q){
				                        $q->field('id, title, jiancheng');
				                    },
                            	])
                            	->append(['banjiTitle']);
                        }
                        ,'fgSubject' => function ($query) {
                            $query->field('id, title, jiancheng');
                        }
                        ,'fgAdmin' => function ($query) {
                            $query->field('id, xingming');
                        }
                    ])
                    ->select();

        return $logList;
    }


    // 根据教师ID查询可以录入成绩的班级
    public function srcMyLuruBanji($srcfrom)
    {
        $src = [
            'kaoshi_id' => ''
        ];
        $src = array_cover($srcfrom, $src) ;
        $admin_id = session('user_id');
        $data = $this->where('user_id', $admin_id)
                ->where('kaoshi_id', $src['kaoshi_id'])
                ->->group('banji_id')
                ->column(['banji_id']);
        return $data;
    }


    // 考试关联表
    public function fgKaoshi()
    {
        return $this->belongsTo('\app\kaoshi\model\Kaoshi', 'kaoshi_id', 'id');
    }


    // 班级关联表
    public function fgBanji()
    {
        return $this->belongsTo('\app\teach\model\Banji', 'banji_id', 'id');
    }


    // 学科关联表
    public function fgSubject()
    {
        return $this->belongsTo('\app\teach\model\Subject', 'subject_id', 'id');
    }


    // 考试关联表
    public function fgAdmin()
    {
        return $this->belongsTo('\app\admin\model\Admin', 'admin_id', 'id');
    }


}
