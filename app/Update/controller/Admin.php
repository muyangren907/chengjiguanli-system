<?php
declare (strict_types = 1);

namespace app\Update\controller;

use think\facade\View;

class Admin
{

    // Index
    public function index()
    {
        // 设置要给模板赋值的信息
        $list['webtitle'] = '数据升级';
        $list['dataurl'] = '';

        // 模板赋值
        View::assign('list', $list);

        // 渲染模板
        return View::fetch();
    }


    // Admin
    public function admin()
    {
        $new = new \app\update\model\Admin;
        $old = new \app\admin\model\Admin;

        // 整理数据
        $oldId = $old::withTrashed()->select();
        $new->where('id', '>', 0)->delete();
        $i = 0;
        foreach ($oldId as $key => $value) {
            $oldList = $value->getData();
            $oldList['school_id'] = $oldList['school'];
            $newList = $new->create($oldList);
            if ($newList) {
                $i ++;
            }
        }
        dump('Admin : 共' . count($oldId) . '条记录。创建' . $i . '条记录。');
        return 'Admin : 共' . count($oldId) . '条记录。创建' . $i . '条记录。';
    }


    // Banji
    public function banji()
    {
        $new = new \app\update\model\Banji;
        $old = new \app\teach\model\Banji;

        // 整理数据
        $oldId = $old::withTrashed()->select();
        $new->where('id', '>', 0)->delete();
        $i = 0;
        foreach ($oldId as $key => $value) {
            $oldList = $value->getData();
            $oldList['school_id'] = $oldList['school'];
            $oldList['xueduan_id'] = 10302;
            $newList = $new->create($oldList);
            if ($newList) {
                $i ++;
            }
        }
        dump('Banji : 共' . count($oldId) . '条记录。创建' . $i . '条记录。');
        return 'Banji : 共' . count($oldId) . '条记录。创建' . $i . '条记录。';
    }


    // Chengji
    public function chengji()
    {
        set_time_limit(0);
        $new = new \app\update\model\Chengji;
        $old = new \app\chengji\model\Chengji;

        // 整理数据
        $oldId = $old::withTrashed()
            ->select();

        $new->where('id', '>', 0)->delete();

        $i = 0;
        foreach ($oldId as $key => $value) {
            $oldList = $value->getData();
            unset($oldList['id']);
            $oldList['defenlv'] = $oldList['defen'];
            $oldList['subject_id'] = getNewSubject($oldList['subject_id']);
            $newList[] = $oldList;
        }

        $newList = $new->saveAll($newList);
        $i = $newList->count();

        dump('Chengji : 共' . count($oldId) . '条记录。创建' . $i . '条记录。');
        return 'Chengji : 共' . count($oldId) . '条记录。创建' . $i . '条记录。';
    }


    // DwRongyu
    public function dwrongyu()
    {
        $new = new \app\update\model\DwRongyu;
        $old = new \app\rongyu\model\DwRongyu;

        // 整理数据
        $oldId = $old::withTrashed()
            ->select();

        $new->where('id', '>', 0)->delete();

        $i = 0;
        foreach ($oldId as $key => $value) {
            $oldList = $value->getData();
            $oldList['hjschool_id'] = $oldList['hjschool'];
            $oldList['fzschool_id'] = $oldList['fzschool'];
            $oldList['jiangxiang_id'] = getNewCategory($oldList['jiangxiang']);
            $oldList['category_id'] = getNewCategory($oldList['category']);
            $newList = $new->create($oldList);
            if ($newList) {
                $i ++;
            }
        }

        dump('DwRongyu : 共' . count($oldId) . '条记录。创建' . $i . '条记录。');
        return 'DwRongyu : 共' . count($oldId) . '条记录。创建' . $i . '条记录。';
    }


    // DwRongyu
    public function dwrongyucanyu()
    {
        $new = new \app\update\model\DwRongyuCanyu;
        $old = new \app\rongyu\model\DwRongyuCanyu;

        // 整理数据
        $oldId = $old::withTrashed()
            ->select();

        $new->where('id', '>', 0)->delete();

        $i = 0;
        foreach ($oldId as $key => $value) {
            $oldList = $value->getData();
            unset($oldList['id']);
            unset($oldList['update_time']);
            unset($oldList['create_time']);
            unset($oldList['delete_time']);
            $oldList['rongyu_id'] = $oldList['rongyuid'];
            $oldList['teacher_id'] = $oldList['teacherid'];
            $newList[] = $oldList;
        }

        $newList = $new->saveAll($newList);
        $i = $newList->count();

        dump('DwRongyuCanyu : 共' . count($oldId) . '条记录。创建' . $i . '条记录。');
        return 'DwRongyuCanyu : 共' . count($oldId) . '条记录。创建' . $i . '条记录。';
    }


