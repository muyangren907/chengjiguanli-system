<?php

namespace app\renshi\controller;

// 引用控制器基类
use app\BaseController;
// 引用教师数据模型类
use app\renshi\model\Teacher as TC;


class Teacher extends BaseController
{
    // 显示教师列表
    public function index()
    {
        // 设置要给模板赋值的信息
        $list['webtitle'] = '教师列表';
        $list['dataurl'] = 'teacher/data';

        // 模板赋值
        $this->view->assign('list', $list);

        // 渲染模板
        return $this->view->fetch();
    }


    /**
     * 显示教师信息列表
     *
     * @return \think\Response
     */
    public function ajaxData()
    {
        // 获取参数
        $src = $this->request
            ->only([
                'page'=>'1'
                ,'limit'=>'10'
                ,'field'=>'update_time'
                ,'order'=>'desc'
                ,'zhiwu'=>array()
                ,'danwei'=>array()
                ,'xueli'=>array()
                ,'tuixiu'=>0
                ,'searchval'=>''
            ], 'POST');


        // 实例化
        $teacher = new TC;
        $data = $teacher->search($src);
        $data = reSetObject($data, $src);

        return json($data);
    }


    // 显示教师列表
    public function delList()
    {
        // 设置要给模板赋值的信息
        $list['webtitle'] = '教师列表';
        $list['dataurl'] = '/renshi/teacher/datadel';
        $list['status'] = '/renshi/teacher/status';

        // 模板赋值
        $this->view->assign('list', $list);

        // 渲染模板
        return $this->view->fetch();
    }


    /**
     * 显示教师信息列表
     *
     * @return \think\Response
     */
    public function ajaxDataDel()
    {
        // 获取参数
        $src = $this->request
            ->only([
                'page' => '1'
                ,'limit' => '10'
                ,'field' => 'update_time'
                ,'order' => 'desc'
                ,'zhiwu' => array()
                ,'danwei' => array()
                ,'xueli' => array()
                ,'searchval' => ''
            ], 'POST');

        // 实例化
        $teacher = new TC;
        $data = $teacher->searchDel($src);
        $data = reSetObject($data, $src);

        return json($data);
    }


    // 创建教师
    public function create()
    {
        // 设置页面标题
        $list['set'] = array(
            'webtitle' => '添加教师'
            ,'butname' => '添加'
            ,'formpost' => 'POST'
            ,'url' => 'save'
        );

        // 模板赋值
        $this->view->assign('list', $list);
        // 渲染
        return $this->view->fetch('create');
    }


    // 保存信息
    public function save()
    {
        // 获取表单数据
        $list = request()->only([
            'xingming'
            ,'sex'
            ,'quanpin'
            ,'shoupin'
            ,'shengri'
            ,'zhiwu'
            ,'zhicheng'
            ,'xueli'
            ,'biye'
            ,'worktime'
            ,'zhuanye'
            ,'danwei'
            ,'tuixiu'
        ], 'POST');

        // 验证表单数据
        $validate = new \app\renshi\validate\Teacher;
        $result = $validate->check($list);
        $msg = $validate->getError();

        $list['quanpin'] = trim(strtolower(str_replace(' ', '', $list['quanpin'])));
        $list['shoupin'] = trim(strtolower($list['shoupin']));

        // 如果验证不通过则停止保存
        if(!$result){
            return json(['msg' => $msg, 'val' => 0]);;
        }

        // 保存数据
        $data = TC::create($list);

        // 根据更新结果设置返回提示信息
        $data ? $data = ['msg' => '添加成功', 'val' => 1]
            : $data = ['msg' => '数据处理错误', 'val' => 0];

        // 返回信息
        return json($data);
    }


