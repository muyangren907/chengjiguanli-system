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
        $db= new up($this->upcnf);

        // 设置要给模板赋值的信息
        $list['webtitle'] = '文件列表';
        $list['dataurl'] = 'file/data';

        $fileList = $db->fileList();
        foreach ($fileList as $key => $value) {
           $fileList[$key]['time'] = date('Y-m-d H:i:s', $value['time']);
        }
        $list['data'] = $fileList;
        halt($list['data']);

        // 模板赋值
        $this->view->assign('list', $list);

        // 渲染模板
        return $this->view->fetch();
    }


    // 数据库备份
    public function create()
    {
        $db= new up($this->upcnf);
        $aa = $db->dataList();
        $start = 0;
        // $rand = mt_rand(1000, 9999);
        // $file = time() . $rand;
        // $file =  (string)$file;
        // $file = array_column($aa, 'name');
        foreach ($aa as $key => $value) {
            $start1= $db->setFile()->backup($value['name'], $start);
        }

        $bb = $db->fileList();
    }


    // 数据库恢复
    public function daoru()
    {

    }


}
