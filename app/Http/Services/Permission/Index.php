<?php
namespace App\Http\Services\Permission;

use App\Http\Services\Base;
use App\Models\Permission;
use Illuminate\Http\Request;

class Index extends Base
{
    public static function dryRun(Request $request)
    {
        try {
            $permissions = Permission::with('permissionAdmin')->with(['allChild' => function($query) {
                $query->with('permissionAdmin');
            }])
                ->where('parent_id', 0)
                ->get();
            return static::response($permissions, '获取权限成功', 200);
        } catch (\Exception $e) {
            return static::response([], '获取权限失败', 500);
        }
    }
}
