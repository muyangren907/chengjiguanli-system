<?php
namespace app\chengji\controller;

// 引用控制器基类
use app\base\controller\AdminBase;
use app\chengji\model\Chengji;
use app\teach\model\Subject;


class Luru extends AdminBase
{
    // 成绩列表
    public function index()
    {
        // 设置要给模板赋值的信息
        $list['webtitle'] = '已录列表';
        $list['dataurl'] = '/chengji/luru/data';
        $list['status'] = '/chengji/index/status';

        // 获取学科列表
        $sbj = new \app\teach\model\Subject;
        $list['subject_id'] = $sbj->where('kaoshi', 1)
            ->where('status', 1)
            ->field('id, title, jiancheng')
            ->select();

        // 模板赋值
        $this->view->assign('list', $list);
        // 渲染
        return $this->view->fetch();
    }


    // 获取本人录入成绩信息
    public function ajaxData()
    {
        // 获取参数
        $src = $this->request
            ->only([
                'page'
                ,'limit'
                ,'field' => 'update_time'
                ,'order' => 'desc'
                ,'subject_id' => ''
                ,'searchval'
                ,'user_id' => session('admin.userid')
            ], 'POST');

        // 根据条件查询数据
        $cj = new Chengji;
        $data = $cj->searchLuru($src);
        $data = reSetArray($data, $src);

        return json($data);
    }


    // 使用二维码录入成绩
    public function malu()
    {
        // 设置页面标题
        $list['set'] = array(
            'webtitle' => '扫码录成绩'
            ,'butname' => '录入'
            ,'formpost' => 'PUT'
            ,'url' => '/chengji/malu'
        );

        // 模板赋值
        $this->view->assign('list', $list);
        // 渲染
        return $this->view->fetch();
    }


    // 保存使用二维码录入的成绩
    public function malusave()
    {
        // 获取表单数据
        $list = $this->request->only([
            'kaohao_id'
            ,'subject_id'
            ,'nianji'
            ,'defen'
        ], 'POST');

        // 判断考试状态
        $kh = new \app\kaohao\model\Kaohao;
        $kaoshi_id = $kh::where('id', $list['kaohao_id'])->value('kaoshi_id');
        event('kslu', $kaoshi_id);

        // 获取本学科满分
        $list['ruxuenian'] = $list['nianji'];
        $list['kaoshi_id'] = $kaoshi_id;
        $ksset = new \app\kaoshi\model\KaoshiSet;
        $subject = $ksset->srcSubject($list);

        if (count($subject) > 0) {
            $manfen = $subject[0]['fenshuxian']['manfen'];
        } else {
            $manfen = "";
        }

        // 成绩验证
        $mfyz = manfenvalidate($list['defen'], $manfen);
        if ($mfyz['val'] == 0) {
            return json($mfyz);
        }

        // 保存成绩
        $cjone = Chengji::withTrashed()
            ->where('subject_id', $list['subject_id'])
            ->where('kaohao_id', $list['kaohao_id'])
            ->find();

        // 如果存在成绩则更新，不存在则添加
        if ($cjone) {
            // 判断记录是否被删除
            if ($cjone->delete_time > 0) {
                $cjone->restore();
            }

            if ($cjone->defen == $list['defen']) {
                $data = ['msg' => '与原成绩相同，不需要修改。', 'val' => 1];
                return json($data);
            }

            $cjone->defen = $list['defen'];
            $cjone->defenlv = $list['defen'] / $manfen * 100;
            $data = $cjone->save();
        } else {
            $data = [
                'kaohao_id' => $list['kaohao_id']
                ,'subject_id' => $list['subject_id']
                ,'user_id' => session('admin.userid')
                ,'defen' => $list['defen']
                ,'defenlv' => $list['defen'] / $manfen * 100
            ];
            $data = Chengji::create($data);
        }

        $data ? $data = ['msg' => '更新成功', 'val' => 1]
            : $data = ['msg' => '数据处理错误', 'val' => 0];

        return json($data);
    }


    // 学生成绩表中修改成绩
    public function update($id)  #id为考号ID
    {
        // 获取表单数据
        $list = $this->request->only([
            'colname'
            ,'newdefen'
        ] , 'POST');
        $list['kaohao_id'] = $id;

        // 判断考试结束时间是否已过
        $kh = new \app\kaohao\model\Kaohao;
        $kaoshi_id = $kh::where('id', $list['kaohao_id'])->value('kaoshi_id');
        event('kslu', $kaoshi_id);

        // 获取学科id
        $subject = new \app\teach\model\Subject;
        $subject_id = $subject->where('lieming', $list['colname'])->value('id');
        // 根据考号获取学生年在年级及考试ID
        $khinfo = $kh->where('id', $id)->find();
        // 获取本学科满分
        $ksset = new \app\kaoshi\model\KaoshiSet;
        $src = [
            'kaoshi_id' => $khinfo->kaoshi_id
            ,'subject_id' => $subject_id
            ,'ruxuenian' => $khinfo->ruxuenian
        ];
        $subject = $ksset->srcSubject($src);
        if (count($subject)>0) {
            $manfen = $subject[0]['fenshuxian']['manfen'];
        } else {
            $manfen = "";
        }

        // 成绩验证
        $mfyz = manfenvalidate($list['newdefen'], $manfen);
        if ($mfyz['val'] == 0) {
            return json($mfyz);
        }

        // 更新成绩
        $cjone = Chengji::withTrashed()
            ->where('kaohao_id', $list['kaohao_id'])
            ->where('subject_id', $subject_id)
            ->find();

        // 如果存在成绩则更新，不存在则添加
        if ($cjone) {
            // 判断记录是否被删除
            if ($cjone->delete_time > 1) {
                $cjone->restore();
            }

            if ($cjone->defen == $list['newdefen']) {
                $data = ['msg' => '与原成绩相同，不需要修改。', 'val' => 1];
                return json($data);
            }

            $cjone->defen = $list['newdefen'];
            $cjone->defenlv = $list['newdefen'] / $manfen * 100;
            $cjone->user_id = session('admin.userid');
            $data = $cjone->save();
        } else {
            $data = [
                'kaohao_id' => $list['kaohao_id']
                ,'subject_id' => $subject_id
                ,'user_id' => session('admin.userid')
                ,'defen' => $list['newdefen']
                ,'defenlv' => $list['newdefen'] / $manfen * 100
            ];
            $data = Chengji::create($data);
        }

        // 判断返回内容
        $data  ? $data = ['msg' => '录入成功','val' => 1]
            : $data = ['msg' => '数据处理错误','val' => 0];

        // 返回更新结果
        return json($data);
    }


