<?php

namespace app\Keti\model;

// 引用数据模型基类
use app\common\model\Base;

class KetiInfo extends Base
{
    //搜索课题册
    public function search($src)
    {
    	// 获取参数
    	$lxdanweiid = $src['lxdanweiid'];
    	$lxcategory = $src['lxcategory'];
    	$fzdanweiid = $src['fzdanweiid'];
        $subject = $src['subject'];
        $category = $src['category'];
        $jddengji = $src['jddengji'];
        $ketice = $src['ketice'];
    	$searchval = $src['searchval'];

    	$data = $this
            ->order([$src['field'] =>$src['type']])
    		->when(count($lxdanweiid)>0,function($query) use($lxdanweiid){
                	$query->where('ketice','in',function ($q) use($lxdanweiid){
                        $q->name('keti')->where('lxdanweiid','in',$lxdanweiid)->field('id');
                    });
                })
    		->when(count($lxcategory)>0,function($query) use($lxcategory){
                	$query->where('ketice','in',function($q) use($lxcategory){
                        $q->name('keti')->where('category','in',$lxcategory)->field('id');
                    });
                })
    		->when(count($fzdanweiid)>0,function($query) use($fzdanweiid){
                	$query->where('fzdanweiid','in',$fzdanweiid);
                })
            ->when(count($subject)>0,function($query) use($subject){
                    $query->where('subject','in',$subject);
                })
            ->when(count($category)>0,function($query) use($category){
                    $query->where('category','in',$category);
                })
            ->when(count($jddengji)>0,function($query) use($jddengji){
                    $query->where('jddengji','in',$jddengji);
                })
            ->when(strlen($ketice)>0,function($query) use($ketice){
                    $query->where('ketice',$ketice);
                })
    		->when(strlen($searchval)>0,function($query) use($searchval){
                	$query->where('title','like',$searchval);
                })
            ->with(
                [
                    'fzSchool'=>function($query){
                        $query->field('id,jiancheng');
                    },
                    'KtCe'=>function($query){
                        $query->field('id,lxdanweiid,category,lxshijian')
                            ->with([
                                'ktCategory' => function($q){
                                    $q->field('id,title');
                                },
                                'ktLxdanwei' => function($q){
                                    $q->field('id,jiancheng');
                                }
                            ]);
                    },
                    'ktCategory'=>function($query){
                        $query->field('id,title');
                    },
                    'ktSubject'=>function($query){
                        $query->field('id,title');
                    },
                    'ktZcr'=>function($query){
                        $query->field('ketiinfoid,teacherid')
                            ->with([
                                'teacher'=>function($q){
                                    $q->field('id,xingming');
                                }
                            ]);
                    },
                    'ktCy'=>function($query){
                        $query->field('ketiinfoid,teacherid')
                            ->with([
                                'teacher'=>function($q){
                                    $q->field('id,xingming');
                                }
                            ]);
                    }
                ])
    		->select();


    	return $data;
    }


    //搜索课题册
    public function srcketi($ketice)
    {
        $data = $this
            ->order([$src['field'] =>$src['type']])
            ->where('ketice',$ketice)
            ->with(
                [
                    'fzSchool'=>function($query){
                        $query->field('id,jiancheng');
                    },
                    'KtCe'=>function($query){
                        $query->field('id,lxdanweiid,category,lxshijian')
                            ->with([
                                'ktCategory' => function($q){
                                    $q->field('id,title');
                                },
                                'ktLxdanwei' => function($q){
                                    $q->field('id,jiancheng');
                                }
                            ]);
                    },
                    'ktCategory'=>function($query){
                        $query->field('id,title');
                    },
                    'ktSubject'=>function($query){
                        $query->field('id,title');
                    },
                    'ktZcr'=>function($query){
                        $query->field('ketiinfoid,teacherid')
                            ->with([
                                'teacher'=>function($q){
                                    $q->field('id,xingming');
                                }
                            ]);
                    },
                    'ktCy'=>function($query){
                        $query->field('ketiinfoid,teacherid')
                            ->with([
                                'teacher'=>function($q){
                                    $q->field('id,xingming');
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
        return $this->hasMany('\app\keti\model\KetiCanyu','ketiinfoid','id')->where('category',1);
    }
    // 课题参与人关联
    public function ktCy()
    {
        return $this->hasMany('\app\keti\model\KetiCanyu','ketiinfoid','id')->where('category',2);
    }

    // 立项单位关联
    public function fzSchool()
    {
         return $this->belongsTo('\app\system\model\School','fzdanweiid','id');
    }


    // 研究类型关联
    public function ktCategory()
    {
         return $this->belongsTo('\app\system\model\Category','category','id');
    }


    // 所属学科关联
    public function ktSubject()
    {
         return $this->belongsTo('\app\system\model\Category','subject','id');
    }


    // 课题册关联
    public function ktCe()
    {
         return $this->belongsTo('\app\keti\model\Keti','ketice','id');
    } 



    // 结题等级获取器
    public function getJddengjiAttr($value)
    {
        // 结题数组
        $jtdj = array('0'=>'研究中','1'=>'合格','2'=>'优秀','3'=>'流失');
        // 获取结题鉴定等级
        $str =  $jtdj[$value];
        // 返回结题等级
        return $str;
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
            $value = date('Y-m-d',$value);
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
            $value = date('Y-m-d',$value);
        }else{
            $value = "";
        }
        return $value;
    }




}
