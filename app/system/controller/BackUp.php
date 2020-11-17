<?php
declare (strict_types = 1);

namespace app\system\controller;

// 引用控制器基类
use app\base\controller\AdminBase;
// 引用数据库备份类文件
use wamkj\thinkphp\Backup as up;

class BackUp extends AdminBase
{
    protected $upcnf;


    protected function initialize()
    {
        $this->upcnf = config('shangma.backup');
    }


    public function index()
    {
        // 设置要给模板赋值的信息
        $list['webtitle'] = '文件列表';
        $list['dataurl'] = '/system/backup/data';

        // 模板赋值
        $this->view->assign('list', $list);
        // 渲染模板
        return $this->view->fetch();
    }


    //  获取单位列表数据
    public function ajaxData()
    {
        // 获取参数
        $src = $this->request
                ->only([
                    'page' => '1'
                    ,'limit' => '10'
                    ,'field' => 'time'
                    ,'order' => 'desc'
                ],'POST');

        $db= new up($this->upcnf);
        $data = $db->fileList();
        foreach ($data as $key => $value) {
           $data[$key]['ltime'] = date('Y-m-d H:i:s', $value['time']);
           $data[$key]['lsize'] = round($value['size'] / 1024 / 1024, 2) . 'Mb';
        }
        $data = reSetArray($data, $src);

        return json($data);
    }


    // 数据库备份
    public function create()
    {
        $db= new up($this->upcnf);
        $aa = $db->dataList();
        $start = 0;
        foreach ($aa as $key => $value) {
            $start1= $db->setFile()->backup($value['name'], $start);
        }

        // 根据更新结果设置返回提示信息
        $data = ['msg' => '创建成功', 'val' => 1];
        // 返回信息
        return json($data);
    }


    // 数据库恢复
    public function daoru()
    {
        $db= new up($this->upcnf);
        // // $db->repair($tables);

        $start= $db->getFile('2020-11-04 21:30:38');
        $file = $start['file'];
        // dump($start);
        // halt($file);
        $s = 0;
        $start= $db->setFile($file)->import($s);

    }


    // 删除备份
    public function delete($time)
    {
        $db= new up($this->upcnf);
        $data = $db->delFile($time);
        // 根据更新结果设置返回提示信息
        $data ? $data = ['msg' => '删除成功', 'val' => 1]
            : $data = ['msg' => '数据处理错误', 'val' => 0];

        // 返回信息
        return json($data);
    }


}
