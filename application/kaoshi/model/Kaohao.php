<?php
// 命令空间
namespace app\kaoshi\model;

// 引用数据模型基类
use app\common\model\Base;

class Kaohao extends Base
{
    //查询考试成绩
    public function srcKaohao($kaoshi,$banji)
    {
        // 获取考试信息
        $data = $this->where('kaoshi',$kaoshi)
                    ->where('banji','in',$banji)
                    ->field('id,banji,school')
                    ->order(['banji'])
                    ->group('banji')
                    ->with([
                        'cjBanji'=>function($query){
                            $query->field('id,paixu,ruxuenian')
                                ->append(['numTitle','banjiTitle']);
                        }
                        ,'cjSchool'=>function($query){
                            $query->field('id,jiancheng');
                        }
                        ,'banjiKaohao'=>function($query){
                            $query->field('id,banji,student,kaoshi,school')
                                ->order(['banji','id'])
                                ->with([
                                    'cjStudent'=>function($q){
                                        $q->field('id,xingming');
                                    }
                            ]);
                        }
                    ])
                    ->select();
        return $data;
    }


    // 查询学生成绩
    public function srcChengji($src)
    {
        $data = $this->where('kaoshi',$src['kaoshi'])
                ->field('id,school,student,nianji,banji')
                ->with([
                    'ksChengji'=>function($query){
                        $query->field('kaohao_id,subject_id,defen')
                            ->with([
                                'subjectName'=>function($q){
                                    $q->field('id,lieming');
                                }
                            ]);
                    }
                    ,'cjBanji'=>function($query){
                        $query->field('id,paixu,ruxuenian')
                            ->append(['numTitle','banjiTitle']);
                    }
                    ,'cjSchool'=>function($query){
                        $query->field('id,jiancheng');
                    }
                ])
                ->order([$src['field'] =>$src['order']])
                ->select();

        return $data;
    }

    // 满分
    public function banjiKaohao()
    {
        return $this->hasMany('\app\kaoshi\model\Kaohao','banji','banji');
    }

    // 学校信息关联表
    public function cjSchool()
    {
    	return $this->belongsTo('\app\system\model\School','school','id');
    }

    // 班级信息关联表
    public function cjBanji()
    {
    	return $this->belongsTo('\app\teach\model\Banji','banji','id');
    }

    // 学生信息关联
    public function cjStudent()
    {
    	return $this->belongsTo('\app\renshi\model\Student','student','id');
    }

    // 满分
    public function cjManfen()
    {
    	return $this->hasMany('\app\kaoshi\model\KaoshiSubject','kaoshiid','kaoshi');
    }

    // 考试关联
    public function cjKaoshi()
    {
    	return $this->belongsTo('\app\kaoshi\model\Kaoshi','kaoshi','id');
    }


    // 考试成绩
    public function ksChengji()
    {
        return $this->hasMany('\app\chengji\model\Chengji','kaohao_id','id');
    }
}
