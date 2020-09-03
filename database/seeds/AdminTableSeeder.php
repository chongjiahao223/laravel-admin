<?php

use Illuminate\Database\Seeder;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 判断是否有数据
        $admin = \App\Models\Admin::select('id')->first();
        if (!$admin) {
            // 创建数据
            \App\Models\Admin::create([
                'name' => 'admin',
                'phone' => 15555555555,
                'password' => 123456
            ]);
        }
    }
}
