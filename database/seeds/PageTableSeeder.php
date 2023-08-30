<?php

use Illuminate\Database\Seeder;

class PageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            array(
                'title'=>'Hỏi đáp',
                'type'=>'1',
                'slug'=>'hoi-dap',
                'status'=>'active'
            ),
            array(
                'title'=>'Trợ giúp',
                'type'=>'1',
                'slug'=>'tro-giup',
                'status'=>'active'
            ),
            array(
                'title'=>'Chính sách trả hàng',
                'type'=>'2',
                'slug'=>'chính-sach-tra-hang',
                'status'=>'active'
            ),
            array(
                'title'=>'Chính sách vận chuyển',
                'type'=>'2',
                'slug'=>'chinh-sach-van-chuyen',
                'status'=>'active'
            ),
        );

        DB::table('pages')->insert($data);
    }
}
