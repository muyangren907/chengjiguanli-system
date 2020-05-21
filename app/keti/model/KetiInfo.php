<?php

namespace app\Keti\model;

// 引用数据模型基类
use app\BaseModel;

class KetiInfo extends BaseModel
{
    //搜索课题册
    public function search($srcfrom)
    {
    	$src = [
            'lxdanwei_id' => array()
            ,'lxcategory_id' => array()
            ,'fzdanwei_id' => array()
            ,'subject_id' => array()
            ,'category_id' => array()
            ,'jddengji_id' => array()
            ,'ketice_id' => ''
            ,'searchval' => ''
        ];
        // 用新值替换初始值
        $src = array_cover($srcfrom, $src);
        $src['lxdanwei_id'] = strToArray($src['lxdanwei_id']);
        $src['lxcategory_id'] = strToArray($src['lxcategory_id']);
        $src['fzdanwei_id'] = strToArray($src['fzdanwei_id']);
        $src['subject_id'] = strToArray($src['subject_id']);
        $src['category_id'] = strToArray($src['category_id']);
        $src['jddengji_id'] = strToArray($src['jddengji_id']);

    	$data = $this
    		->when(count($src['lxdanwei_id']) > 0, function($query) use($src){
                	$query->where('ketice_id', 'in', function ($q) use($src){
                        $q->name('keti')->where('lxdanwei_id', 'in', $src['lxdanwei_id'])->field('id');
                    });
                })
    		->when(count($src['lxcategory_id']) > 0, function($query) use($src){
                	$query->where('ketice_id', 'in', function($q) use($src){
                        $q->name('keti')->where('category_id', 'in', $src['lxcategory_id'])->field('id');
                    });
                })
    		->when(count($src['fzdanwei_id']) > 0, function($query) use($src){
                	$query->where('fzdanwei_id', 'in', $src['fzdanwei_id']);
                })
            ->when(count($src['subject_id']) > 0, function($query) use($src){
                    $query->where('subject_id', 'in', $src['subject_id']);
                })
            ->when(count($src['category_id']) > 0, function($query) use($src){
                    $query->where('category_id', 'in', $src['category_id']);
                })
            ->when(count($src['jddengji_id']) > 0, function($query) use($src){
                    $query->where('jddengji_id', 'in', $src['jddengji_id']);
                })
            ->when(strlen($src['ketice_id']) > 0, function($query) use($src){
                    $query->where('ketice_id', $src['ketice_id']);
                })
    		->when(strlen($src['searchval']) > 0, function($query) use($src){
                	$query->where('title', 'like', '%' . $src['searchval'] . '%');
                })
            ->with(
                [
                    'fzSchool' => function($query){
                        $query->field('id, jiancheng');
                    },
                    'KtCe' => function($query){
                        $query->field('id, lxdanwei_id, category_id, lxshijian')
                            ->with([
                                'ktCategory' => function($q){
                                    $q->field('id, title');
                                },
                                'ktLxdanwei' => function($q){
                                    $q->field('id, jiancheng');
                                }
                            ]);
                    },
                    'ktCategory' => function($query){
                        $query->field('id, title');
                    },
                    'ktSubject' => function($query){
                        $query->field('id, title');
                    },
                    'ktZcr' => function($query){
                        $query->field('ketiinfo_id, teacher_id')
                            ->with([
                                'teacher' => function($q){
                                    $q->field('id, xingming');
                                }
                            ]);
                    },
                    'ktCy' => function($query){
                        $query->field('ketiinfo_id, teacher_id')
                            ->with([
                                'teacher' => function($q){
                                    $q->field('id, xingming');
                                }
                            ]);
                    }
                    ,'ktJdDengji' => function($query){
                        $query->field('id, title');
                    }
                ])
    		->select();

    	return $data;
    }


