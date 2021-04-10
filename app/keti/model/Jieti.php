<?php
declare (strict_types = 1);

namespace app\keti\model;

use think\Model;

/**
 * @mixin \think\Model
 */
class Jieti extends Model
{
    //搜索课题册
    public function search($srcfrom)
    {
    	$src = [
            'danwei_id' => array()
            ,'shijian' => array()
            ,'searchval' => ''
        ];
        $src = array_cover($srcfrom, $src);
        $src['danwei_id'] = strToArray($src['danwei_id']);

    	$data = $this
    		->when(count($src['danwei_id']) > 0, function($query) use($src){
                	$query->where('danwei_id', 'in', $src['danwei_id']);
                })
    		->when(strlen($src['searchval']) > 0, function($query) use($src){
                	$query->where('title', 'like', '%' . $src['searchval'] . '%');
                })
            ->with(
                [
                    'glDanwei' => function($query){
                        $query->field('id, title');
                    },
                ]
            )
            ->withCount(['ktInfo' => 'count'])
    		->select();

    	return $data;
    }


    // 结题单位关联
    public function glDanwei()
    {
    	return $this->belongsTo('\app\system\model\School', 'danwei_id', 'id');
    }


    // 课题信息关联
    public function ktInfo()
    {
    	return $this->hasMany('KetiInfo', 'jieti_id', 'id')
    		->where('jddengji_id', 'between', [11802, 11803]);
    }


    // 立项时间获取器
    public function getShijianAttr($value)
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
    public function setShijianAttr($value)
    {
    	return strtotime($value);
    }
}
