<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('admins')) {
            //
            \DB::statement("
               CREATE TABLE `admins` (
                  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
                  `name` varchar(60) NOT NULL DEFAULT '' COMMENT '管理员',
                  `phone` varchar(12) NOT NULL COMMENT '手机号',
                  `email` varchar(60) DEFAULT NULL COMMENT '邮箱',
                  `password` varchar(60) NOT NULL COMMENT '密码',
                  `remember_token` varchar(100) DEFAULT NULL,
                  `api_token` varchar(100) DEFAULT NULL,
                  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态 1、启用 2、关闭',
                  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '注册时间',
                  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '修改时间',
                  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
                  PRIMARY KEY (`id`) USING BTREE,
                  UNIQUE KEY `users_api_token` (`api_token`) USING BTREE,
                  UNIQUE KEY `users_username_unique` (`name`,`deleted_at`) USING BTREE,
                  UNIQUE KEY `users_phone_unique` (`phone`,`deleted_at`) USING BTREE
                ) ENGINE=InnoDB COMMENT='管理员表';
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
        Schema::dropIfExists('admins');
    }
}
