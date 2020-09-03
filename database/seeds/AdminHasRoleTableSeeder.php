<?php

use Illuminate\Database\Seeder;

class AdminHasRoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $adminHasRole = \App\Models\AdminHasRole::first();
        if (!$adminHasRole) {
            \App\Models\AdminHasRole::insert([
                'admin_id' => 1,
                'role_id' => 1
            ]);
        }
    }
}
