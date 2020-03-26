<?php

namespace app\keti\model;

// 引用数据模型基类
use app\BaseModel;


class Keti extends BaseModel
{
    //搜索课题册
    public function search($srcfrom)
    {
    	$src = [
            'lxdanwei_id' => array(),
            ,'category_id' => array(),
            ,'searchval' => ''
        ];
        $src = array_cover($srcfrom, $src);

    	$data = $this
    		->when(count($src['lxdanwei_id']) > 0, function($query) use($src){
                	$query->where('lxdanwei_id', 'in', $src['lxdanwei_id']);
                })
    		->when(count($src['category_id']) > 0, function($query) use($src){
                	$query->where('category_id', 'in', $src['category_id']);
                })
    		->when(strlen($src['searchval']) > 0, function($query) use($src){
                	$query->where('title', 'like', $src['searchval']);
                })
            ->with(
                [
                    'ktCategory' => function($query){
                        $query->field('id, title');
                    },
                    'ktLxdanwei' => function($query){
                        $query->field('id, title');
                    },
                ]
            )
            ->withCount(['ktInfo' => 'lxcount'], 'id')
            ->withCount(['ktInfo' => function($query){
                $query->where('jddengji_id', 'between', [11802, 11803]);
            }])
    		->select();

    	return $data;
    }


    // 类型关联
    public function ktCategory()
    {
    	return $this->belongsTo('\app\system\model\Category', 'category_id', 'id');
    }


    // 立项单位关联
    public function ktLxdanwei()
    {
    	return $this->belongsTo('\app\system\model\School', 'lxdanwei_id', 'id');
    }


    // 课题信息关联
    public function ktInfo()
    {
    	return $this->hasMany('KetiInfo', 'ketice_id', 'id');
    }


    // 立项时间获取器
    public function getLxshijianAttr($value)
    {
    	if ($value>0)
        {
            $value = date('Y-m-d', $value);
        }else{
            $value = "";
        }
        return $value;
    }


    // 立项时间
    public function setLxshijianAttr($value)
    {
    	return strtotime($value);
    }


    // 课题数量
    public function getKtcntAttr()
    {
    	return $this->ktInfo->count();
    }


    // 结题课题数量
    public function getJtcntAttr()
    {
    	return $this->ktInfo->where('jddengji_id', '>', 0)
            ->where('jtshijian', '>', 0)
            ->count();
    }
}
