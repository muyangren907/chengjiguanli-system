<?php
declare (strict_types = 1);

namespace app\searchtools\controller;

// 引用PhpSpreadsheet类
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Excel
{
    /**读取数据**/
    public function readXls($filename){
        $path = $filename;
        setlocale(LC_ALL, 'zh_CN');  //csv中文乱码
        $inputFileType = IOFactory::identify($path);
        $excelReader = IOFactory::createReader($inputFileType);
        if ($inputFileType == 'Csv') {   //csv文件读取设置
          $excelReader->setInputEncoding('GBK');
          $excelReader->setDelimiter(',');
        }
        $phpexcel = $excelReader->load($path);
        $activeSheet = $phpexcel->getActiveSheet();
        $sheet = $activeSheet->toArray();
        return $sheet;
    }


    /**
     * 获取文件信息并保存
     *
     * @param  file对象  $file
     * @param  array()  $list 文件信息
     *         str      $list['text']    文件分类标识
     *         str      $list['serurl']  文件存储位置
     *         file     $file  文件对象
     * @return array  $data
     *         str      $data['msg']  返回信息提示
     *         str      $data['val']  返回信息
     *         str      $data['url']  文件路径
     */
    function saveFileInfo($file, $list, $isSave = false)
    {
        $hash = $file->hash('sha1');
        $f = new \app\system\model\Fields;
        $serFile = $f::where('hash', $hash)->find();

        if($serFile)
        {
            $serFile->user_id = session('userid');
            $serFile->save();
            $data['msg'] = '文件已经存在';
            $data['val'] = true;
            $data['url'] = $serFile->url;
            return $data;
        }

        // 上传文件到本地服务器
        $savename = \think\facade\Filesystem::disk('public')
            ->putFile($list['serurl'], $file);
        // 重新组合文件路径
        $savename = str_replace("/", "\\", $savename);

        if($isSave==true){
            $list['url'] = $savename;
            $list['newname'] = substr($savename
                ,strripos($savename, '\\') + 1
                ,strlen($savename) - strripos($savename
                ,'\\'));
            $list['hash'] = $file->hash('sha1');
            $list['user_id'] = session('userid');
            $list['oldname'] = $file->getOriginalName();
            $list['fieldsize'] = $file->getSize();
            $list['category_id'] = $list['category_id'];
            $list['bianjitime'] = $file->getMTime( );
            $list['extension'] = $file->getOriginalExtension();
            $saveinfo = $f::create($list);
        }

        $data['msg'] = '上传成功';
        $data['val'] = true;
        $data['url'] = $savename;

        return $data;
    }

    
}
