<?php

namespace app\chengji\model;

// 引用基类
use app\common\model\Base;


class Chengji extends Base
{
   

   // 定义更新成绩后计算平均分和总分
	protected static function init()
    {
        self::afterUpdate(function ($cj) {
        	$cj =self::where('id',$cj->id)->find();
        	// 重新组合数组
        	$num[] = $cj->yuwen;
        	$num[] = $cj->shuxue;
        	$num[] = $cj->waiyu;

        	// 删除空数据
			foreach ($num as $key => $value) {
				if($value == null)
				{
					unset($num[$key]);
				}
			}

			// 获取数组长度
			$cnt = count($num);

			// 如果存在数据则计算平均分与总分
			if($cnt>0)
			{
				$cj->stuSum=array_sum($num);
				$cj->stuAvg=$cj->stuSum/$cnt;
				$cj->stuAvg = round($cj->stuAvg,1);
			}

            $cj->save();
        });
    }





    
    // 学校信息关联表
    public function cjSchool()
    {
    	return $this->belongsTo('\app\system\model\School','school','id');
    }

    // 班级信息关联表
    public function cjBanji()
    {
    	return $this->belongsTo('\app\teach\model\Banji','banji','id');
    }

    // 学生信息关联
    public function cjStudent()
    {
    	return $this->belongsTo('\app\renshi\model\Student','student','id');
    }

    // 满分
    public function cjManfen()
    {
    	return $this->belongsTo('\app\kaoshi\model\KaoshiSubject','kaoshi','kaoshiid');
    }

    


	// 语文成绩获取器
	public function getYuwenAttr($val)
	{
		return $this->myval($val);
	}

	// 数学成绩获取器
	public function getShuxueAttr($val)
	{
		return $this->myval($val);
	}

	// 外语成绩获取器
	public function getWaiyuAttr($val)
	{
		return $this->myval($val);
	}

	// 总分成绩获取器
	public function getStuSumAttr($val)
	{
		return $this->myval($val);
	}

	// 平均分成绩获取器
	public function getStuAvgAttr($val)
	{
		return $this->myval($val);
	}



	// 班级名称(数字)获取器
	public function getBanjiNumnameAttr()
	{
		$bj = new \app\teach\model\Banji;
		$bj = $bj->find($this->getdata('banji'));

		// 返回班级名称 
		return $bj->numTitle;
	}


	// 格式化成绩
	public function myval($val)
	{
		$val == 0 ? $val='' : $val = $val*1;
		return $val;
	}


	// 查询根据考试ID查询考试成绩
	public function searchAjax($search)
	{
		// 获取参数
		$kaoshiid = $search['kaoshiid'];
		$schoolid = $search['school'];
		$nianji = $search['nianji'];
		$banji = $search['banji'];
		$order = $search['order'];
		$order_field = $search['order_field'];
		$search = $search['search'];



		$data = $this->scope('kaoshi',$kaoshiid)
            	->when($schoolid!='',function($query) use($schoolid){
                	$query->where('school','in',$schoolid);
                })
                ->when($nianji!='',function($query) use($nianji){
                	$query->where('nianji','in',$nianji);
                })
                ->when($banji!='',function($query) use($banji){
                	$query->where('banji','in',$banji);
                })
                ->when($search!='',function($query) use($search){
                	$query->where('student','in',function ($q) use($search){
                		$q->name('student')->where('xingming','like','%'.$search.'%')->field('id');
                	});
                })
              //   ->whereOr('student','in',function ($query) use($search){
            		// 	$query->name('student')->where('xingming','like','%'.$search.'%')->field('id');
            		// })
                ->order([$order_field=>$order])
                ->select();
        

        $data = $data->append(['cj_school.jiancheng','cj_banji.title','cj_student.xingming']);

    	return $data;
	}



	// 根据考试ID查询所有考试成绩
	public function searchAll($kaoshiid)
	{
		return $this::scope('kaoshi',$kaoshiid)
			// ->cache('key',180)
			->select();
	}


	// 查询年级成绩 
	public function searchNianji($kaoshiid,$nianji)
	{
		return $this->where('kaoshi',$kaoshiid)
				->where('nianji',$nianji)
				->field('id,yuwen,shuxue,waiyu')
				->cache('key',180)
				->select();
	}


	// 考试项目查询范围
	public function scopeKaoshi($query,$kaoshiid)
	{
		$query->where('kaoshi',$kaoshiid);
	}


	
}
