<?php

use think\migration\Seeder;

class Banji extends Seeder
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        $y = date('Y');
        $m = date('m');

        if ($m>=8)
        {
            $ruxuenian = $y;
        } else {
            $ruxuenian = $y - 1;
        }

        // 设置数据
        $rows= [
            [
                'school_id' => 2
                ,'ruxuenian' => $ruxuenian
                ,'paixu' => 1
            ]
            ,[
                'school_id' => 2
                ,'ruxuenian' => $ruxuenian
                ,'paixu' => 2
            ]
            ,[
                'school_id' => 2
                ,'ruxuenian' => $ruxuenian
                ,'paixu' => 3
            ]
        ];

        // 保存数据
        $this->table('banji')->insert($rows)->save();


    }
}