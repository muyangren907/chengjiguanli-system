<?php

namespace app\admin\controller;

// 引用控制器基类
use app\common\controller\Base;
// 引用用户数据模型
use app\admin\model\Admin;
// 引用加密类
use WhiteHat101\Crypt\APR1_MD5;

class Index extends Base
{
    // 管理员列表
    public function index()
    {
        //实例化管理员数据模型类
        $admin = new Admin();

        // 获取记录总数
        $count = $admin->where('id','<>',1)->count();

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
        //实例化管理员数据模型类
        $admin = new Admin();

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


        // 获取记录集总数
        $cnt = $admin->where('id','<>',1)->count();
        //查询数据
        $data = $admin
            ->field('id,xingming,sex,username,phone,shengri,denglucishu,status,create_time')
            ->where('id','>','1')
            ->order([$order_field=>$order])
            ->limit($limit_start,$limit_length)
            ->all();
        

        // 如果需要查询
        if($search){
            $data = $admin
                ->field('id,xingming,sex,username,phone,shengri,denglucishu,status,create_time')
                 ->where('id','>','1')
                ->order([$order_field=>$order])
                ->limit($limit_start,$limit_length)
                ->where('username|xingming','like','%'.$search.'%')
                ->all();
        }

        $datacnt = $data->count();
        
        


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
        
        // 实例化管理员数据模型类
        $admin = new Admin();
        // 实例化加密类
        $md5 = new APR1_MD5();

        // 获取表单数据
        $list = request()->only(['xingming','username','sex','shengri','phone','beizhu'],'post');

        // 设置密码，默认为123456
        $list['password'] = $md5->hash('123456');


        $data = $admin->save($list);

        $msg = array();

        // 根据更新结果设置返回提示信息
        $data ? $data=['msg'=>'添加成功','val'=>1] : $data=['msg'=>'数据处理错误','val'=>0];

        // 返回信息
        return json($data);
    }
  


    // 读取用户信息
    public function read($id)
    {
        // 实例化管理员数据模型类
        $admin = new Admin();

        // 获取管理员信息
        $list = $admin->get($id);

        // 模板赋值
        $this->assign('list',$list);

        // 渲染模板
        return $this->fetch();
    }

    


    //
    public function edit($id)
    {
        //实例化管理员数据模型
        $admin = new Admin();

        // 获取用户信息
        $list = $admin
            ->field('id,username,xingming,sex,shengri,phone,beizhu')
            ->get($id);

        $this->assign('list',$list);

        return $this->fetch();

    }

    // 更新管理员信息
    public function update($id)
    {
        // 实例化管理员数据模型类
        $admin = new Admin();

        // 获取表单数据
        $list = request()->put();

        $data = $admin->save($list,['id'=>$id]);

        // 根据更新结果设置返回提示信息
        $data ? $data=['msg'=>'更新成功','val'=>1] : $data=['msg'=>'数据处理错误','val'=>0];

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
        //实例化管理员数据模型类
        $admin = new Admin();

        if($id == 'm')
        {
            $id = request()->delete('ids/a');
        }

        $data = $admin->destroy($id);

        // 根据更新结果设置返回提示信息
        $data ? $data=['msg'=>'删除成功','val'=>1] : $data=['msg'=>'数据处理错误','val'=>0];

        // 返回信息
        return json($data);
    }


    // 修改管理员状态
    public function setStatus()
    {
        // 实例化管理员数据模型类
        $admin = new Admin();

        //  获取id变量
        $id = request()->post('id');
        $value = request()->post('value');

        // 获取管理员信息
        $list = $admin->get($id);

        // 修改状态值
        $list->status = $value;

        // 更新数据
        $data = $list->save();

        // 根据更新结果设置返回提示信息
        $data ? $data=['msg'=>'状态设置成功','val'=>1] : $data=['msg'=>'数据处理错误','val'=>0];

        // 返回信息
        return json($data);
    }


    // 重置密码
    public function resetpassword($id)
    {

        // 实例化管理员数据模型类
        $admin = new Admin();
        // 实例化加密类
        $md5 = new APR1_MD5();

        // 生成密码
        $password = $md5->hash('123456');

        // 查询用户信息
        $list = $admin->get($id);

        // 设置管理员新信息
        $list->password = $password;

        // 更新密码
        $data = $list->save(); 

        // 根据更新结果设置返回提示信息
        $data ? $data=['msg'=>'密码重置成功','val'=>1] : $data=['msg'=>'数据处理错误','val'=>0];

        // 返回信息
        return json($data);


    }
}
