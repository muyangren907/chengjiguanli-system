<?php
declare (strict_types = 1);

namespace app\tools\controller;

use \app\base\controller\ToolsBase

class Index extends ToolsBase
{
    // // 将关联学生成绩转换成以学科列名为key得分为value的数组
    // public function subjectChengjiKeyAndValue($array = array())
    // {
    //     $arr = array();
    //     foreach ($array as $key => $value) {
    //         $array[$value->subjectName->lieming] = $value;
    //         unset($array[$key]);
    //     }
    //     return $array;
    // }


    // 给数组按多条件排序
    public function sortArrByManyField(){
      $args = func_get_args();
      if(empty($args)){
        return null;
      }
      $arr = array_shift($args);
      if(!is_array($arr)){
        throw new Exception("第一个参数不为数组");
      }

      foreach($args as $key => $field){
        if(is_string($field)){
          $temp = array();
          foreach($arr as $index => $val){
            $temp[$index] = $val[$field];
          }
          $args[$key] = $temp;
        }
      }
      $args[] = &$arr;//引用值
      $keys = array_keys($args[0]);
      call_user_func_array('array_multisort', $args);

      return array_pop($args);;
    }


    /**
     * 根据键值，用数组2的值替换数组1的值
     * $cover 覆盖数组，存储新值的数组
     * $covered 被覆盖数组，被更改值的数组
     * 返回 新arr1
     * */
    public function array_cover($cover = array(), $covered = array())
    {
        foreach ($cover as $key => $value) {
            if(isset($covered[$key]) == true)
            {
                $covered[$key] = $cover[$key];
            }
        }
        return $covered;
    }


    /**
    * 把request到的参数转换成数组，并删除空值
    *
    * @access public
    * @param str或array $str 表单中获取的参数
    * @return array 返回类型
    */
    public function strToArray($str)
    {
        // 如果str是字符串，则转换成数组
        if(is_array($str) == false)
        {
            $str = explode(',', $str);
        }
        // 循环数组，删除空元素
        foreach ($str as $key => $value) {
            if($value == "" && $value == null){
                unset($str[$key]);
            }
        }
        return $str;
    }


    /**
    * 把重新整理从数据模型中返回的对象
    * @access public
    * @param str或array $str 表单中获取的参数
    * @return array 返回类型
    */
    public function reSetObject($obj, $srcfrom)
    {
        // 整理变量
        $src = [
            'field' => 'update_time'
            ,'order' => 'desc'
            ,'page' => 1
            ,'limit' => 10
        ];
        $src = array_cover($srcfrom, $src) ;
        $str1 = $src['field'];
        $str2 = $src['order'];

        // 整理数据
        $cnt = $obj->count();
        $obj = $obj->order($src['field'], $src['order']);

        $limit_start = $src['page'] * $src['limit'] - $src['limit'];
        $limit_length = $src['limit'];
        $obj = $obj->slice($limit_start, $limit_length);
        $data = [
            'code' => 0  // ajax请求次数，作为标识符
            ,'msg' => ""  // 获取到的结果数(每页显示数量)
            ,'count' => $cnt // 符合条件的总数据量
            ,'data' => $obj //获取到的数据结果
        ];

        return $data;
    }


    /**
    * 把重新整理从数据模型中返回的对象
    * @access public
    * @param str或array $str 表单中获取的参数
    * @return array 返回类型
    */
    public function reSetArray($arr, $srcfrom)
    {
        // 整理变量
        $src = [
            'field' => 'update_time'
            ,'order' => 'desc'
            ,'page' => 1
            ,'limit' => 10
        ];
        $src = array_cover($srcfrom, $src) ;

        // 重新整理数据
        $cnt = count($arr);    # 记录总数
        if($cnt > 0){
            $src['order'] == 'desc' ? $src['order'] = SORT_DESC
                : $src['order'] = SORT_ASC;   # 数据排序
            $arr = sortArrByManyField($arr, $src['field'], $src['order']);
        }
        $limit_start = $src['page'] * $src['limit'] - $src['limit']; # 获取当前页数据
        $limit_length = $src['limit'];
        $arr = array_slice($arr, $limit_start, $limit_length);
        $data = [   # 数据合并
            'code' => 0 , # ajax请求次数，作为标识符
            'msg' => "",  # 获取到的结果数(每页显示数量)
            'count' => $cnt, # 符合条件的总数据量
            'data' => $arr, # 获取到的数据结果
        ];

        return $data;
    }
}
