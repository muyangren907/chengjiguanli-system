<?php

namespace app\admin\model;

// 引用用户数据模型
use app\BaseModel;

class Admin extends BaseModel
{
    // 查询所有角色
    public function search($srcfrom)
    {
        // 整理变量
        $src = [
            'searchval' => ''
        ];
        $src = array_cover($srcfrom, $src);

        // 查询数据
        $data = $this
            ->where('id', '>', 2)
            ->where('id', '<>', session('userid'))
            ->when(strlen($src['searchval']) > 0, function($query) use($src){
                    $query->where('xingming|username', 'like', '%' . $src['searchval'] . '%');
                })
            ->with([
                'adSchool' => function($query){
                    $query->field('id, jiancheng');
                }
                ,'glGroup'
            ])
            ->hidden([
                'password'
                ,'create_time'
                ,'update_time'
                ,'delete_time'
            ])
            ->select();
        return $data;
    }


    // 查询用户权限
    public function srcAuth($user_id)
    {
        // 查询权限
        $data = self::where('id', $user_id)
            ->field('id')
            ->with([
                'glGroup'
            ])
            ->find();

        // 整理权限
        $arr = array();
        foreach ($data->glGroup as $key => $value) {
            $temp = explode(",", $value->rules);
            $arr = array_merge($arr, $temp);
        }
        $arr = array_unique($arr);

        return $arr;
    }


    // 查询管理员资料
    public function searchOne($id)
    {
        $adminInfo = $this->where('id', $id)
            ->field('id, username, xingming, teacher_id')
            ->find();
        return $adminInfo;
    }


    // 根据姓名、首拼查询教师
    public function strSrcTeachers($srcfrom)
    {
        $src = [
            'str' => ''
            ,'school_id' => ''
        ];
        $src = array_cover($srcfrom, $src);
        // 如果有数据则查询教师信息
        $list = self::field('id, xingming, school_id, shengri, sex')
            ->whereOr('xingming', 'like', '%' . $src['str'] . '%')
            ->whereOr('shoupin', 'like', $src['str'] . '%')
            ->when(strlen($src['school_id']) > 0, function ($query) use($src) {
                $query->where('school_id', $src['school_id']);
            })
            ->with(
                [
                    'adSchool' => function($query){
                        $query->field('id, jiancheng');
                    },
                ]
            )
            ->append(['age'])
            ->select();

        return $list;
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
            $phone = str_replace(' ', '', $value[4]);
            $teacherlist[$i]['xingming'] = $value[1];
            $teacherlist[$i]['sex'] = $this->cutStr($value[2]);
            $teacherlist[$i]['shengri'] = $value[3];
            $teacherlist[$i]['phone'] = $phone;
            $teacherlist[$i]['worktime'] = $value[5];
            $teacherlist[$i]['zhiwu_id'] = $this->cutStr($value[6]);
            $teacherlist[$i]['zhicheng_id'] = $this->cutStr($value[7]);
            $teacherlist[$i]['school_id'] = $School_id;
            $teacherlist[$i]['biye'] = $value[9];
            $teacherlist[$i]['subject_id'] = $this->cutStr($value[8]);
            $teacherlist[$i]['zhuanye'] = $value[9];
            $teacherlist[$i]['xueli_id'] = $this->cutStr($value[11]);
            $quanpin = $pinyin->sentence($value[1]);
            $jianpin = $pinyin->abbr($value[1]);
            $teacherlist[$i]['quanpin'] = trim(strtolower(str_replace(' ', '', $quanpin)));
            $teacherlist[$i]['shoupin'] = trim(strtolower($jianpin));
            $teacherlist[$i]['username'] = $teacherlist[$i]['quanpin'] .'.'. \app\facade\Tools::sjStr(3);
            $temp = $this->whereOrPhone($phone)->find();
            if($temp)
            {
                if($temp->delete_time > 0)
                {
                    $temp->restore();
                }
                $teacherlist[$i]['id'] = $temp->id;
            }
            $i++;
        }


        // 查找相同值，如果重复则重新命名。
        $teacherlist = \app\facade\Tools::sortArrByManyField($teacherlist,'username');
        foreach ($teacherlist as $key => $value) {
            if ($key > 1) {
                if($value['username'] == $teacherlist[$key-1]['username']){
                    $teacherlist[$key]['username'] = $teacherlist[$key]['quanpin'] .'.'. \app\facade\Tools::sjStr(4);
                }else{
                    break;
                }
            }
        }

        $teacherlist = array_filter($teacherlist, function($q){ ## 过滤姓名、身份证号或班级为空的数据
            return $q['xingming'] != null && $q['sex'] != null && $q['zhiwu_id'] != null && $q['zhicheng_id'] != null && $q['subject_id'] != null  && $q['xueli_id'] != null;
        });

        // 保存或更新信息
        $data = $this->saveAll($teacherlist);

        $data ? $data = true : $data = false;

        return $data;
    }


    // 关联用户组
    public function glGroup()
    {
        return $this->belongsToMany('AuthGroup', 'AuthGroupAccess', 'group_id', 'uid');
    }


    // 单位关联模型
    public function adSchool()
    {
        return $this->belongsTo('\app\system\model\School', 'school_id', 'id');
    }


    // 获取密码
    public function password($username)
    {
    	// 查询数据
    	$pasW = $this
    		->where('username', $username)
    		->value('password');

    	// 返回数据
    	return $pasW;
    }


    // 生日修改器
    public function setShengriAttr($value)
    {
        strlen($value) >0 ? $value = strtotime($value) : $value = '';
        return $value;
    }


    // 生日获取器
    public function getShengriAttr($value)
    {
        return date('Y-m-d', $value);
    }


    // 创建时间获取器
    public function getCreateTimeAttr($value)
    {
        return date('Y-m-d', $value);
    }


    // 性别获取器
    public function getSexAttr($value)
    {
        $sex = [
            '0' => '女'
            ,'1' => '男'
            ,'2' => '保密'
        ];

        $str = '';
        if(isset($sex[$value]))
        {
            $str = $sex[$value];
        }else{
            $str = '未知';
        }
        return $str;
    }


    // 最后登录时间取器
    public function getLasttimeAttr($value)
    {
        return date('Y年m月d日 H:i:s', $value);
    }


    // 本次登录时间取器
    public function getThistimeAttr($value)
    {
        return date('Y年m月d日 H:i:s', $value);
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


    // 获取角色名称
    public function getGroupnames($userid)
    {
        // 如果用户ID为1或2，则为超级管理员
        if($userid == 1 || $userid == 2)
        {
            return '超级管理员';
        }

        // 查询用户拥有的权限
        $admininfo = $this->where('id', $userid)
            ->field('id')
            ->with([
                'glGroup'=>function($query){
                    $query->where('status', 1);
                }
            ])
            ->find();

        $groupname = '';
        foreach ($admininfo->gl_group as $key => $value) {
            if($key == 0){
                $groupname = $value->title;
            }else{
                $groupname = $groupname . '、' . $value->title;
            }
        }

        // 返回角色名
        return $groupname;
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



    static function newId($oldId)
    {
        $id = self::withTrashed()->whereTeacherId($oldId)->value('id');
        return $id;
    }


}
