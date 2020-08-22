<?php

namespace app\teacher\model;

use app\BaseModel;


class Teacher extends BaseModel
{
    //搜索单位获奖荣誉
    public function search($srcfrom)
    {
        $src = [
            'zhiwu_id' => array()
            ,'danwei_id' => array()
            ,'xueli_id' => array()
            ,'zhicheng_id' => array()
            ,'tuixiu' => 0
            ,'searchval' => ''
        ];
        // 用新值替换初始值
        $src = array_cover($srcfrom, $src);
        $src['zhiwu_id'] = strToArray($src['zhiwu_id']);
        $src['danwei_id'] = strToArray($src['danwei_id']);
        $src['xueli_id'] = strToArray($src['xueli_id']);
        $src['zhicheng_id'] = strToArray($src['zhicheng_id']);

        $data = $this->when(count($src['danwei_id']) > 0, function($query) use($src){
                    $query->where('danwei_id', 'in', $src['danwei_id']);
                })
            ->when(count($src['zhiwu_id']) > 0, function($query) use($src){
                    $query->where('zhiwu_id', 'in', $src['zhiwu_id']);
                })
            ->when(count($src['xueli_id']) > 0, function($query) use($src){
                    $query->where('xueli_id', 'in', $src['xueli_id']);
                })
            ->when(count($src['zhicheng_id']) > 0, function($query) use($src){
                    $query->where('zhicheng_id', 'in', $src['zhicheng_id']);
                })
            ->where('tuixiu', $src['tuixiu'])
            ->when(strlen($src['searchval']) > 0, function($query) use($src){
                    $query->where('xingming|shoupin', 'like', '%' . $src['searchval'] . '%');
                })
            ->with(
                [
                    'jsDanwei' => function($query){
                        $query->field('id, jiancheng');
                    },
                    'jsZhiwu' => function($query){
                        $query->field('id, title');
                    },
                    'jsZhicheng' => function($query){
                        $query->field('id, title');
                    },
                    'jsXueli' => function($query){
                        $query->field('id, title');
                    },
                    'jsSubject' => function($query){
                        $query->field('id, title');
                    },
                ]
            )
            ->append(['age', 'gongling'])
            ->select();



        return $data;
    }


    //搜索单位获奖荣誉
    public function searchDel($srcfrom)
    {
        $src = [
            'danwei_id' => array()
            ,'zhiwu_id' => array()
            ,'xueli_id' => array()
            ,'searchval' => ''
        ];
        // 用新值替换初始值
        $src = array_cover($srcfrom, $src);
        $src['zhiwu_id'] = strToArray($src['zhiwu_id']);
        $src['danwei_id'] = strToArray($src['danwei_id']);
        $src['xueli_id'] = strToArray($src['xueli_id']);

        $data = $this::onlyTrashed()
            ->when(count($src['danwei_id']) > 0, function($query) use($src){
                    $query->where('danwei_id','in',$src['danwei_id']);
                })
            ->when(count($src['zhiwu_id']) > 0, function($query) use($src){
                    $query->where('zhiwu_id','in',$src['zhiwu_id']);
                })
            ->when(count($src['xueli_id']) > 0, function($query) use($src){
                    $query->where('xueli_id','in',$src['xueli_id']);
                })
            ->when(strlen($src['searchval']) > 0, function($query) use($src){
                    $query->where('xingming|quanpin|shoupin', 'like', '%' . $src['searchval'] . '%');
                })
            ->with(
                [
                    'jsDanwei'=>function($query){
                        $query->field('id, jiancheng');
                    },
                    'jsZhiwu'=>function($query){
                        $query->field('id, title');
                    },
                    'jsZhicheng'=>function($query){
                        $query->field('id, title');
                    },
                    'jsXueli'=>function($query){
                        $query->field('id, title');
                    },
                    'jsSubject'=>function($query){
                        $query->field('id, title');
                    },
                ]
            )
            ->append(['age', 'gongling'])
            ->select();

        return $data;
    }


    // 表格导入教师信息
    public function createAll($arr, $School_id)
    {
        $pinyin = new \Overtrue\Pinyin\Pinyin;

        // 整理表格数据
        array_splice($arr, 0, 4); # 删除标题行
        $arr = array_filter($arr,function($item){ #过滤空值
                return $item[1] !== null && $item[2] !== null && $item[3] !== null ;
            });

        // 组合需要保存的数据
        $i = 0;
        $teacherlist = array();
        foreach ($arr as $key => $value) {
            $teacherlist[$i]['xingming'] = $value[1];
            $teacherlist[$i]['sex'] = $this->cutStr($value[2]);
            $teacherlist[$i]['shengri'] = $value[3];
            $teacherlist[$i]['worktime'] = $value[4];
            $teacherlist[$i]['zhiwu_id'] = $this->cutStr($value[5]);
            $teacherlist[$i]['zhicheng_id'] = $this->cutStr($value[6]);
            $teacherlist[$i]['danwei_id'] = $School_id;
            $teacherlist[$i]['biye'] = $value[8];
            $teacherlist[$i]['subject_id'] = $this->cutStr($value[7]);
            $teacherlist[$i]['zhuanye'] = $value[9];
            $teacherlist[$i]['xueli_id'] = $this->cutStr($value[10]);
            $quanpin = $pinyin->sentence($value[1]);
            $jianpin = $pinyin->abbr($value[1]);
            $teacherlist[$i]['quanpin'] = trim(strtolower(str_replace(' ', '', $quanpin)));
            $teacherlist[$i]['shoupin'] = trim(strtolower($jianpin));
            $i++;
        }

        $teacherlist = array_filter($teacherlist, function($q){ ## 过滤姓名、身份证号或班级为空的数据
            return $q['sex'] != null && $q['zhiwu_id'] != null && $q['zhicheng_id'] != null && $q['subject_id'] != null  && $q['xueli_id'] != null;
        });

        // 保存或更新信息
        $data = $this->saveAll($teacherlist);

        return true;
    }


