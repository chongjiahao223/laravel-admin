<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminHasRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('admin_has_roles')) {
            //
            \DB::statement("
               CREATE TABLE `admin_has_roles` (
                  `admin_id` int(10) unsigned NOT NULL COMMENT 'adminID',
                  `role_id` int(10) unsigned NOT NULL COMMENT '角色ID',
                  PRIMARY KEY (`admin_id`,`role_id`) USING BTREE,
                  KEY `admin_has_roles_admin_id_foreign` (`admin_id`) USING BTREE,
                  KEY `admin_has_roles_role_id_foreign` (`role_id`) USING BTREE,
                  CONSTRAINT `admin_has_roles_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE,
                  CONSTRAINT `admin_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT COMMENT='管理员角色关联表';
            ");
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_has_roles');
    }
}