    // 查看教师信息
    public function read($id)
    {
        // 查询教师信息
        $myInfo = TC::withTrashed()
            ->where('id', $id)
            ->with(
                [
                    'jsDanwei' => function($query){
                        $query->field('id, title');
                    },
                    'jsZhiwu' => function($query){
                        $query->field('id, title');
                    },
                    'jsZhicheng' => function($query){
                        $query->field('id, title');
                    },
                    'jsXueli' => function($query){
                        $query->field('id, title');
                    },
                    'jsSubject' => function($query){
                        $query->field('id, title');
                    },
                ]
            )
            ->append(['age', 'gongling'])
            ->limit(1)
            ->select();
            $myInfo = $myInfo[0];
        // 设置页面标题
        $myInfo['webtitle'] = $myInfo->xingming . '信息';

        // 模板赋值
        $this->view->assign('list', $myInfo);
        // 渲染模板
        return $this->view->fetch();
    }


    // 修改教师信息
    public function edit($id)
    {

        // 获取教师信息
        $list['data'] = TC::field('id, xingming, sex, quanpin, shoupin, shengri, zhiwu, zhicheng, xueli, biye, worktime, zhuanye, danwei, tuixiu')
            ->find($id);

        // 设置页面标题
        $list['set'] = array(
            'webtitle'=>'编辑教师'
            ,'butname'=>'修改'
            ,'formpost'=>'PUT'
            ,'url'=>'/renshi/teacher/update/' . $id
        );

        // 模板赋值
        $this->view->assign('list', $list);
        // 渲染
        return $this->view->fetch('create');
    }


    // 更新教师信息
    public function update($id)
    {
        // 获取表单数据
        $list = request()->only([
            'xingming'
            ,'sex'
            ,'quanpin'
            ,'shoupin'
            ,'shengri'
            ,'zhiwu'
            ,'zhicheng'
            ,'xueli'
            ,'biye'
            ,'worktime'
            ,'zhuanye'
            ,'danwei'
            ,'tuixiu'
        ], 'PUT');

        // 验证表单数据
        $validate = new \app\renshi\validate\Teacher;
        $result = $validate->check($list);
        $msg = $validate->getError();
        if(!$result){
            return json(['msg' => $msg, 'val' => 0]);;
        }

        $list['quanpin'] = trim(strtolower(str_replace(' ', '', $list['quanpin'])));
        $list['shoupin'] = trim(strtolower($list['shoupin']));
        // 更新数据
        $teacher = new TC();
        $teacherlist = $teacher->find($id);

        $teacherlist->xingming = $list['xingming'];
        $teacherlist->sex = $list['sex'];
        $teacherlist->quanpin = $list['quanpin'];
        $teacherlist->shoupin = $list['shoupin'];
        $teacherlist->shengri = $list['shengri'];
        $teacherlist->zhiwu = $list['zhiwu'];
        $teacherlist->zhicheng = $list['zhicheng'];
        $teacherlist->xueli = $list['xueli'];
        $teacherlist->biye = $list['biye'];
        $teacherlist->worktime = $list['worktime'];
        $teacherlist->zhuanye = $list['zhuanye'];
        $teacherlist->danwei = $list['danwei'];
        $teacherlist->tuixiu = $list['tuixiu'];

        $data = $teacherlist->save();

        // 根据更新结果设置返回提示信息
        $data>=0 ? $data = ['msg' => '更新成功', 'val' => 1]
            : $data = ['msg' => '数据处理错误', 'val' => 0];

        // 返回信息
        return json($data);
    }


    // 删除教师
    public function delete($id)
    {
        // 整理数据
        $id = request()->delete('id');
        $id = explode(',', $id);

        $data = TC::destroy($id);

        // 根据更新结果设置返回提示信息
        $data ? $data = ['msg' => '删除成功', 'val' => 1]
            : $data = ['msg' => '数据处理错误', 'val' => 0];

        // 返回信息
        return json($data);
    }


