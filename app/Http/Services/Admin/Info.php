<?php
namespace App\Http\Services\Admin;

use App\Http\Services\Base;
use App\Models\Admin;
use Illuminate\Http\Request;

class Info extends Base
{
    public static function dryRun(Request $request)
    {
        try {
            $permission = collect([]);
            // 获取登录用户
            $name = auth('api')->user();
            // 获取对应权限
            $admin = Admin::with(['role' => function($query) {
                $query->with('permission');
            }])
                ->where('id', $name->id)
                ->first();
            $admin->role->each(function ($item) use (&$permission) {
                $permission = $permission->merge($item->permission->pluck('name'))->unique();
            });
            $data = [
                'name' => $name->name,
                'permission' => $permission
            ];
            return static::response($data, '获取成功', 200);
        } catch (\Exception $e) {
            return static::response([], '获取失败', 500);
        }
    }
}
