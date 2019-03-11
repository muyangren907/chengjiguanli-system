<?php

namespace app\rongyu\model;

// 引用数据模型基类
use app\common\model\Base;

class JsRongyuInfo extends Base
{
    //搜索单位获奖荣誉
    public function search($search)
    {
        // 获取参数
    	$hjschool = $search['hjschool'];
    	$fzschool = $search['fzschool'];
    	$category = $search['category'];
        $rongyuce = $search['rongyuce'];
    	$order_field = $search['order_field'];
    	$order = $search['order'];
    	$category = $search['category'];
    	$search = $search['search'];


    	$data = $this->order([$order_field =>$order])
    		->when(strlen($hjschool)>0,function($query) use($hjschool){
                	$query->where('hjschool','in',$hjschool);
                })
    		->when(strlen($fzschool)>0,function($query) use($fzschool){
                    $query->where('rongyuce','in',function($q) use($fzschool){
                        $q->name('JsRongyu')->where('fzschool','in',$fzschool)->field('id');
                    });
                	
                })
    		->when(strlen($category)>0,function($query) use($category){
                	$query->where('rongyuce','in',function($q) use($category){
                        $q->name('JsRongyu')->where('category','in',$category)->field('id');
                    });
                })
    		->when(strlen($rongyuce)>0,function($query) use($rongyuce){
                	$query->where('rongyuce',$rongyuce);
                })
            ->when(strlen($search)>0,function($query) use($search){
                    $query->where('title','like',$search);
                })
            ->with(
                [
                    'hjSchool'=>function($query){
                        $query->field('id,jiancheng');
                    },
                    'rySubject'=>function($query){
                        $query->field('id,title');
                    },
                    'jxCategory'=>function($query){
                        $query->field('id,title');
                    },
                    'ryTuce'=>function($query){
                        $query->field('id,title');
                    },
                    'hjJsry'=>function($query){
                        $query->field('rongyuid,teacherid')
                        ->with(['teacher'=>function($query){
                            $query->field('id,xingming');
                        }]);
                    },
                ]
            )
            ->append(['hjJsName','cyJsName'])
    		->select();


    	return $data;
    }


    // 获取需要下载的荣誉信息
    public function srcTuceRy($id)
    {
        // 查询数据
        $data =$this->where('rongyuce',$id)
                ->field('id,rongyuce,title,bianhao,hjschool,subject,jiangxiang,hjshijian,pic')
                ->with([
                    'hjJsry'=>function($query){
                        $query->field('rongyuid,teacherid')
                        ->with(['teacher'=>function($query){
                            $query->field('id,xingming');
                        }]);
                    },
                    'cyJsry'=>function($query){
                        $query->field('rongyuid,teacherid')
                        ->with(['teacher'=>function($query){
                            $query->field('id,xingming');
                        }]);
                    },
                    'ryTuce'=>function($query){
                        $query->field('id,title,fzshijian,fzschool')
                        ->with(['fzSchool'=>function($q){
                            $q->field('id,title');
                        }]);
                    },
                    'rySubject'=>function($query){
                        $query->field('id,title');
                    },
                    'hjSchool'=>function($query){
                        $query->field('id,jiancheng');
                    },
                    'jxCategory'=>function($query){
                        $query->field('id,title');
                    }
                ])
                ->append(['hjJsName','cyJsName'])
                ->select();

        return $data;
    }


    // 荣誉图册关联
    public function ryTuce()
    {
        return $this->belongsTo('\app\rongyu\model\JsRongyu','rongyuce','id');
    }


    // 获奖单位关联
    public function hjSchool()
    {
         return $this->belongsTo('\app\system\model\School','hjschool','id');
    }

    // 颁奖单位关联
    public function fzSchool()
    {
         return $this->belongsTo('\app\system\model\School','fzschool','id');
    }

    // 荣誉所属学科
    public function rySubject()
    {
         return $this->belongsTo('\app\teach\model\Subject','subject','id');
    }

    // 奖项关联
    public function jxCategory()
    {
         return $this->belongsTo('\app\system\model\Category','jiangxiang','id');
    }

    // 获奖人关联
    public function hjJsry()
    {
        return $this->hasMany('\app\rongyu\model\JsRongyuCanyu','rongyuid','id')->where('category',1);
    }


    // 获奖人与参与教师关联
    public function allJsry()
    {
        return $this->hasMany('\app\rongyu\model\JsRongyuCanyu','rongyuid','id');
    }


    // 获奖人关联
    public function cyJsry()
    {
        return $this->hasMany('\app\rongyu\model\JsRongyuCanyu','rongyuid','id')->where('category',2);
    }


    // 荣誉级别
    public function getJibieAttr()
    {
        $jibie = '';

        if($this->fzschool){
            $jibie = $this->fzSchool->jibie;
        }
        
         return $jibie;   
    }


    // 发证时间修改器
    public function setHjshijianAttr($value)
    {
        return strtotime($value);
    }

    // 发证时间获取器
    public function getHjshijianAttr($value)
    {
        if ($value>0)
        {
            $value = date('Y-m-d',$value);
        }else{
            $value = "";
        }
        return $value;
    }

    // 获奖教师名整理
    public function getHjJsNameAttr($value)
    {
        $teacherList = $this->getAttr('hjJsry');
        $teachNames = teacherNames($teacherList);

        return $teachNames;

    }

    // 获奖教师名整理
    public function getCyJsNameAttr($value)
    {
        $teacherList = $this->getAttr('cyJsry');
        $teachNames = teacherNames($teacherList);

        return $teachNames;

    }
}
