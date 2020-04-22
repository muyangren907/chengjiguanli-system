<?php
// 这是系统自动生成的公共文件

// Category
function getNewCategory($old_id)
{
    $new = new \app\update\model\Category;
    $old = new \app\system\model\Category;

    $title = $old->where('id', $old_id)->value('title');
    $new_id = $new->where('title', $title)->value('id');

    $new_id > 0 ? $new_id : $new_id = 0;

    return $new_id;
}


// Subject
function getNewSubject($old_id)
{
    $new = new \app\update\model\Subject;
    $old = new \app\teach\model\Subject;

    $title = $old->where('id', $old_id)->value('title');
    $new_id = $new->where('title', $title)->value('id');

    return $new_id;
}


// 鉴定等级
function getNewDengji($dengji)
{
    $dj = [
        0 => 11801
        ,1 => 11802
        ,2 => 11803
        ,3 => 11804
    ];
    return $dj[$dengji];
}