    // 恢复删除
     public function reDel($id)
    {
        $user = TC::onlyTrashed()->find($id);
        $data = $user->restore();

        // 根据更新结果设置返回提示信息
        $data ? $data = ['msg' => '恢复成功', 'val' => 1]
            : $data = ['msg' => '数据处理错误', 'val' => 0];

        // 返回信息
        return json($data);
    }


    // 设置教师状态
    public function setStatus()
    {
        //  获取id变量
        $id = request()->post('id');
        $value = request()->post('value');

        // 获取教师信息
        $data = TC::where('id', $id)->update(['status' => $value]);

        // 根据更新结果设置返回提示信息
        $data ? $data = ['msg' => '状态设置成功', 'val' => 1]
            : $data = ['msg' => '数据处理错误', 'val' => 0];

        // 返回信息
        return json($data);
    }


    // 批量添加
    public function createAll()
    {
        // 设置页面标题
        $list['set'] = array(
            'webtitle' => '批量上传教师信息'
            ,'butname' => '批传'
            ,'formpost' => 'POST'
            ,'url' => 'saveall'
        );

        // 模板赋值
        $this->view->assign('list', $list);
        // 渲染
        return $this->view->fetch();
    }


    // 批量保存
    public function saveAll()
    {
        // 获取表单数据
        $list = request()->only([
            'school'
            ,'url'
        ], 'POST');

        // 实例化操作表格类
        $excel = new \app\renshi\controller\Myexcel;;
        $teacherinfo = $excel->readXls(public_path() . 'public\\uploads\\' . $list['url']);

        // 判断表格是否正确
        if($teacherinfo[0][1] != "教师基本情况表" )
        {
            $this->error('请使用模板上传', '/login/err');
            return json($data);
        }

        $pinyin = new \Overtrue\Pinyin\Pinyin;

        // 删除标题行
        array_splice($teacherinfo, 0, 4);
        $teacherinfo = array_filter($teacherinfo,function($item){
                return $item[1] !== null && $item[2] !== null && $item[3] !== null ;
            });

        // 整理数据
        $i = 0;
        $teacherlist = array();

        foreach ($teacherinfo as $key => $value) {

            // 整理数据
            $teacherlist[$i]['xingming'] = $value[1];
            $teacherlist[$i]['sex'] = srcSex($value[2]);
            $teacherlist[$i]['shengri'] = $value[3];
            $teacherlist[$i]['worktime'] = $value[4];
            $teacherlist[$i]['zhiwu'] = srcZw($value[5]);
            $teacherlist[$i]['zhicheng'] = srcZc($value[6]);
            $teacherlist[$i]['danwei'] = $list['school'];
            $teacherlist[$i]['biye'] = $value[8];
            $teacherlist[$i]['subject'] = srcSubject($value[7]);
            $teacherlist[$i]['zhuanye'] = $value[9];
            $teacherlist[$i]['xueli'] = srcXl($value[10]);
            $quanpin = $pinyin->sentence($value[1]);
            $jianpin = $pinyin->abbr($value[1]);
            $teacherlist[$i]['quanpin'] = trim(strtolower(str_replace(' ', '', $quanpin)));
            $teacherlist[$i]['shoupin'] = trim(strtolower($jianpin));

            $i++;
        }

        // 实例化学生信息数据模型
        $teacher = new TC();

        // 保存或更新信息
        $data = $teacher->saveAll($teacherlist);

        // 返回添加结果
        $data ? $data = ['msg' => '数据上传成功', 'val' => 1]
            : ['msg' => '数据上传失败', 'val' => 0];

        return json($data);
    }


    // 根据教师姓名、首拼、全拼搜索教师信息
    public function srcTeacher()
    {
        // 声明结果数组
        $data = array();
        $str = input("post.str");

        // 判断是否存在数据，如果没有数据则返回。
        if(strlen($str) <= 0){
            return json($data);
        }

        // 如果有数据则查询教师信息
        $list = TC::field('id, xingming, danwei, shengri, sex')
            ->whereOr('xingming', 'like', '%' . $str . '%')
            ->whereOr('shoupin','like',$str.'%')
            ->with(
                [
                    'jsDanwei' => function($query){
                        $query->field('id, jiancheng');
                    },
                ]
            )
            ->append(['age'])
            ->select();
        return json($list);
    }


