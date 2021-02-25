<?php
declare (strict_types = 1);

namespace app\teach\model;

// 引用数据模型基类
use app\BaseModel;

/**
 * @mixin \think\Model
 */
class BanZhuRen extends BaseModel
{
    // 教师关联模型
    public function glAdmin()
    {
        return $this->belongsTo('\app\admin\model\Admin', 'teacher_id', 'id');
    }


    // 教师关联模型
    public function glBanji()
    {
        return $this->belongsTo('\app\teach\model\Banji', 'banji_id', 'id');
    }


    // 生日获取器
    public function getBfdateAttr($value)
    {
        return date('Y-m-d',$value);
    }


    // 生日修改器
    public function setBfdateAttr($value)
    {
        return strtotime($value);
    }


    // 查询任职结束时间
    public function getJieShuAttr()
    {
        $str = '现在';

        if($this->glBanji->biye === true)
        {
            $str = $this->glBanji->ruxuenian . '-8-1';
        }else{
            // 根据当前记录时间查询结束时间
            $js = $this
                ->where('banji_id', $this->banji_id)
                ->where('bfdate', '>', $this->getData('bfdate'))
                ->order(['bfdate' => 'asc'])
                ->find();
            if($js)
            {
                $str = $js->bfdate;
            }
        }

        return $str;
    }


    // 根据条件查询学期
    public function search($srcfrom)
    {
        // 整理变量
        $src = [
            'banji_id' => ''
            ,'teacher_id' => ''
            ,'bfdate' => ''
            ,'enddate' => ''
            ,'searchval' => ''
        ];

        $src = array_cover($srcfrom, $src) ;
        $src['banji_id'] = strToarray($src['banji_id']);
        $src['teacher_id'] = strToarray($src['teacher_id']);

        if(isset($srcfrom['bfdate']) && strlen($srcfrom['bfdate']) > 0)
        {
            $src['bfdate'] = $srcfrom['bfdate'];
        }else{
            $src['bfdate'] = date("Y-m-d", strtotime("-6 year"));
        }
        if(isset($srcfrom['enddate']) && strlen($srcfrom['enddate']) > 0)
        {
            $src['enddate'] = $srcfrom['enddate'];
        }else{
            $src['enddate'] = date("Y-m-d", strtotime('1 day'));
        }

        // 查询数据
        $data = $this
            ->whereTime('bfdate', 'between', [$src['bfdate'], $src['enddate']])
            ->when(count($src['banji_id']) > 0, function($query) use($src){
                    $query->where('banji_id', 'in', $src['banji_id']);
                })
            ->when(count($src['teacher_id']) > 0, function($query) use($src){
                    $query->where('teacher_id', 'in', $src['teacher_id']);
                })
            ->when(strlen($src['searchval']) > 0, function ($query) use($src) {
                $query->where('teacher_id', 'in', function ($q) use($src) {
                    $q->name('teacher')
                        ->where('xingming', 'like', '%'.$src['searchval'].'%')
                        ->field('id');
                });
            })
            ->with(
                [
                    'glAdmin'=>function($query){
                        $query->field('id, xingming');
                    },
                ]
            )
            ->order(['update_time' => 'desc'])
            ->select();

        return $data;
    }


    // 查询教师担任班主任情况
    public function srcTeacher($srcfrom)
    {
        // 整理变量
        $src = [
            'teacher_id' => ''
        ];
        $src = array_cover($srcfrom, $src) ;

        $data = $this->where('teacher_id', $src['teacher_id'])
            ->order(['update_time'=>'desc'])
            ->with([
                'glBanji' => function ($query) {
                    $query->field('id, ruxuenian, paixu')->append(['banJiTitle', 'biye']);
                }
            ])
            ->append(['jieShu'])
            ->select();
        return $data;
    }


    // 查询教师担任班主任情况
    public function srcTeacherNow($admin_id)
    {
        $teacher = $this->where('teacher_id', $admin_id)
                ->field('id, banji_id');
                ->order(['before'=>'desc'])
                ->find();
        $banji = $this->where('banji_id', $teacher->banji_id)
                ->order(['before'=>'desc'])
                ->field('id')
                ->find();
        if($teacher->id == $banji->id)
        {
            $banji_id = $teacher_id->banji_id;
        }else{
            $banji_id = 0;
        }
        return $banji_id;
    }

}
