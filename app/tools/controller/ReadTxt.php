<?php

declare(strict_types=1);

namespace app\tools\controller;

use app\BaseController;

class ReadTxt extends BaseController
{
   public function read(){
        // 获取表单数据
        $fileName = $this->request->post('url');

        $fengefu = DIRECTORY_SEPARATOR;
        // 读取表格数据
        $fileName = public_path() . 'uploads' . $fengefu . $fileName;

        $fp = fopen($fileName, 'r');
        if ($fp === false) {
            throw new Exception('无法打开文件!');
        }
        $arr = array();
        $i = 0;
        $gailan = "0";
        $info = array();

        while (!feof($fp)) {
            $buffer = stream_get_line($fp, 10000, chr(0xa) . chr(0)); //16进制空格后面还要跟一个0
            $buffer = chr(0xFF) . chr(0xFE) . $buffer;
            $string = self::utf16_to_utf8($buffer);
            $string = trim($string);
            $string = str_replace(array("/r/n", "/r", "/n", "\\ufeff"), "", $string);
            $string = self::replace_utf8bom($string);
            $left = mb_substr($string, 0, 4);

            switch ($left) {
                case '----':
                    # code...
                    if($i == 0 && !isset($arr[0]))
                    {
                        $i = 0;
                    } else {
                        $i = $i + 1;
                    }
                    $arr[$i] = "";
                    break;
                case '导出时间':
                    # code...
                    $first = mb_strpos($string, '：', 0) + 1;
                    $info['date'] = trim(mb_substr($string, $first));
                    break;
                case 'Mac地':
                    # code...
                    $first = strpos($string, ' ', 0) + 1;
                    $temp = substr($string, $first);
                    $temp = trim($temp);
                    if(isset($info['mac']))
                    {
                        $info['mac'] = $info['mac'] . ' ' . $temp;
                    } else {
                        $info['mac'] = $temp;
                    }
                    break;

                case '电脑型号':
                    # code...
                    if(!isset($info['xinghao']))
                    {
                        $first = mb_strpos($string, '号', 0) + 1;
                        $info['xinghao'] = trim(mb_substr($string, $first));
                    }
                    if($gailan == 0)
                    {
                        $gailan = $i;
                    }
                    
                    break;
                case '主板序列':
                    # code...
                    $first = mb_strpos($string, ' ', 0) + 1;
                    $info['xuliehao'] = trim(mb_substr($string, $first));
                    break;
                case '操作系统':
                    # code...
                    $first = mb_strpos($string, ' ', 0) + 1;
                    $info['xitong'] = trim(mb_substr($string, $first));
                    break;
                case '系统安装':
                    # code...
                    $first = mb_strpos($string, ' ', 0) + 1;
                    $info['xitong_time'] = trim(mb_substr($string, $first));
                    break;
                case '电脑概览':
                    # code...
                    $gailan = $i;
                    break;
            }
            if ($string == "") {
                continue;
            }
            if(strlen($arr[$i])>0)
            {
                $arr[$i] = $arr[$i]  . trim($string). '<br>';
            } else {
                $arr[$i] = trim($string) . '<br>';
            }
            
        }
        $info['gailan'] = $arr[$gailan];
        $info['info'] = implode('', $arr);
        return json($info);
    }


    /**
     * 将16位utf16转化为utf8
     * @param unknown $str
     * @return unknown|string
     */
    public static function utf16_to_utf8($str)
    {
        $c0 = ord($str[0]);
        $c1 = ord($str[1]);
        if ($c0 == 0xFE && $c1 == 0xFF) {
            $be = true;
        } else if ($c0 == 0xFF && $c1 == 0xFE) {
            $be = false;
        } else {
            return $str;
        }
        $str = substr($str, 2);
        $len = strlen($str);
        $dec = '';
        for ($i = 0; $i < $len; $i += 2) {
            $c = ($be) ? ord($str[$i]) << 8 | ord($str[$i + 1]) : ord($str[$i + 1]) << 8 | ord($str[$i]);
            if ($c >= 0x0001 && $c <= 0x007F) {
                $dec .= chr($c);
            } else if ($c > 0x07FF) {
                $dec .= chr(0xE0 | (($c >> 12) & 0x0F));
                $dec .= chr(0x80 | (($c >>  6) & 0x3F));
                $dec .= chr(0x80 | (($c >>  0) & 0x3F));
            } else {
                $dec .= chr(0xC0 | (($c >>  6) & 0x1F));
                $dec .= chr(0x80 | (($c >>  0) & 0x3F));
            }
        }
        return $dec;
    }

    function  replace_utf8bom( $str )  
    {  
        $charset [1] =  substr ( $str ,0,1);  
        $charset [2] =  substr ( $str ,1,1);  
        $charset [3] =  substr ( $str ,2,1);  
        if  (ord( $charset [1]) == 239 && ord( $charset [2]) == 187 && ord( $charset [3]) == 191)  
        {  
            return   substr ( $str ,3);  
        }  
        else   
        {  
            return  $str;  
        }  
    }  
}
