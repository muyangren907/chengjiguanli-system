<?php

namespace app\admin\controller;

// 引用控制器基类
use app\BaseController;
// 引用用户数据模型
use app\admin\model\Admin as AD;
// 引用加密类
use WhiteHat101\Crypt\APR1_MD5;

class Index extends BaseController
{
    // 管理员列表
    public function index()
    {
        // 设置要给模板赋值的信息
        $list['webtitle'] = '管理员列表';

        // 模板赋值
        $this->assign('list',$list);

        // 渲染模板
        return $this->fetch();
    }


    // 获取数据管理员数据
    public function ajaxData()
    {
        // 获取参数
        $src = $this->request
                ->only([
                    'page'=>'1'
                    ,'limit'=>'10'
                    ,'field'=>'id'
                    ,'type'=>'desc'
                    ,'searchval'=>''
                ],'POST');

        // 实例化
        $ad = new AD;

        // 查询要显示的数据
        $data = $ad->search($src);

        // 获取符合条件记录总数
        $cnt = $data->count();
        // 获取当前页数据
        $limit_start = $src['page'] * $src['limit'] - $src['limit'];
        $limit_length = $src['limit'];
        $data = $data->slice($limit_start,$limit_length);
       
        // 重组返回内容
        $data = [
            'code'=> 0 , // ajax请求次数，作为标识符
            'msg'=>"",  // 获取到的结果数(每页显示数量)
            'count'=>$cnt, // 符合条件的总数据量
            'data'=>$data, //获取到的数据结果
        ];

        return json($data);
    }

    
    // 创建用户信息
    public function create()
    {
        // 设置页面标题
        $list['set'] = array(
            'webtitle'=>'添加管理员',
            'butname'=>'添加',
            'formpost'=>'POST',
            'url'=>'/admin',
        );


        // 模板赋值
        $this->assign('list',$list);
        // 渲染
        return $this->fetch('create');
    }

    
    // 保存管理员
    public function save()
    {

        // 实例化加密类
        $md5 = new APR1_MD5();
        // 实例化验证模型
        $validate = new \app\admin\validate\Admin;


        // 获取表单数据
        $list = request()->only(['xingming','school','username','sex','shengri','phone','beizhu','group_id'],'post');


        // 设置密码，默认为123456
        $list['password'] = $md5->hash('123456');


        // 验证表单数据
        $result = $validate->check($list);
        $msg = $validate->getError();


        // 如果验证不通过则停止保存
        if(!$result){
            return json(['msg'=>$msg,'val'=>0]);;
        }

        // 实例化管理员数据模型类 
        $admin = new AD();
        $admindata = $admin->create($list);

        // 更新中间表
        $groupdata=$admindata->glGroup()->saveAll($list['group_id']);


        // 根据更新结果设置返回提示信息
        $admindata&&$groupdata ? $data=['msg'=>'添加成功','val'=>1] : $data=['msg'=>'数据处理错误','val'=>0];

        // 返回信息
        return json($data);
      
    }

 


    // 读取用户信息
    public function read($id)
    {
        // 获取管理员信息
        $ad = new AD;
        $list = AD::where('id',$id)
                ->field('id,xingming,sex,shengri,username,school,phone,denglucishu,lastip,ip,lasttime,thistime,create_time,update_time')
                ->with([
                    'adSchool'=>function($query){
                        $query->field('id,title');
                    }
                ])
                ->find();
        $list['webtitle'] = '帐号信息';
        $list->groupnames = $ad->getGroupnames($id);

        // 模板赋值
        $this->assign('list',$list);

        // 渲染模板
        return $this->fetch();
    }


    // 读取用户信息
    public function myinfo()
    {
        $id = session('userid');
        $ad = new AD;
        // 获取管理员信息
        $list = $ad->where('id',$id)
                ->field('id,xingming,sex,shengri,username,school,phone,denglucishu,lastip,ip,lasttime,thistime,create_time,update_time')
                ->with([
                    'adSchool'=>function($query){
                        $query->field('id,title');
                    }
                ])
                ->find();
        $list->groupnames = $ad->getGroupnames($id);


        $list['webtitle'] = '我的信息';

        // 模板赋值
        $this->assign('list',$list);


        // 渲染模板
        return $this->fetch('read');
    }

    