    // 根据考号获取学生信息
    public function read()
    {
        // 获取表单数据
        $val = input('post.val');
        // 实例化系统设置类
        $val = \app\facade\Tools::decrypt($val, 'dlbz');
        $list = explode('|', $val);
        $id = $list[0];
        $subject_id = $list[1];

        $khSrc = new \app\kaohao\model\SearchOne;
        $cjlist = $khSrc->srcOneSubjectChengji($id, $subject_id);

        // 获取列名
        return json($cjlist);
    }


    // 表格录入成绩上传页面
    public function biaolu()
    {
        $ks = new \app\kaoshi\model\Kaoshi;
        // 获取参考年级
        $list['data'] = $ks::order(['id' => 'desc'])
                ->field('id, title')
                ->where('luru', 1)
                ->select();

        // 设置页面标题
        $list['set'] = array(
            'webtitle' => '表格录入'
            ,'butname' => '下载'
            ,'formpost' => 'POST'
            ,'url' => '/kaohao/excel/dwcaiji'
        );

        // 模板赋值
        $this->view->assign('list', $list);
        // 渲染
        return $this->view->fetch();
    }


    // 保存表格批量上传的成绩
    public function saveAll()
    {
        // 获取表单数据
        $list = $this->request->only([
            'url'
        ], 'POST');

        // 读取表格数据
        $cjinfo = \app\facade\File::readXls(public_path() . 'uploads\\' . $list['url']);

        $kaoshi_id = $cjinfo[1][0];  #获取考号
        $nianji = $cjinfo[1][1];  #获取年级

        if($kaoshi_id == null
            || $nianji==null
            || $cjinfo[2][0] != '序号'
            || $cjinfo[2][1] != '编号'
            || $cjinfo[2][2] != '班级'
            || $cjinfo[2][3] != '姓名') {
            $data = ['msg' => '请使用模板上传', 'val' => 0];
            return json($data);
        }
        // 判断考试状态
        event('kslu', $kaoshi_id);

        // 删除空单元格得到学科列名数组
        array_splice($cjinfo[1], 0, 4);
        $xk = $cjinfo[1];
        // 删除成绩采集表无用的标题行得到成绩数组
        array_splice($cjinfo,0,3);

        // 查询考试信息
        $ksset = new \app\kaoshi\model\KaoshiSet;
        $src = [
            'kaoshi_id' => $kaoshi_id
            ,'ruxuenian' => $nianji
            ,'subject_id' => $xk
        ];
        $sbj = $ksset->srcSubject($src);
        $subject = array();
        foreach ($sbj as $key => $value) {
            $key = array_search($value['id'], $xk);
            if (is_numeric($key)) {
                $subject[$key] = $value;
            }
        }

        $user_id = session('admin.userid');   # 获取用户id
        $data = array();

        // 重新组合数组
        foreach ($subject as $key => $value) {
            # code...
            foreach ($cjinfo as $k => $val) {
                $defen = $val[$key + 4];    # 当前学生当前学科成绩
                // 如果不存在值，跳过这次循环
                if ($defen === null) {
                    continue;
                }

                // 验证成绩格式，如果不对则跳过
                if (isset($value['fenshuxian']['manfen'])) {
                    $manfen = $value['fenshuxian']['manfen'];
                } else {
                    $manfen = "";
                }
                $mfyz = manfenvalidate($defen, $manfen);
                if ($mfyz['val'] == 0) {
                    continue;
                }

                // 添加或更新数据
                $cjone = Chengji::withTrashed()
                    ->where('kaohao_id', $val[1])
                    ->where('subject_id', $value['id'])
                    ->find();
                // 判断成绩是否存在
                if ($cjone) {
                    // 如果存在则更新记录
                    if ($cjone->defen != $defen || $cjone->delete_time > 1) {
                        $cjone->restore();
                        $cjone->defen = $defen;
                        $cjone->defenlv = $defen / $manfen * 100;
                        $cjone->user_id = $user_id;
                        $cjone->save();
                    }
                } else {
                    // 如果不存在则新增记录
                    $data = [
                        'kaohao_id' => $val[1]
                        ,'subject_id' => $value['id']
                        ,'user_id' => $user_id
                        ,'defen' => $defen
                        ,'defenlv' => $defen / $manfen * 100
                    ];
                    Chengji::create($data);
                }
            }
        }

        // 判断成绩更新结果
        $data = ['msg' => '成绩导入成功', 'val' => 1];
        ob_flush();
        flush();
        // 返回成绩结果
        return json($data);
    }
}
