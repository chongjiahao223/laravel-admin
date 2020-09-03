<?php

use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 判断是否有数据
        $role = \App\Models\Role::select('id')->first();
        if (!$role) {
            \App\Models\Role::create([
                'name' => '超级管理员',
                'admin_id' => 1
            ]);
        }
    }
}
