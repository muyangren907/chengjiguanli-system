<?php
// 命令空间
namespace app\kaohao\model;

// 引用数据模型基类
use app\BaseModel;

class Kaohao extends BaseModel
{
    // 列出成绩原始数据，其它数据模型中的方法以此方法为基础进行数据整理
    public function search($srcfrom)
    {
        // 初始化参数
        $src = array(
            'kaoshi_id' => '0'
            ,'banji_id' => array()
            ,'searchval' => ''
        );

        // 用新值替换初始值
        $src = array_cover($srcfrom, $src) ;
        $src['banji_id'] = strToarray($src['banji_id']);

        // 查询成绩
        $data = $this->where('kaoshi_id', $src['kaoshi_id'])
            ->field('id, school_id, student_id, ruxuenian, paixu, kaoshi_id, nianji, banji_id')
            ->where('banji_id', 'in', $src['banji_id'])
            ->when(strlen($src['searchval']) > 0, function($query) use($src){
                $query->where(function($w) use ($src){
                    $w
                    ->whereOr('student_id', 'in', function($q)use($src){
                        $q->name('student')
                            ->where('xingming', 'like', '%' . $src['searchval'] . '%')
                            ->field('id');
                    });
                });
            })
            ->with([
                'ksChengji' => function($query){
                    $query->field('id, kaohao_id, subject_id, defen');
                }
                ,'cjSchool' => function($query){
                    $query->field('id, jiancheng');
                }
                ,'cjStudent' => function($query){
                    $query->field('id, xingming, sex');
                }
            ])
            ->append(['banjiTitle', 'banTitle'])
            ->select();

        return $data;
    }


    // 班级成绩关联
    public function banjiKaohao()
    {
        return $this->hasMany('\app\kaohao\model\Kaohao', 'banji_id', 'banji_id');
    }


    // 学校信息关联表
    public function cjSchool()
    {
    	return $this->belongsTo('\app\system\model\School', 'school_id', 'id');
    }


    // 班级信息关联表
    public function cjBanji()
    {
    	return $this->belongsTo('\app\teach\model\Banji', 'banji_id', 'id');
    }


    // 学生信息关联
    public function cjStudent()
    {
    	return $this->belongsTo('\app\renshi\model\Student', 'student_id', 'id');
    }


    // 考试关联
    public function cjKaoshi()
    {
    	return $this->belongsTo('\app\kaoshi\model\Kaoshi', 'kaoshi_id', 'id');
    }


    // 考试成绩
    public function ksChengji()
    {
        return $this->hasMany('\app\chengji\model\Chengji', 'kaohao_id', 'id');
    }


    // 获取参加考试的班级全名
    public function getBanjiTitleAttr()
    {
        $bj = banJiNamelist();
        $title = $this->getAttr('nianji') . self::getBanTitleAttr();
        return $title;
    }


    // 获取不带年级的班级名
    public function getBanTitleAttr()
    {
        // 获取班级名显示样式
        $sys = new \app\system\model\SystemBase;
        $alias = $sys->order('id')->value('classalias');
        if($alias == true)
        {
            $bj = new \app\teach\model\Banji;
            $title = $bj->where('id', $this->getAttr('banji_id'))->value('alias');

            if($title == '')
            {
                $bj = banJiNamelist();
                $title = $bj[$this->getAttr('paixu')];
            }else{
                $title = $title . '班';
            }
        }else{
            $bj = banJiNamelist();
            $title = $bj[$this->getAttr('paixu')];
        }
        return $title;
    }

}





