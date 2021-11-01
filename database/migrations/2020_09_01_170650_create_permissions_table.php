<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('permissions')) {
            //
            \DB::statement("
               CREATE TABLE `permissions` (
                  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                  `name` varchar(191) NOT NULL,
                  `display_name` varchar(191) NOT NULL,
                  `icon` varchar(191) DEFAULT NULL COMMENT '图标class',
                  `parent_id` int(11) NOT NULL DEFAULT '0',
                  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
                  `type` int(11) NOT NULL DEFAULT '1' COMMENT '类型：1按钮，2菜单',
                  `admin_id` int(11) NOT NULL COMMENT '添加人ID',
                  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
                  `updated_at` timestamp NOT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '修改时间',
                  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
                  PRIMARY KEY (`id`) USING BTREE
                ) ENGINE=InnoDB COMMENT='权限表';
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
        Schema::dropIfExists('permissions');
    }
}
