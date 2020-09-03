<?php

use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $permission = \App\Models\Permission::select('id')->first();
        if (!$permission) {
            $data = [
                [
                    'name' => 'system',
                    'display_name' => '系统管理',
                    'parent_id' => 0,
                    'sort' => 0,
                    'type' => 2,
                    'admin_id' => 1,
                    'created_at' => date('Y-m-d H:i:s', time()),
                    'updated_at' => date('Y-m-d H:i:s', time()),
                ],
                [
                    'name' => 'permission',
                    'display_name' => '权限管理',
                    'parent_id' => 1,
                    'sort' => 0,
                    'type' => 2,
                    'admin_id' => 1,
                    'created_at' => date('Y-m-d H:i:s', time()),
                    'updated_at' => date('Y-m-d H:i:s', time()),
                ],
                [
                    'name' => 'role',
                    'display_name' => '角色管理',
                    'parent_id' => 1,
                    'sort' => 0,
                    'type' => 2,
                    'admin_id' => 1,
                    'created_at' => date('Y-m-d H:i:s', time()),
                    'updated_at' => date('Y-m-d H:i:s', time()),
                ],
                [
                    'name' => 'admin',
                    'display_name' => '账户管理',
                    'parent_id' => 1,
                    'sort' => 0,
                    'type' => 2,
                    'admin_id' => 1,
                    'created_at' => date('Y-m-d H:i:s', time()),
                    'updated_at' => date('Y-m-d H:i:s', time()),
                ],
                [
                    'name' => 'permission_create',
                    'display_name' => '创建权限',
                    'parent_id' => 2,
                    'sort' => 0,
                    'type' => 1,
                    'admin_id' => 1,
                    'created_at' => date('Y-m-d H:i:s', time()),
                    'updated_at' => date('Y-m-d H:i:s', time()),
                ],
                [
                    'name' => 'permission_edit',
                    'display_name' => '编辑权限',
                    'parent_id' => 2,
                    'sort' => 0,
                    'type' => 1,
                    'admin_id' => 1,
                    'created_at' => date('Y-m-d H:i:s', time()),
                    'updated_at' => date('Y-m-d H:i:s', time()),
                ],
                [
                    'name' => 'permission_delete',
                    'display_name' => '删除权限',
                    'parent_id' => 2,
                    'sort' => 0,
                    'type' => 1,
                    'admin_id' => 1,
                    'created_at' => date('Y-m-d H:i:s', time()),
                    'updated_at' => date('Y-m-d H:i:s', time()),
                ],
                [
                    'name' => 'role_create',
                    'display_name' => '创建角色',
                    'parent_id' => 3,
                    'sort' => 0,
                    'type' => 1,
                    'admin_id' => 1,
                    'created_at' => date('Y-m-d H:i:s', time()),
                    'updated_at' => date('Y-m-d H:i:s', time()),
                ],
                [
                    'name' => 'role_edit',
                    'display_name' => '编辑角色',
                    'parent_id' => 3,
                    'sort' => 0,
                    'type' => 1,
                    'admin_id' => 1,
                    'created_at' => date('Y-m-d H:i:s', time()),
                    'updated_at' => date('Y-m-d H:i:s', time()),
                ],
                [
                    'name' => 'role_delete',
                    'display_name' => '删除角色',
                    'parent_id' => 3,
                    'sort' => 0,
                    'type' => 1,
                    'admin_id' => 1,
                    'created_at' => date('Y-m-d H:i:s', time()),
                    'updated_at' => date('Y-m-d H:i:s', time()),
                ],
                [
                    'name' => 'role_permission',
                    'display_name' => '角色分配权限',
                    'parent_id' => 3,
                    'sort' => 0,
                    'type' => 1,
                    'admin_id' => 1,
                    'created_at' => date('Y-m-d H:i:s', time()),
                    'updated_at' => date('Y-m-d H:i:s', time()),
                ],
                [
                    'name' => 'admin_create',
                    'display_name' => '创建账户',
                    'parent_id' => 4,
                    'sort' => 0,
                    'type' => 1,
                    'admin_id' => 1,
                    'created_at' => date('Y-m-d H:i:s', time()),
                    'updated_at' => date('Y-m-d H:i:s', time()),
                ],
                [
                    'name' => 'admin_edit',
                    'display_name' => '编辑账户',
                    'parent_id' => 4,
                    'sort' => 0,
                    'type' => 1,
                    'admin_id' => 1,
                    'created_at' => date('Y-m-d H:i:s', time()),
                    'updated_at' => date('Y-m-d H:i:s', time()),
                ],
                [
                    'name' => 'admin_delete',
                    'display_name' => '删除账户',
                    'parent_id' => 4,
                    'sort' => 0,
                    'type' => 1,
                    'admin_id' => 1,
                    'created_at' => date('Y-m-d H:i:s', time()),
                    'updated_at' => date('Y-m-d H:i:s', time()),
                ],
                [
                    'name' => 'admin_role',
                    'display_name' => '账户分配角色',
                    'parent_id' => 4,
                    'sort' => 0,
                    'type' => 1,
                    'admin_id' => 1,
                    'created_at' => date('Y-m-d H:i:s', time()),
                    'updated_at' => date('Y-m-d H:i:s', time()),
                ],
            ];
            \App\Models\Permission::insert($data);
        }
    }
}
