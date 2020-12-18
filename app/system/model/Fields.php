<?php

namespace app\system\model;

use app\BaseModel;

class Fields extends BaseModel
{

    // 编辑时间获取器
    public function getBianjitimeAttr($value)
    {
        return date('Y-m-d H:i:s', $value);
    }


    // 查询文件是否重复上传
    public function hasHash($str=""){
    	$hasHash = 0;
    	$list = $this->where('hash', $str)->find();
    	if($list){
    		$hasHash = 1;
    	}
    	return $hasHash;
    }


    // 查询所有单位
    public function search($srcfrom)
    {
        // 整理条件
        $src = [
            'searchval' => ''
        ];
        $src = array_cover($srcfrom, $src) ;

        // 查询数据
        $data = $this
            ->when(strlen($src['searchval']) > 0, function($query) use($src){
                    $query->where('oldname', 'like', '%' . $src['searchval'] . '%');
                })
            ->with([
                'flCategory' => function ($query) {
                    $query->field('id, title');
                }
            ])
            ->append(['userInfo'])
            ->select();

        return $data;
    }


    // 上传人数据关联
    public function  flTeacher()
    {
        return $this->belongsTo('\app\teacher\model\Teacher', 'user_id', 'id');
    }


    // 上传人数据关联
    public function  flAdmin()
    {
        return $this->belongsTo('\app\admin\model\Admin', 'user_id', 'id');
    }



    // 文件种类数模型关联
    public function  flCategory()
    {
        return $this->belongsTo('\app\system\model\Category', 'category_id', 'id');
    }


    // 上传人信息获取器
    public function getUserInfoAttr($value, $data)
    {
        // halt($data);
        $xm = '';
        if($data['user_group'] === 'admin')
        {
            if($this->flAdmin)
            {
                $xm = $this->flAdmin->xingming;
                if($this->flAdmin->adSchool)
                {
                    $xm = $xm . '(' .  $this->flAdmin->adSchool->jiancheng . ')';
                }
            }
        }elseif ($data['user_group'] === 'teacher') {
            if($this->flTeacher)
            {
                $xm = $this->flTeacher->xingming;
                if($this->flTeacher->jsDanwei)
                {
                    $xm = $xm . '(' . $this->flTeacher->jsDanwei->jiancheng . ')';
                }
            }
        }else{
            $xm = '';
        }

        $arr = [
            'admin' => '管理员'
            ,'teacher' => '教师'
            ,'student' => '学生'
        ];

        if(isset($arr[$data['user_group']]))
        {
            $str = $arr[$data['user_group']] . ' ' . $xm;
        }else{
            $str = '';
        }

        return $str;
    }

}
