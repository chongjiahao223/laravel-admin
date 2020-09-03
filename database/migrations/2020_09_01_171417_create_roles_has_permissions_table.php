<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolesHasPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('role_has_permissions')) {
            //
            \DB::statement("
               CREATE TABLE `role_has_permissions` (
                  `permission_id` int(10) unsigned NOT NULL,
                  `role_id` int(10) unsigned NOT NULL,
                  PRIMARY KEY (`permission_id`,`role_id`) USING BTREE,
                  KEY `role_has_permissions_role_id_foreign` (`role_id`) USING BTREE,
                  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
                  CONSTRAINT `role_has_permissions_role_id` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT COMMENT='角色-权限中间表';
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
        Schema::dropIfExists('roles_has_permissions');
    }
}