    // DwRongyu
    public function fields()
    {
        $new = new \app\update\model\Fields;
        $old = new \app\system\model\Fields;

        // 整理数据
        $oldId = $old::withTrashed()
            ->select();

        $new->where('id', '>', 0)->delete();

        $i = 0;
        foreach ($oldId as $key => $value) {
            $oldList = $value->getData();
            unset($oldList['id']);
            $oldList['user_id'] = $oldList['userid'];
            $newList[] = $oldList;
        }

        $newList = $new->saveAll($newList);
        $i = $newList->count();

        dump('Fields : 共' . count($oldId) . '条记录。创建' . $i . '条记录。');
        return 'Fields : 共' . count($oldId) . '条记录。创建' . $i . '条记录。';
    }


    // JsRongyu
    public function jsrongyu()
    {
        $new = new \app\update\model\JsRongyu;
        $old = new \app\rongyu\model\JsRongyu;

        // 整理数据
        $oldId = $old::withTrashed()
            ->select();

        $new->where('id', '>', 0)->delete();

        $i = 0;
        foreach ($oldId as $key => $value) {
            $oldList = $value->getData();
            $oldList['fzschool_id'] = $oldList['fzschool'];
            $oldList['category_id'] = getNewCategory($oldList['category']);
            $oldList['subject_id'] = getNewSubject($oldList['subject']);
            $newList = $new->create($oldList);
            if ($newList) {
                $i ++;
            }
        }

        dump('JsRongyu : 共' . count($oldId) . '条记录。创建' . $i . '条记录。');
        return 'JsRongyu : 共' . count($oldId) . '条记录。创建' . $i . '条记录。';
    }


    // JsRongyuCanyu
    public function jsrongyucanyu()
    {
        $new = new \app\update\model\JsRongyuCanyu;
        $old = new \app\rongyu\model\JsRongyuCanyu;

        // 整理数据
        $oldId = $old::withTrashed()
            ->select();

        $new->where('id', '>', 0)->delete();

        $i = 0;
        foreach ($oldId as $key => $value) {
            $oldList = $value->getData();
            unset($oldList['id']);
            unset($oldList['update_time']);
            unset($oldList['create_time']);
            unset($oldList['delete_time']);
            $oldList['category'] == 1 ? $oldList['category_id'] = 11901
                : $oldList['category_id'] = 11902;
            $oldList['rongyu_id'] = $oldList['rongyuid'];
            $oldList['teacher_id'] = $oldList['teacherid'];
            $newList[] = $oldList;
        }

        $newList = $new->saveAll($newList);
        $i = $newList->count();

        dump('JsRongyuCanyu : 共' . count($oldId) . '条记录。创建' . $i . '条记录。');
        return 'JsRongyuCanyu : 共' . count($oldId) . '条记录。创建' . $i . '条记录。';
    }


    // JsRongyuInfo
    public function jsrongyuinfo()
    {
        $new = new \app\update\model\JsRongyuInfo;
        $old = new \app\rongyu\model\JsRongyuInfo;

        // 整理数据
        $oldId = $old::withTrashed()
            ->select();

        $new->where('id', '>', 0)->delete();

        $i = 0;
        foreach ($oldId as $key => $value) {
            $oldList = $value->getData();
            $oldList['rongyuce_id'] = $oldList['rongyuce'];
            $oldList['hjschool_id'] = $oldList['hjschool'];
            $oldList['subject_id'] = getNewSubject($oldList['subject']);
            $oldList['jiangxiang_id'] = getNewCategory($oldList['jiangxiang']);
            $newList = $new->create($oldList);
            if ($newList) {
                $i ++;
            }
        }

        dump('JsRongyuInfo : 共' . count($oldId) . '条记录。创建' . $i . '条记录。');
        return 'JsRongyuInfo : 共' . count($oldId) . '条记录。创建' . $i . '条记录。';
    }


