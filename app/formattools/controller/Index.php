<?php
declare (strict_types = 1);

namespace app\zhengli\model;

class Index
{
    // 将关联学生成绩转换成以学科列名为key得分为value的数组
    public function subjectChengjiKeyAndValue($array = array())
    {
        $arr = array();
        foreach ($array as $key => $value) {
            $array[$value->subjectName->lieming] = $value;
            unset($array[$key]);
        }
        return $array;
    }
}
