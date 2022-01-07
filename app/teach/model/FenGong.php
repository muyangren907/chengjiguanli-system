<?php
namespace app\teach\model;

use app\BaseModel;

/**
 * @mixin \think\Model
 */
class FenGong extends BaseModel
{
    // 设置字段信息
    protected $schema = [
        'id' =>   'int'
        ,'banji_id' =>     'int'
        ,'subject_id' =>   'int'
        ,'teacher_id' =>   'int'
        ,'create_time' =>  'int'
        ,'bfdate' => 'int'
        ,'update_time' =>  'int'
        ,'delete_time' =>  'int'
        ,'beizhu' =>  'varchar'
    ];


    // 按条件查询分工
    public function search($srcfrom)
    {
        // 整理变量
        $src = [
            'searchval' => ''
            ,'page' => 1
            ,'limit' => 10
            ,'field' => 'id'
            ,'order' => 'desc'
            ,'subject_id' => ''
            ,'xueqi_id' => ''
            ,'all' => false
        ];
        $src = array_cover($srcfrom, $src);
        $src['subject_id'] = str_to_array($src['subject_id']);
        $src['xueqi_id'] = str_to_array($src['xueqi_id']);

        // 查询数据
        $data = $this
            ->when(strlen($src['searchval']) > 0, function($query) use($src){
                $query->where('title|jiancheng', 'like', '%' . $src['searchval'] . '%');
            })
            ->when(count($src['subject_id']) > 0, function($query) use($src){
                $query->where('subject_id', 'in', $src['subject_id']);
            })
            ->when(count($src['xueqi_id']) > 0, function($query) use($src){
                $query->where('xueqi_id', 'in', $src['xueqi_id']);
            })
            ->when($src['all'] == false, function ($query) use($src) {
                $query
                    ->page($src['page'], $src['limit']);
            })
            ->with([
                'fgXueqi' => function ($query) {
                    $query->field('id, title');
                }
                ,'fgSubject' => function ($query) {
                    $query->field('id, title, jiancheng, lieming');
                }
            ])
            ->order([$src['field'] => $src['order']])
            ->select();
        return $data;
    }


    // 学期关联
    public function fgXueqi()
    {
        return $this->belongsTo(\app\teach\model\Xueqi::class, 'xueqi_id', 'id');
    }


    // 学期关联
    public function fgSubject()
    {
        return $this->belongsTo(\app\teach\model\Subject::class, 'xueqi_id', 'id');
    }



}
