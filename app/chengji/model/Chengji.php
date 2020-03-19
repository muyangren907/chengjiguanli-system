<?php

namespace app\chengji\model;

// 引用基类
use app\common\model\Base;


class Chengji extends Base
{


    // 学科关联
    public function subjectName()
    {
        return $this->belongsTo('\app\teach\model\Subject','subject_id','id');
    }

    // 学科关联
    public function userName()
    {
        return $this->belongsTo('\app\admin\model\Admin','user_id','id');
    }

    // 考号关联
    public function cjKaohao()
    {
        return $this->belongsTo('\app\kaoshi\model\Kaohao','kaohao_id','id');
    }



    // 列出已录成绩列表
    public function searchLuru($srcfrom)
    {
        // 初始化参数
        $src = array(
            'field'=>'update_time',
            'order'=>'desc',
            'kaoshi'=>'0',
            'banji'=>array(),
            'subject_id'=>'',
            'searchval'=>'',
            'user_id'=>session('userid'),
        );

        // 用新值替换初始值
        $src = array_cover( $srcfrom , $src ) ;
        $src['banji'] = strToarray($src['banji']);
        // $subject_id = $src['subject_id'];
        // $kaoshi = $src['kaoshi'];
        // $searchval = $src['searchval'];

        $stu = new \app\renshi\model\Student;
        $stuid = $stu
                    ->when(strlen($src['searchval'])>0,function($query)use($src){
                        $query->where('xingming','like','%'.$src['searchval'].'%')
                            ->field('id');
                    })
                    ->column('id');


        $nianji = nianjiList();
        $cjList = $this
                ->whereMonth('update_time')
                ->where('user_id',$src['user_id'])
                ->when(is_numeric($src['subject_id']),function($query)use($src){
                    $query->where('subject_id',$src['subject_id']);
                })
                ->when(count($stuid)>0,function($query)use($stuid){
                    $query->where('kaohao_id','in',function($q)use($stuid){
                        $q->name('kaohao')
                            ->where('student','in',$stuid)
                            ->whereTime('update_time','-480 hours')
                            ->field('id');
                    });
                })
                ->with([
                    'subjectName'=>function($query){
                        $query->field('id,title,lieming');
                    }
                    ,'cjKaohao'=>function($query){
                        $query->field('id,kaoshi,school,ruxuenian,nianji,banji,paixu,student')
                            ->append(['banjiTitle'])
                            ->with([
                            'cjSchool'=>function($query){
                                $query->field('id,jiancheng,paixu');
                            }
                            ,'cjStudent'=>function($query){
                                $query->field('id,xingming,sex');
                            }
                            ,'cjKaoshi'=>function($query){
                                $query->field('id,title');
                            }
                        ]);
                    }
                ])
                ->select();

        // 重新整理成绩
        $data = array();
        foreach ($cjList as $key => $value) {
            $data[$key] = [
                'id'=>$value->id,
                'kaoshi'=>$value->cjKaohao->cjKaoshi->title,
                'kaoshiid'=>$value->cjKaohao->cjKaoshi->id,
                'kaohaoid'=>$value->cjKaohao->id,
                'school'=>$value->cjKaohao->cjSchool->jiancheng,
                'schoolid'=>$value->cjKaohao->cjSchool->paixu,
                'banji'=>$value->cjKaohao->banjiTitle,
                'banjiid'=>$value->cjKaohao->banji,
                'subject'=>$value->subjectName->title,
                'subjectid'=>$value->id,
                'subjectname'=>$value->subjectName->lieming,
                'defen'=>$value->defen,
                'status'=>$value->status,
                'update_time'=>$value->update_time,
            ];
            $value->cjKaohao->cjStudent ? $data[$key]['student']=$value->cjKaohao->cjStudent->xingming : $data[$key]['student']= '';
        }

        // 按条件排序
        $src['order'] == 'desc' ? $src['order'] =SORT_DESC :$src['order'] = SORT_ASC;
        if(count($data)>0){
            $data = sortArrByManyField($data,$src['field'],$src['order']);
        }


        return $data;
    }



    // 列出要显示的学生所有学科成绩
    public function search($srcfrom)
    {

        // 初始化参数
        $src = array(
            'field'=>'banji',
            'order'=>'desc',
            'kaoshi'=>'',
            'banji'=>array(),
            'searchval'=>''
        );

        // 用新值替换初始值
        $src = array_cover( $srcfrom , $src ) ;

        // 实例化考号数据模型
        $kh = new \app\kaoshi\model\Kaohao;

        // 以考号为基础查询成绩
        $chengjilist = $kh->srcChengji($src);


        // 按条件排序
        $src['order'] == 'desc' ? $src['order'] =SORT_DESC :$src['order'] = SORT_ASC;
        if(count($chengjilist)>0){
            $chengjilist = sortArrByManyField($chengjilist,$src['field'],$src['order']);
        }

        return $chengjilist;

    }



    /**
    * 把给定的成绩进行排序
    * @access public
    * @param array $cj 要计算的一维数组成绩
    * @param array $col 0=>paixu,1=>weizhi
    * @param int $xm 项目 0=>学科得分,1=>平均分,2=>总分
    * @param int $jibie 级别  1=>班级，2=>年级，3=>区
    * @return array $result 返回成绩排序结果
    */
    public function saveOrder($cj,$col)
    {
        $cnt = count($cj);      # 获取元素数量
        if($cnt == 0)
        {
            return true;
        }

        arsort($cj);
        $khids = array_keys($cj);   # 获取考号即键值
        $data = array();    # 新数据容器

        foreach ($khids as $key => $value) {
            $data[$key]['id'] = $value;
            $data[$key][$col[0]] = $key +1 ;
            if($key > 0 && $cj[$khids[$key-1]] == $cj[$value])
            {
                $data[$key][$col[0]] = $data[$key-1][$col[0]];
            }
            $data[$key][$col[1]] = 1 - ($data[$key][$col[0]]-1)/$cnt;
            $data[$key][$col[1]] = round($data[$key][$col[1]] * 100 , 2) ;
        }

        $temp = $this->saveAll($data);

        return true;
    }

}
