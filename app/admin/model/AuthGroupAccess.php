<?php

namespace app\admin\model;

// 引用用户数据模型
use app\BaseModel;

class AuthGroupAccess extends BaseModel
{
    // 根据角色ID查询用户
    public function search($srcfrom)
    {
    	$src = [
            'group_id' => 0
            ,'searchval' => ''
            ,'school_id' => array()
        ];
        // 用新值替换初始值
        $src = array_cover($srcfrom, $src);
        $src['school_id'] = strToArray($src['school_id']);

        $data = $this
        	->where('group_id', $src['group_id'])
            ->when(strlen($src['searchval']) > 0, function($query) use($src){
                $query
                    ->where('uid', 'in', function($q) use($src){
                        $q
                        ->name('admin')
                        ->where('username|xingming', 'like', '%'. $src['searchval']. '%')
                        ->field('id');
                    });
                
            })
            ->when(count($src['school_id']) > 0, function($query) use($src){
                $query
                    ->where('uid', 'in', function($q) use($src){
                        $q
                        ->name('admin')
                        ->where('school_id', 'in', $src['school_id'])
                        ->field('id');
                    });
                
            })
            ->where('uid','<>', session('userid'))
        	->with([
        		'jsUser' => function($query) use($src) {
        			$query->field('id,xingming,school_id,username')
        				->with([
        					'adSchool' => function($q){
        						$q->field('id,title,jiancheng');
        					}
        				]);
        		}
        	])
        	->select();

        return $data;
    }
    

    // 考试设置关联表
    public function jsUser()
    {
        return $this->belongsTo('Admin', 'uid', 'id');
    }
}