    // Kaohao
    public function kaohao($page)
    {
        set_time_limit(0);
        $new = new \app\update\model\Kaohao;
        $old = new \app\kaohao\model\Kaohao;

        // 整理数据
        dump('第'.$page.'页');
        $oldId = $old::withTrashed()
            ->page($page, 500)
            ->select();
        // $new->where('id', '>', 0)->delete();

        $i = 0;
        foreach ($oldId as $key => $value) {
            $oldList = $value->getData();
            $oldList['kaoshi_id'] = $oldList['kaoshi'];
            $oldList['school_id'] = $oldList['school'];
            $oldList['banji_id'] = $oldList['banji'];
            $oldList['student_id'] = $oldList['student'];
            $newList = $new->create($oldList);
            if ($newList) {
                $i ++;
            }
        }

        dump('Kaohao : 共' . count($oldId) . '条记录。创建' . $i . '条记录。');
        return 'Kaohao : 共' . count($oldId) . '条记录。创建' . $i . '条记录。';
    }


    // Kaoshi
    public function kaoshi()
    {
        $new = new \app\update\model\Kaoshi;
        $old = new \app\Kaoshi\model\Kaoshi;

        // 整理数据
        $oldId = $old::withTrashed()
            ->select();

        $new->where('id', '>', 0)->delete();

        $i = 0;
        foreach ($oldId as $key => $value) {
            $oldList = $value->getData();
            $oldList['zuzhi_id'] = $oldList['zuzhi'];
            $oldList['xueqi_id'] = $oldList['xueqi'];
            $oldList['category_id'] = $oldList['category'];
            $newList = $new->create($oldList);
            if ($newList) {
                $i ++;
            }
        }

        dump('Kaoshi : 共' . count($oldId) . '条记录。创建' . $i . '条记录。');
        return 'Kaoshi : 共' . count($oldId) . '条记录。创建' . $i . '条记录。';
    }



    // Keti
    public function Keti()
    {
        $new = new \app\update\model\Keti;
        $old = new \app\Keti\model\Keti;

        // 整理数据
        $oldId = $old::withTrashed()
            ->select();

        $new->where('id', '>', 0)->delete();

        $i = 0;
        foreach ($oldId as $key => $value) {
            $oldList = $value->getData();
            $oldList['lxdanwei_id'] = $oldList['lxdanweiid'];
            $oldList['category_id'] = getNewCategory($oldList['category']);
            $newList = $new->create($oldList);
            if ($newList) {
                $i ++;
            }
        }

        dump('Keti : 共' . count($oldId) . '条记录。创建' . $i . '条记录。');
        return 'Keti : 共' . count($oldId) . '条记录。创建' . $i . '条记录。';
    }


    // KetiCanyu
    public function keticanyu()
    {
        $new = new \app\update\model\KetiCanyu;
        $old = new \app\Keti\model\KetiCanyu;

        // 整理数据
        $oldId = $old::withTrashed()
            ->select();

        $new->where('id', '>', 0)->delete();

        $i = 0;
        foreach ($oldId as $key => $value) {
            $oldList = $value->getData();
            unset($oldList['id']);
            unset($oldList['update_time']);
            unset($oldList['create_time']);
            unset($oldList['delete_time']);
            $oldList['ketiinfo_id'] = $oldList['ketiinfoid'];
            $oldList['teacher_id'] = $oldList['teacherid'];
            $oldList['category'] == 1 ? $oldList['category_id'] = 11901
                : $oldList['category_id'] = 11902;
            $newList[] = $oldList;
        }

        $newList = $new->saveAll($newList);
        $i = $newList->count();

        dump('KetiCanyu : 共' . count($oldId) . '条记录。创建' . $i . '条记录。');
        return 'KetiCanyu : 共' . count($oldId) . '条记录。创建' . $i . '条记录。';
    }


    // KetiInfo
    public function KetiInfo()
    {
        set_time_limit(0);
        $new = new \app\update\model\KetiInfo;
        $old = new \app\Keti\model\KetiInfo;

        // 整理数据
        $oldId = $old::withTrashed()
            ->select();

        $new->where('id', '>', 0)->delete();

        $i = 0;
        foreach ($oldId as $key => $value) {
            $oldList = $value->getData();
            $oldList['ketice_id'] = $oldList['ketice'];
            $oldList['subject_id'] = getNewSubject($oldList['subject']);
            $oldList['fzdanwei_id'] = getNewCategory($oldList['fzdanweiid']);
            $oldList['jddengji_id'] = getNewDengji($oldList['jddengji']);
            $oldList['category_id'] = getNewCategory($oldList['category']);
            $oldList['subject_id'] = getNewCategory($oldList['subject']);
            $oldList['lxpic'] = 'keti/lixiang/'.$oldList['lxpic'];
            $oldList['jtpic'] = 'keti/jieti/'.$oldList['jtpic'];
            $newList = $new->create($oldList);
            if ($newList) {
                $i ++;
            }
        }

        dump('KetiInfo : 共' . count($oldId) . '条记录。创建' . $i . '条记录。');
        return 'KetiInfo : 共' . count($oldId) . '条记录。创建' . $i . '条记录。';
    }


