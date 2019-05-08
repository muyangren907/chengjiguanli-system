<?php
// 命令空间
namespace app\kaoshi\model;

// 引用数据模型基类
use app\common\model\Base;

class Kaohao extends Base
{
    //查询考试成绩
    public function srcBiaoqian($kaoshi,$banji)
    {
        // 获取考试标签
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


    // 查询学生成绩录入表
    public function srcKaohao($src)
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


    // 查询学生成绩
    public function srcChengji($src)
    {
        $school = $src['school'];
        $nianji = $src['nianji'];
        $paixu = $src['paixu'];

        $khlist = $this->where('kaoshi',$src['kaoshi'])
                ->field('id,school,student,nianji,banji')
                ->when(count($school)>0,function($query) use($school){
                    $query->where('school','in',$school);
                })
                ->when(count($paixu)>0,function($query) use($paixu){
                    $query->where('banji','in',function($q) use($paixu){
                        $q->name('banji')->where('paixu','in',$paixu)->field('id');
                    });
                })
                ->when(count($nianji)>0,function($query) use($nianji){
                    $query->where('nianji','in',$nianji);
                })
                ->with([
                    'ksChengji'=>function($query){
                        $query->field('kaohao_id,subject_id,defen');
                    }
                    ,'cjBanji'=>function($query){
                        $query->field('id,paixu,ruxuenian')
                            ->append(['numTitle','banjiTitle']);
                    }
                    ,'cjSchool'=>function($query){
                        $query->field('id,jiancheng');
                    }
                    ,'cjStudent'=>function($query){
                        $query->field('id,xingming');
                    }
                ])
                ->select();
        // 获取参考学科
        $kaoshi = new \app\kaoshi\model\Kaoshi;
        $ksinfo = $kaoshi->where('id',$src['kaoshi'])
                    ->with([
                        'ksSubject'=>function($query){
                            $query->field('kaoshiid,subjectid,lieming');
                        }
                    ])
                    ->find();
        $xk = array();
        foreach ($ksinfo->ks_subject as $key => $value) {
            $xk[$value->subjectid] = $value->lieming;
        }

        // 整理数据
        $data = array();
        foreach ($khlist as $key => $value) {
            $data[$key]['id'] = $value->id;
            $data[$key]['school'] = $value->cj_school->jiancheng;
            $data[$key]['student'] = $value->cj_student->xingming;
            $data[$key]['nianji'] = $value->nianji;
            $data[$key]['banji'] = $value->cj_banji->num_title;
            foreach ($value->ks_chengji as $k => $val) {
                $data[$key][$xk[$val->subject_id]] = $val->defen;
            }
        }

        // dump($data);

        $src['type'] == 'asc' ? $sort='SORT_ASC' : $sort='SORT_DESC';

        // 按条件排序
        if(count($data)>0){
            $data = arraySequence($data,$src['field'],$sort); //排序
        }
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
