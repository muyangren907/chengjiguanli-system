<?php
namespace app\kaohao\controller;

// 引用控制器基类
use app\base\controller\AdminBase;

// 引用数据模型类
use app\kaoshi\model\Kaoshi as KS;
use app\kaoshi\model\KaoshiSet as ksset;
use app\kaohao\model\Kaohao as KH;
use think\Validate;


class Index extends AdminBase 
{
    // 生成考号
    public function createAll($kaoshi_id)
    {
        // 获取参考年级
        $ksset = new ksset;
        $list['data']['nianji'] = $ksset->srcGrade($kaoshi_id);
        $list['data']['nianjiNum'] = array_column($list['data']['nianji'], 'ruxuenian');

        // 设置页面标题
        $list['set'] = array(
            'webtitle' => '生成考号'
            ,'butname' => '生成'
            ,'formpost' => 'POST'
            ,'url' => '/kaohao/index/saveall'
            ,'kaoshi_id' => $kaoshi_id
        );

        // 模板赋值
        $this->view->assign('list', $list);
        // 渲染
        return $this->view->fetch();
    }


    // 保存考号
    public function saveAll()
    {
        // 获取表单数据
        $list = request()->only([
            'school_id'
            ,'kaoshi_id'
            ,'banji_id'
        ], 'POST');

        event('kslu', $list['kaoshi_id']);
        // 验证表单数据
        $validate = new \app\kaohao\validate\Kaohao;
        $result = $validate->check($list);
        $msg = $validate->getError();
        if(!$result){
            return ['msg' => $msg, 'val' => 0];
        }

        // 获取参加考试学生名单
        $stu = new \app\student\model\Student;
        $src = [
            'banji_id' => $list['banji_id']
            ,'kaoshi' => 1
            ,'status' => 1
        ];
        $stulist = $stu->search($src)
            ->visible([
                'id'
                ,'school_id'
                ,'banji_id'
                ,'stuBanji' => [
                    'id'
                    ,'ruxuenian'
                    ,'paixu'
                ]
            ]);

        // 获取参加考试年级数组
        $enddate = KS::where('id', $list['kaoshi_id'])->value('enddate');
        $njlist =  \app\facade\Tools::nianJiNameList($enddate, 'str');
        // 重新组合学生信息
        $kaohao = array();
        foreach ($stulist as $key => $value) {
            $check = KH::withTrashed()
                ->where('kaoshi_id', $list['kaoshi_id'])
                ->where('student_id', $value->id)
                ->find();
            if($check)
            {
                if($check->delete_time > 0)
                {
                    $check->restore();
                }
                if($check->status == 0)
                {
                    $check->status = 1;
                    $check->save();
                }
                continue;
            }
            $kaohao[$key]['student_id'] = $value->id;
            $kaohao[$key]['school_id'] = $list['school_id'];
            $kaohao[$key]['ruxuenian'] = $value->stuBanji->ruxuenian;
            $kaohao[$key]['nianji'] = $njlist[$kaohao[$key]['ruxuenian']];
            $kaohao[$key]['banji_id'] = $value->stuBanji->id;
            $kaohao[$key]['paixu'] = $value->stuBanji->paixu;
            $kaohao[$key]['kaoshi_id'] = $list['kaoshi_id'];
        }

        // 保存考号
        $kh = new KH;
        $data = $kh
            ->allowField([ # 不是最佳实践
                'id'
                ,'kaoshi_id'
                ,'student_id'
                ,'school_id'
                ,'ruxuenian'
                ,'nianji'
                ,'banji_id'
                ,'paixu'
                ,'create_time'
                ,'update_time'
            ])
            ->saveAll($kaohao);

        // 根据更新结果设置返回提示信息
        $data ? $data = ['msg' => '生成成功', 'val' => 1]
            : $data = ['msg' => '数据处理错误', 'val' => 0];

        // 返回信息
        return json($data);
    }


    // 添加单条考号
    public function create($kaoshi_id)
    {
        // 获取参考年级、学科
        $ksset = new ksset;
        $list['data']['nianji'] = $ksset->srcGrade($kaoshi_id);
        $kh = new KH;
        $src['kaoshi_id'] = $kaoshi_id;
        if(count($list['data']['nianji']) > 0){
            $src['ruxuenian'] = $list['data']['nianji'][0];
        } else {
            $src['ruxuenian'] = array();
        }

        // 设置页面标题
        $list['set'] = array(
            'webtitle' => '添加考号'
            ,'butname' => '添加'
            ,'formpost' => 'POST'
            ,'url' => '/kaohao/index/save'
            ,'kaoshi_id' => $kaoshi_id
        );

        // 模板赋值
        $this->view->assign('list', $list);
        // 渲染
        return $this->view->fetch();
    }


    // 保存单条考号
    public function save()
    {
        // 获取表单数据
        $list = request()->only([
            'kaoshi_id'
            ,'banji_id'
            ,'student_id'
            ,'school_id'
        ], 'POST');
        $list['student_id'] = explode(' ', $list['student_id']);
        $list['student_id'] = $list['student_id'][1];

        event('kslu', $list['kaoshi_id']);

        // 查询考号是否存在
        $ks = KH::withTrashed()
                ->where('kaoshi_id', $list['kaoshi_id'])
                ->where('student_id', $list['student_id'])
                ->find();

        // 如果存在成绩则更新，不存在则添加
        if($ks)
        {
            // 判断记录是否被删除
            if($ks->delete_time > 0)
            {
                $ks->restore();
            }
            $data = ['msg' => '生成成功', 'val' => 1];
        }else{
            // 获取参加考试年级数组
            $enddate = KS::where('id', $list['kaoshi_id'])->value('enddate');
            $njlist = nianJiNameList('str', $enddate);

            // 获取班级信息
            $bj = new \app\teach\model\Banji;
            $bjinfo = $bj->where('id', $list['banji_id'])->find();
            $list['ruxuenian'] = $bjinfo->ruxuenian;
            $list['nianji'] = $njlist[$bjinfo->ruxuenian];
            $list['paixu'] = $bjinfo->paixu;
            $data = KH::create($list);
        }

        // 根据更新结果设置返回提示信息
        $data ? $data = ['msg' => '生成成功', 'val' => 1]
            : $data = ['msg' => '数据处理错误', 'val' => 0];

        // 返回信息
        return json($data);
    }


    // 学生信息
    public function read($id)
    {
        $kh = new \app\kaohao\model\Kaohao;
        $khInfo = $kh->where('id', $id)
            ->with([
                'cjKaoshi' => function ($query) {
                    $query->field('id, title, bfdate, enddate');
                }
            ])
            ->find();
        $list['webtitle'] = $khInfo->cjKaoshi->title;
        $list['id'] = $khInfo->id;

        // 模板赋值
        $this->view->assign('list', $list);

        return $this->view->fetch();
    }


    // 删除考号
    public function delete($id)
    {
        // 整理数据
        $id = request()->delete('id');
        $id = explode(',', $id);

        if(isset($id[0]))
        {
            $ksid = KH::where('id', $id[0])->value('kaoshi_id');
            event('kslu', $ksid);
            $data = KH::destroy($id);
        }else{
            $data = false;
        }

        // 根据更新结果设置返回提示信息
        $data ? $data = ['msg' => '删除成功', 'val' => 1]
            : $data = ['msg' => '数据处理错误', 'val' => 0];
    // 返回信息
        return json($data);
    }
}