    // 搜索教师参与的课题
    public function srcTeacherKeti($teacher_id)
    {
        // 查询信息
        $data = self::where('status', 1)
            ->where('id', 'in', function($query) use($teacher_id){
                $query->name('KetiCanyu')
                    ->where('teacher_id', $teacher_id)
                    ->field('ketiinfo_id');
            })
            ->with(
            [
                'fzSchool' => function($query){
                    $query->field('id, jiancheng, jibie_id')
                        ->with(['dwJibie' => function($q){
                            $q->field('id, title');
                        }]);
                },
                'ktCategory' => function($query){
                    $query->field('id, title');
                },
                  'ktZcr' => function($query){
                    $query->field('ketiinfo_id, teacher_id')
                        ->with([
                            'teacher' => function($q){
                                $q->field('id, xingming');
                            }
                        ]);
                },
                'ktJdDengji' => function($query){
                        $query->field('id, title');
                    }
            ])
            ->field('id, title, fzdanwei_id, category_id, jddengji_id, bianhao')
            ->order('id')
            ->select();

        return $data;
    }


    //搜索课题册
    public function srcKeti($ketice_id)
    {
        $data = $this
            ->where('ketice_id', $ketice_id)
            ->with(
                [
                    'fzSchool' => function($query){
                        $query->field('id, jiancheng');
                    },
                    'KtCe' => function($query){
                        $query->field('id, title, lxdanwei_id, category_id, lxshijian')
                            ->with([
                                'ktCategory' => function($q){
                                    $q->field('id, title');
                                },
                                'ktLxdanwei' => function($q){
                                    $q->field('id, jiancheng, title');
                                }
                            ]);
                    },
                    'ktCategory'=>function($query){
                        $query->field('id, title');
                    },
                    'ktSubject'=>function($query){
                        $query->field('id, title');
                    },
                    'ktZcr'=>function($query){
                        $query->field('ketiinfo_id, teacher_id')
                            ->with([
                                'teacher'=>function($q){
                                    $q->field('id, xingming');
                                }
                            ]);
                    },
                    'ktCy'=>function($query){
                        $query->field('ketiinfo_id, teacher_id')
                            ->with([
                                'teacher'=>function($q){
                                    $q->field('id, xingming');
                                }
                            ]);
                    }
                ]
            )
            ->select();

        return $data;
    }


    // 课题主持人关联
    public function ktZcr()
    {
        return $this->hasMany('\app\keti\model\KetiCanyu', 'ketiinfo_id', 'id')
            ->where('category_id', 11901);
    }


    // 课题参与人关联
    public function ktCy()
    {
        return $this->hasMany('\app\keti\model\KetiCanyu', 'ketiinfo_id', 'id')
            ->where('category_id', 11902);
    }


    // 立项单位关联
    public function fzSchool()
    {
         return $this->belongsTo('\app\system\model\School', 'fzdanwei_id','id');
    }


    // 研究类型关联
    public function ktCategory()
    {
         return $this->belongsTo('\app\system\model\Category', 'category_id', 'id');
    }


    // 所属学科关联
    public function ktSubject()
    {
         return $this->belongsTo('\app\system\model\Category', 'subject_id', 'id');
    }


    // 结题等级关联
    public function ktJdDengji()
    {
         return $this->belongsTo('\app\system\model\Category', 'jddengji_id', 'id');
    }


    // 课题册关联
    public function ktCe()
    {
         return $this->belongsTo('\app\keti\model\Keti', 'ketice_id', 'id');
    }


    // 计划结题时间修改器
    public function setJhjtshijianAttr($value)
    {
        return strtotime($value);
    }


    // 计划结题时间获取器
    public function getJhjtshijianAttr($value)
    {
        if ($value>0)
        {
            $value = date('Y-m-d', $value);
        }else{
            $value = "";
        }
        return $value;
    }


    // 结题时间修改器
    public function setJtshijianAttr($value)
    {
        return strtotime($value);
    }


    // 结题时间获取器
    public function getJtshijianAttr($value)
    {
        if ($value>0)
        {
            $value = date('Y-m-d', $value);
        }else{
            $value = "";
        }
        return $value;
    }
}
