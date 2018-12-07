<?php

namespace app\admin\controller;

// 引用控制器基类
use app\common\controller\Base;
// 引用用户数据模型
use app\admin\model\Admin as AD;
// 引用加密类
use WhiteHat101\Crypt\APR1_MD5;

class Index extends Base
{
    // 管理员列表
    public function index()
    {

        $count = AD::where('id','>',2)->count();

        // 设置要给模板赋值的信息
        $list['title'] = '管理员列表';
        $list['count'] = $count;

        // 模板赋值
        $this->assign('list',$list);

        // 渲染模板
        return $this->fetch();
    }


    // 获取数据管理员数据
    public function ajaxData()
    {


        // 获取DT的传值
        $getdt = request()->param();

        //得到排序的方式
        $order = $getdt['order'][0]['dir'];
        //得到排序字段的下标
        $order_column = $getdt['order'][0]['column'];
        //根据排序字段的下标得到排序字段
        $order_field = $getdt['columns'][$order_column]['data'];
        //得到limit参数
        $limit_start = $getdt['start'];
        $limit_length = $getdt['length'];
        //得到搜索的关键词
        $search = $getdt['search']['value'];


        
        //查询数据
        $data = AD::field('id,xingming,sex,username,phone,shengri,denglucishu,status,create_time')
            ->where('id','>','2')
            ->order([$order_field=>$order])
            ->limit($limit_start,$limit_length)
            ->select();
        // 获取记录集总数
        $cnt = $data->count();
        

        // 如果需要查询
        if($search){
            $data = AD::field('id,xingming,sex,username,phone,shengri,denglucishu,status,create_time')
                ->where('id','>','1')
                ->order([$order_field=>$order])
                ->limit($limit_start,$limit_length)
                ->where('username|xingming','like','%'.$search.'%')
                ->select();
        }

        $datacnt = $data->count();

        // 追加角色名
        $data = $data->append(['groupnames']);
        
        


        $data = [
            'draw'=> $getdt["draw"] , // ajax请求次数，作为标识符
            'recordsTotal'=>$datacnt,  // 获取到的结果数(每页显示数量)
            'recordsFiltered'=>$cnt,       // 符合条件的总数据量
            'data'=>$data, //获取到的数据结果
        ];

        return json($data);
    }

    
    // 创建用户信息
    public function create()
    {

        // 设置页面标题
        $list['title'] = '添加管理员';

        // 模板赋值
        $this->assign('list',$list);

        // 渲染
        return $this->fetch();
    }

    
    // 保存管理员
    public function save()
    {

        // 实例化加密类
        $md5 = new APR1_MD5();
        // 实例化验证模型
        $validate = new \app\admin\validate\Admin;


        // 获取表单数据
        $list = request()->only(['xingming','username','sex','shengri','phone','beizhu','group_id'],'post');


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
        // 重组用户角色列表
        foreach ($list['group_id'] as $key => $value) {
            $groupids[]=['group_id'=>$value];
        }
        $authgroupdata = $admindata->authgroup()->saveAll($groupids);

        // 根据更新结果设置返回提示信息
        $authgroupdata ? $data=['msg'=>'添加成功','val'=>1] : $data=['msg'=>'数据处理错误','val'=>0];

        // 返回信息
        return json($data);
      
    }

 


    // 读取用户信息
    public function read($id)
    {

        // 获取管理员信息
        $list = AD::get($id);

        // 模板赋值
        $this->assign('list',$list);

        // 渲染模板
        return $this->fetch();
    }

    


    //
    public function edit($id)
    {

        // 获取用户信息
        $list = AD::field('id,username,xingming,sex,shengri,phone,beizhu')
            ->get($id);
        // 追加用户id字符串
        $list = $list->append(['groupids']);


        $this->assign('list',$list);

        return $this->fetch();

    }

    // 更新管理员信息
    public function update($id)
    {

        // 实例化验证模型
        $validate = new \app\admin\validate\Admin;

        // 获取表单数据
        $list = request()->only(['xingming','username','sex','shengri','phone','beizhu','group_id'],'put');

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
       
        // 删除原来角色
        $aa = $admindata->authgroup()->delete();

        // 重组用户角色列表
        foreach ($list['group_id'] as $key => $value) {
            $groupids[]=['group_id'=>$value];
        }
        $groupdata = $admindata->authgroup()->saveAll($groupids);

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

        if($id == 'm')
        {
            $id = request()->delete('ids/a');
        }

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
    public function editPassword($id)
    {
        $list['id'] = $id;

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
