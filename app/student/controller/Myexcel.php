<?php

namespace app\student\controller;

// 引用PhpSpreadsheet类
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;


class Myexcel
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
}