    // School
    public function school()
    {
        $new = new \app\update\model\School;
        $old = new \app\system\model\School;

        // 整理数据
        $oldId = $old::withTrashed()
            ->select();

        $new->where('id', '>', 0)->delete();

        $i = 0;
        foreach ($oldId as $key => $value) {
            $oldList = $value->getData();
            $oldList['xingzhi_id'] = getNewCategory($oldList['xingzhi']);
            $oldList['jibie_id'] = getNewCategory($oldList['jibie']);
            $oldList['xueduan_id'] = getNewCategory($oldList['xueduan']);
            $newList = $new->create($oldList);
            if ($newList) {
                $i ++;
            }
        }

        dump('School : 共' . count($oldId) . '条记录。创建' . $i . '条记录。');
        return 'School : 共' . count($oldId) . '条记录。创建' . $i . '条记录。';
    }

    // Student
    public function Student($page)
    {
        set_time_limit(0);
        $new = new \app\update\model\Student;
        $old = new \app\renshi\model\Student;
        $pinyin = new \Overtrue\Pinyin\Pinyin;

        // 整理数据
        dump('第'.$page.'页');
        $oldId = $old->withTrashed()
            ->page($page, 500)
            ->select();
        // $new->where('id', '>', 0)->delete();

        $i = 0;
        foreach ($oldId as $key => $value) {
            $oldList = $value->getData();
            $oldList['banji_id'] = $oldList['banji'];
            $quanpin = $pinyin->sentence( $oldList['xingming']);
            $oldList['shoupin'] = $pinyin->abbr( $oldList['xingming']);
            $oldList['quanpin'] = trim(strtolower(str_replace(' ', '', $quanpin)));

            $newList = $new->create($oldList);
            if ($newList) {
                $i ++;
            }
        }

        dump('Student : 共' . count($oldId) . '条记录。创建' . $i . '条记录。');
        return 'Student : 共' . count($oldId) . '条记录。创建' . $i . '条记录。';
    }


    // Teacher
    public function Teacher($page)
    {
        set_time_limit(0);
        $new = new \app\update\model\Teacher;
        $old = new \app\renshi\model\Teacher;
        $pinyin = new \Overtrue\Pinyin\Pinyin;

        // 整理数据
        dump('第'.$page.'页');
        $oldId = $old::withTrashed()
            ->page($page, 500)
            ->select();
        // $new->where('id', '>', 0)->delete();

        $i = 0;
        foreach ($oldId as $key => $value) {
            $oldList = $value->getData();
            $oldList['zhiwu_id'] = $oldList['zhiwu'];
            $oldList['zhicheng_id'] = $oldList['zhicheng'];
            $oldList['danwei_id'] = $oldList['danwei'];
            $oldList['xueli_id'] = $oldList['xueli'];
            $oldList['subject_id'] = $oldList['subject'];
            $quanpin = $pinyin->sentence( $oldList['xingming']);
            $oldList['shoupin'] = $pinyin->abbr( $oldList['xingming']);
            $oldList['quanpin'] = trim(strtolower(str_replace(' ', '', $quanpin)));

            $newList = $new->create($oldList);
            if ($newList) {
                $i ++;
            }
        }

        dump('Teacher : 共' . count($oldId) . '条记录。创建' . $i . '条记录。');
        return 'Teacher : 共' . count($oldId) . '条记录。创建' . $i . '条记录。';
    }


    // Xueqi
    public function xueqi()
    {
        $new = new \app\update\model\Xueqi;
        $old = new \app\teach\model\Xueqi;

        // 整理数据
        $oldId = $old::withTrashed()
            ->select();

        $new->where('id', '>', 0)->delete();

        $i = 0;
        foreach ($oldId as $key => $value) {
            $oldList = $value->getData();
            $oldList['category_id'] = $oldList['category'];

            $newList = $new->create($oldList);
            if ($newList) {
                $i ++;
            }
        }

        dump('Xueqi : 共' . count($oldId) . '条记录。创建' . $i . '条记录。');
        return 'Xueqi : 共' . count($oldId) . '条记录。创建' . $i . '条记录。';
    }


}