    //
    public function edit($id)
    {

        // 获取用户信息
       $list['data'] = AD::where('id',$id)
            ->field('id,school,username,xingming,sex,shengri,phone,beizhu')
            ->with([
                'adSchool'=>function($query){
                    $query->field('id,jiancheng');
                }
                ,'glGroup'=>function($query){
                    $query->where('status',1)->field('title,rules,miaoshu');
                }
            ])
            ->find();

        // 设置页面标题
        $list['set'] = array(
            'webtitle'=>'编辑管理员',
            'butname'=>'修改',
            'formpost'=>'PUT',
            'url'=>'/admin/'.$id,
        );


        // 模板赋值
        $this->assign('list',$list);
        // 渲染
        return $this->fetch('create');

    }

    // 更新管理员信息
    public function update($id)
    {

        // 实例化验证模型
        $validate = new \app\admin\validate\Admin;

        // 获取表单数据
        $list = request()->only(['xingming','school','username','sex','shengri','phone','beizhu','group_id'],'put');

        $list['group_id'] = array_values($list['group_id']);

        // 验证表单数据
        $result = $validate->check($list);
        $msg = $validate->getError();

        // 如果验证不通过则停止保存
        if(!$result){
            return json(['msg'=>$msg,'val'=>0]);;
        }


        // 更新管理员信息
        $list['id'] = $id;
        $admindata = AD::update($list);

        // 更新中间表
        $groupdata=$admindata->glGroup()->detach();
        $groupdata=$admindata->glGroup()->attach($list['group_id']);

        // 根据更新结果设置返回提示信息
        $admindata&&$groupdata ? $data=['msg'=>'更新成功','val'=>1] : $data=['msg'=>'数据处理错误','val'=>0];

        // 返回信息
        return json($data);
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {

        if($id == 'm'){
            $id = request()->delete('ids');
        }
        $id = explode(',', $id);

        $data = AD::destroy($id);

        // 根据更新结果设置返回提示信息
        $data ? $data=['msg'=>'删除成功','val'=>1] : $data=['msg'=>'数据处理错误','val'=>0];

        // 返回信息
        return json($data);
    }


    // 修改管理员状态
    public function setStatus()
    {

        //  获取id变量
        $id = request()->post('id');
        $value = request()->post('value');

        // 更新管理员信息
        $data = AD::where('id',$id)->update(['status'=>$value]);

        // 根据更新结果设置返回提示信息
        $data ? $data=['msg'=>'状态设置成功','val'=>1] : $data=['msg'=>'数据处理错误','val'=>0];

        // 返回信息
        return json($data);
    }


    // 重置密码
    public function resetpassword($id)
    {

        // 实例化加密类
        $md5 = new APR1_MD5();

        // 生成密码
        $password = $md5->hash('123456');

        // 查询用户信息
        $data = AD::where('id',$id)->update(['password'=>$password]);

        // 根据更新结果设置返回提示信息
        $data ? $data=['msg'=>'密码已经重置为:<br>123456','val'=>1] : $data=['msg'=>'数据处理错误','val'=>0];

        // 返回信息
        return json($data);
    }


    // 修改自己的密码
    public function editPassword()
    {
        // 设置页面标题
        $list['set'] = array(
            'webtitle'=>'修改密码',
            'butname'=>'修改',
            'formpost'=>'PUT',
            'url'=>'/editpassword/'.session('userid'),
        );

        // 模板赋值
        $this->assign('list',$list);

        // 渲染模板
        return $this->fetch();
    }


    // 保存新密码
    public function updatePassword($id)
    {
        // 获取表单数据
        $list = request()->post();

        // 验证表单数据
         // 实例化验证模型
        $validate = new \app\admin\validate\SetPassword;
        $result = $validate->check($list);
        $msg = $validate->getError();

        // 如果验证不通过则停止保存
        if(!$result){
            return json(['msg'=>$msg,'val'=>0]);;
        }

       
        // 获取用户名
        $serpassword = AD::where('id',$id)->value('password');

        // 实例化加密类
        $md5 = new APR1_MD5();
        //验证密码
        $check = $md5->check($list['oldpassword'],$serpassword);

        if(!$check)
        {
            $data=['msg'=>'旧密码错误','val'=>0];
            return json($data);
        }

        // 更新密码
        $password = $md5->hash($list['newpassword']);
        $data = AD::update(['id'=>$id,'password'=>$password]);


        // 根据更新结果设置返回提示信息
        $data ? $data=['msg'=>'修改成功','val'=>1] : $data=['msg'=>'数据处理错误','val'=>0];

        // 返回信息
        return json($data);
    }

}
