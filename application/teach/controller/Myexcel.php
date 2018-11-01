<?php

namespace app\teach\controller;

// 引用PhpSpreadsheet类
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;


class Myexcel
{
    // 读取电子表格
    public function readExcel($filename = '/public/upload/Book1.xls')
    {
        $path = $filename;
        dump($path);
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


    // 生成电子表格
    public function outExcel()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Welcome to Helloweba.');

        $writer = new Xlsx($spreadsheet);
        $writer->save('hello.xlsx');
    }
    
}
