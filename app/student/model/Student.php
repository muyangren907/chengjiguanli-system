<?php

namespace app\student\model;

// 引用数据模型基类
use app\BaseModel;
// 引用班级数据模型类
use app\teach\model\Banji;

class Student extends BaseModel
{
    // 班级关联
    public function stuBanji()
    {
        return $this->belongsTo('\app\teach\model\Banji', 'banji_id', 'id');
    }


    // 年龄获取器
    public function getAgeAttr()
    {
    	$shengri = $this->getData('shengri');
        if(strlen($shengri) == 0 ){
            return '';
        };
        $age = \app\facade\Tools::fBirth($shengri, 1);
        return $age;
    }


    // 生日修改器
    public function setShengriAttr($value)
    {
        return strtotime($value);
    }


    // 生日获取器
    public function getShengriAttr($value)
    {
        return date('Y-m-d',$value);
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


    // 性别获取器
    public function getKaoshiAttr($value)
    {
        $sex = [
            '0' => '不参加'
            ,'1' => '参加'
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


    // 数据筛选
    public function search($srcfrom)
    {
        $src = [
            'banji_id' => array()
            ,'searchval' => ''
            ,'status' => ''
            ,'kaoshi' => ''
        ];

        $src = array_cover($srcfrom, $src);
        $src['banji_id'] = strToArray($src['banji_id']);
        $qxBanjiIds = event('mybanji');
        if (is_array($qxBanjiIds[0])) {
            $src['banji_id'] = array_intersect($src['banji_id'], $qxBanjiIds[0]);
        }

        $data = $this
                ->where('banji_id', 'in', $src['banji_id'])
                ->when(strlen($src['searchval']) > 0, function($query) use($src){
                        $query
                            ->where('xingming', 'like', '%' . $src['searchval'] . '%')
                            ->with([
                                'glSchool' => function($q){
                                    $q->field('id, title, jiancheng');
                                }
                            ])
                            ->field('id');
                })
                ->when(strlen($src['status']) > 0, function($query) use($src){
                        $query
                            ->where('status', $src['status'])
                            ->field('id');
                })
                ->when(strlen($src['kaoshi']) > 0, function($query) use($src){
                        $query
                            ->where('kaoshi', $src['kaoshi'])
                            ->field('id');
                })
                ->with([
                    'stuBanji'=>function($query){
                        $query->field('id, ruxuenian, paixu, alias')->append(['banjiTitle']);
                    }
                ])
                ->field('id, xingming, sex, shengri, banji_id, kaoshi, status, update_time')
                ->append(['age'])
                ->select();

        return $data;
    }


    // 数据筛选
    public function searchBy($srcfrom)
    {
        $src = [
            'banji_id' => array()
            ,'searchval' => ''
            ,'status' => ''
            ,'kaoshi' => ''
        ];

        $src = array_cover($srcfrom, $src);
        $src['banji_id'] = strToArray($src['banji_id']);
        $qxBanjiIds = event('mybanji');
        if (is_array($qxBanjiIds[0])) {
            $src['banji_id'] = array_intersect($src['banji_id'], $qxBanjiIds[0]);
        }

        $data = $this
                ->where('banji_id', 'in', $src['banji_id'])
                ->when(strlen($src['searchval']) > 0, function($query) use($src){
                        $query
                            ->where('xingming', 'like', '%' . $src['searchval'] . '%')
                            ->with([
                                'glSchool' => function($q){
                                    $q->field('id, title, jiancheng');
                                }
                            ])
                            ->field('id');
                })
                ->when(strlen($src['status']) > 0, function($query) use($src){
                        $query
                            ->where('status', $src['status'])
                            ->field('id');
                })
                ->when(strlen($src['kaoshi']) > 0, function($query) use($src){
                        $query
                            ->where('kaoshi', $src['kaoshi'])
                            ->field('id');
                })
                ->with([
                    'stuBanji'=>function($query){
                        $query->field('id, ruxuenian, paixu, alias')->append(['banjiTitle']);
                    }
                ])
                ->field('id, xingming, sex, shengri, banji_id, kaoshi, status, update_time')
                ->append(['age'])
                ->select();

        return $data;
    }


    // 查询删除学生信息
    public function searchDel($srcfrom)
    {
        $src = [
            'banji_id' => array()
            ,'searchval' => ''
        ];
        $src = array_cover($srcfrom, $src);
        $src['banji_id'] = strToArray($src['banji_id']);

        $data = $this::onlyTrashed()
                ->order('update_time')
                ->where('banji_id', 'in', $src['banji_id'])
                ->when(strlen($src['searchval']) > 0, function($query) use($src){
                        $query
                            ->where('xingming', 'like', '%' . $src['searchval'] . '%')
                            ->field('id');
                })
                ->with([
                    'stuBanji'=>function($query){
                        $query
                            ->field('id, ruxuenian, paixu, school_id')
                            ->with([
                                'glSchool' => function($q) {
                                    $q->field('id, title, jiancheng');
                                }
                            ])
                            ->append(['banjiTitle']);
                    }
                ])
                ->field('id, xingming, sex, shengri, banji_id, status')
                ->append(['age'])
                ->select();

        return $data;
    }


    // 获取全部数据
    public function searchAll()
    {
        return $this->select();
    }


    // 同步表格数据
    public function tongBu($stuinfo, $school_id)
    {
        // 整理数据
        array_splice($stuinfo, 0, 3);       # 删除标题行
        $stuinfo = array_filter($stuinfo, function($q){ ## 过滤姓名、身份证号或班级为空的数据
            return $q[1] != null && strlen($q[2]) >=6 && $q[3] != null;
        });

        // 获取班级信息
        $bj = array_column($stuinfo, 3);
        $arr = array_unique($bj);
        $bjStrName = array();     # 找不同班级
        $bjmod = new \app\teach\model\Banji;
        foreach ($arr as $key => $value) {
            $bjid = $bjmod->srcBanJiID($value, $school_id); # 获取班级ID
            if($bjid != false)
            {
                $bjStrName[$bjid] = $value;
            }
        }

        // 根据班级切割数组
        $arr = array();
        foreach ($bjStrName as $sbj_k => $sbj_val) {
            foreach ($stuinfo as $stu_k => $stu_val) {
                if($stu_val[3] == $sbj_val)
                {
                    $arr[$sbj_k][] = $stu_val;
                    unset($stuinfo[$stu_k]);
                }
            }
        }

        $delarr = array();      # 记录要删除学生ID
        $pinyin = new \Overtrue\Pinyin\Pinyin;
        // 循环班级数组，查询数据，进行对比，并返回结果。
        foreach ($arr as $key => $value) {
            // 获取电子表格中身份证号
            $xlsStuList = array_column($value, 2);
            $xlsStuList = array_map('strtoupper', $xlsStuList);  # 将小写字母转换成大写字母
            $xlsStuList = array_map('trim', $xlsStuList);  # 过滤空格

            // 获取数据库中身份证号
            $serStulist = self::withTrashed()
                        ->where('banji_id',$bjid)
                        ->field('id, xingming, shenfenzhenghao, sex')
                        ->select();
            $sfzh = $serStulist->column('shenfenzhenghao');

            // 返回数据对比结果
            $jiaoji = array_intersect($xlsStuList, $sfzh);  #返回交集
            $add = array_diff($xlsStuList, $sfzh);
            $del = array_diff($sfzh, $xlsStuList);

            

            // 从新增的数据中查找是否有已经存在，但是班级不正确的信息。
            $add_temp = self::withTrashed()
                        ->where('shenfenzhenghao', 'in', $add)
                        ->field('shenfenzhenghao')
                        ->column('shenfenzhenghao', 'id');

            foreach ($add_temp as $add_temp_k => $add_temp_val) {
                // 这个地方在大小写不一致的时候容易出错，需要将小写转换成大写
                $k = array_search($add_temp_val, $add);
                $jiaoji[$k] = $add[$k];
                unset($add[$k]);
            }

            // 针对不同数据进行不同操作
            // 更新数据
            foreach ($jiaoji as $jj_k => $jj_val) {
                $oneStu = self::withTrashed()
                    ->where('shenfenzhenghao', $jj_val)
                    ->field('id, xingming, banji_id, quanpin, shoupin, delete_time')
                    ->find();
                if($oneStu->delete_time > 0)
                {
                    $oneStu->restore();
                }

                $quanpin = $pinyin->sentence($value[$jj_k][1]);
                $shoupin = $pinyin->abbr($value[$jj_k][1]);

                $oneStu->xingming = $value[$jj_k][1];
                $oneStu->banji_id = $key;
                $oneStu->quanpin = trim(strtolower(str_replace(' ', '', $quanpin)));
                $oneStu->shoupin = trim(strtolower(str_replace(' ', '', $shoupin)));
                $oneStu->save();
            }

            // 新增数据
            $pinyin = new \Overtrue\Pinyin\Pinyin;
            $list = array();
            foreach ($add as $add_k => $add_val) {
                $sfzhval = strtoupper(trim($value[$add_k][2]));

                $quanpin = $pinyin->sentence($value[$add_k][1]);
                $shoupin = $pinyin->abbr($value[$add_k][1]);

                $list[$add_k] = [
                    'xingming' => $value[$add_k][1]
                    ,'shenfenzhenghao' => $sfzhval
                    ,'banji_id' => $key
                    ,'quanpin' => trim(strtolower(str_replace(' ', '', $quanpin)))
                    ,'shoupin' => trim(strtolower(str_replace(' ', '', $shoupin)))
                ];


                if(strlen($sfzhval) == 18)
                {
                    $list[$add_k]['shengri'] = substr($sfzhval, 6, 4) . '-' . substr($sfzhval, 10, 2) . '-' . substr($sfzhval, 12, 2);
                    intval(substr($sfzhval,16,1) )% 2 ? $sex = 1 :$sex = 0 ;
                    $list[$add_k]['sex'] = $sex;
                }else{
                    $list[$add_k]['shengri'] = '1970-1-1';
                    $list[$add_k]['sex'] = 2;
                }
            }
            self::saveAll($list);

            // 删除数据
            foreach ($del as $del_k => $del_val) {
                $delarr[] = [
                    'id' => $serStulist[$del_k]->id
                    ,'banjiTitle' => $bjStrName[$key]
                    ,'xingming' => $serStulist[$del_k]->xingming
                    ,'sex' => $serStulist[$del_k]->sex
                ];
            }
        }
        return $delarr;
    }

}