    // 根据姓名、首拼查询教师
    public function strSrcTeachers($srcfrom)
    {
        $src = [
            'str' => ''
            ,'danwei_id' => ''
        ];
        $src = array_cover($srcfrom, $src);
        // 如果有数据则查询教师信息
        $list = self::field('id, xingming, danwei_id, shengri, sex')
            ->whereOr('xingming', 'like', '%' . $src['str'] . '%')
            ->whereOr('shoupin', 'like', $src['str'] . '%')
            ->when(strlen($src['danwei_id']) > 0, function ($query) use($src) {
                $query->where('danwei_id', $src['danwei_id']);
            })
            ->with(
                [
                    'jsDanwei' => function($query){
                        $query->field('id, jiancheng');
                    },
                ]
            )
            ->append(['age'])
            ->select();

        return $list;
    }


    // 查询教师荣誉
    public function srcRongyu($teacher_id)
    {
        // 实例化荣誉数据模型
        $ry = new \app\rongyu\model\JsRongyuInfo;

        // 查询荣誉信息
        $data = $ry->where('status', 1)
            ->where('id', 'in', function($query) use($teacher_id){
                $query->name('jsRongyuCanyu')
                    ->where('teacher_id', $teacher_id)
                    ->field('rongyu_id');
            })
            ->with(
            [
                'jxCategory'=>function($query){
                    $query->field('id, title');
                },
                'ryTuce'=>function($query){
                    $query->field('id, title, fzschool_id, category_id')
                        ->with([
                                'fzSchool'=>function($query){
                                    $query->field('id, jiancheng, jibie_id')
                                    ->with(['dwJibie' => function($q){
                                        $q->field('id, title');
                                    }]);
                                },
                                'lxCategory'=>function($query){
                                    $query->field('id, title');
                                },

                            ]);
                },
                'hjJsry'=>function($query){
                    $query->field('rongyu_id, teacher_id')
                    ->with(['teacher'=>function($query){
                        $query->field('id, xingming');
                    }]);
                },
            ])
            ->field('id, rongyuce_id, jiangxiang_id, hjshijian, title')
            ->order('hjshijian')
            ->select();
        return $data;
    }


    // 职务关联模型
    public function jsZhiwu()
    {
        return $this->belongsTo('\app\system\model\Category', 'zhiwu_id', 'id');
    }


    // 职称关联模型
    public function jsZhicheng()
    {
        return $this->belongsTo('\app\system\model\Category', 'zhicheng_id', 'id');
    }


    // 学历关联模型
    public function jsXueli()
    {
        return $this->belongsTo('\app\system\model\Category', 'xueli_id', 'id');
    }


    // 单位关联模型
    public function jsDanwei()
    {
        return $this->belongsTo('\app\system\model\School', 'danwei_id', 'id');
    }


    // 学科关联模型
    public function jsSubject()
    {
        return $this->belongsTo('\app\teach\model\Subject', 'subject_id', 'id');
    }


    // 生日修改器
    public function setShengriAttr($value)
    {
        return strtotime($value);
    }


    // 生日获取器
    public function getShengriAttr($value)
    {
        return date('Y-m-d', $value);
    }


    // 参加工作时间获取器
    public function getWorktimeAttr($value)
    {
    	return date('Y-m-d', $value);
    }


    // 参加工作时间修改器
    public function setWorktimeAttr($value)
    {
    	return strtotime($value);
    }


    // 性别获取器
    public function getSexAttr($value)
    {
        $sex = array('0' => '女', '1' => '男', '2' => '未知');
        return $sex[$value];
    }


    // 退休获取器
    public function getTuixiuAttr($value)
    {
        $sex = array('0' => '否', '1' => '是', '2' => '未知');
        return $sex[$value];
    }


    // 年龄获取器
    public function getAgeAttr()
    {
        return $this->fBirth($this->getdata('shengri'), 2);
    }


    // 工龄获取器
    public function getGonglingAttr()
    {
        return $this->fBirth($this->getdata('worktime'), 2);
    }


    // 分割表格上传数据
    private function cutStr($value)
    {
        $value = explode('|', $value);
        $str = '';
        if(isset($value[1]) && $value >0 )
        {
            $str = $value[1];
        }

        return $str;
    }


    /**
    * $date是时间戳
    * $type为1的时候是虚岁,2的时候是周岁
    */
    function fBirth($date = 0, $type = 1){
        $nowYear = date("Y", time());
        $nowMonth = date("m", time());
        $nowDay = date("d", time());
        $birthYear = date("Y", $date);
        $birthMonth = date("m", $date);
        $birthDay = date("d", $date);
        if($type == 1){
            $age = $nowYear - ($birthYear - 1);
        }elseif($type == 2){
            if($nowMonth < $birthMonth){
                $age = $nowYear - $birthYear - 1;
            }elseif($nowMonth == $birthMonth){
                if($nowDay < $birthDay){
                    $age = $nowYear - $birthYear - 1;
                }else{
                    $age = $nowYear - $birthYear;
                }
            }else{
                $age = $nowYear - $birthYear;
            }
        }
       return $age;
    }
}