    // 上传文件
    public function upload()
    {
        // 获取文件信息
        $list['category_id'] = $this->request->post('category_id');
        $list['serurl'] = $this->request->post('serurl');

        // 获取表单上传文件
        $file = request()->file('file');
        $data = saveFileInfo($file, $list, true);

        return json($data);
    }


    // 下载表格模板
    public function downloadXls()
    {
        $url = public_path().'public\\uploads\\teacher\\TeacherInfo.xlsx';
        return download($url,'教师名单模板.xlsx');
    }


    // 查询教师荣誉
    public function srcRy($teacherid)
    {
        // 实例化荣誉数据模型
        $ry = new \app\rongyu\model\JsRongyuInfo;

        // 查询荣誉信息
        $data = $ry->where('status', 1)
                ->where('id', 'in', function($query) use($teacherid){
                    $query->name('jsRongyuCanyu')
                        ->where('teacherid', $teacherid)
                        ->field('rongyuid');
                })
                ->with(
                [
                    'jxCategory'=>function($query){
                        $query->field('id, title');
                    },
                    'ryTuce'=>function($query){
                        $query->field('id, title, fzschool, category')
                            ->with([
                                    'fzSchool'=>function($query){
                                        $query->field('id, jiancheng, jibie')
                                        ->with(['dwJibie'=>function($q){
                                            $q->field('id, title');
                                        }]);
                                    },
                                    'lxCategory'=>function($query){
                                        $query->field('id, title');
                                    },

                                ]);
                    },
                    'hjJsry'=>function($query){
                        $query->field('rongyuid, teacherid')
                        ->with(['teacher'=>function($query){
                            $query->field('id, xingming');
                        }]);
                    },
                ])
                ->field('id, rongyuce, jiangxiang, hjshijian, title')
                ->order('hjshijian')
                ->select();

       // 获取符合条件记录总数
        $cnt = $data->count();

        // 重组返回内容
        $data = [
            'code'=> 0 , // ajax请求次数，作为标识符
            'msg'=>"",  // 获取到的结果数(每页显示数量)
            'count'=>$cnt, // 符合条件的总数据量
            'data'=>$data, //获取到的数据结果
        ];


        return json($data);
    }


    // 查询教师课题
    public function srcKt($teacherid)
    {
        // 实例化荣誉数据模型
        $ry = new \app\keti\model\KetiInfo;

        // 查询荣誉信息
        $data = $ry->where('status',1)
                ->where('id','in',function($query) use($teacherid){
                    $query->name('KetiCanyu')
                        ->where('teacherid',$teacherid)
                        ->field('ketiinfoid');
                })
                ->with(
                [
                    'fzSchool'=>function($query){
                        $query->field('id,jiancheng,jibie')
                            ->with(['dwJibie'=>function($q){
                                $q->field('id,title');
                            }]);
                    },
                    'ktCategory'=>function($query){
                        $query->field('id,title');
                    },
                      'ktZcr'=>function($query){
                        $query->field('ketiinfoid,teacherid')
                            ->with([
                                'teacher'=>function($q){
                                    $q->field('id,xingming');
                                }
                            ]);
                    }
                ])
                ->field('id,title,fzdanweiid,category,jddengji')
                ->order('id')
                ->select();

       // 获取符合条件记录总数
        $cnt = $data->count();

        // 重组返回内容
        $data = [
            'code'=> 0 , // ajax请求次数，作为标识符
            'msg'=>"",  // 获取到的结果数(每页显示数量)
            'count'=>$cnt, // 符合条件的总数据量
            'data'=>$data, //获取到的数据结果
        ];


        return json($data);
    }



}
