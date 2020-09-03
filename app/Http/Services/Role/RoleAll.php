<?php
namespace App\Http\Services\Role;

use App\Http\Services\Base;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleAll extends Base
{
    public static function dryRun(Request $request)
    {
        try {
            $roles = Role::select('id', 'name', 'status')->where('status', 1)->get();
            return static::response($roles, '获取角色成功', 200);
        } catch (\Exception $e) {
            return static::response([], '获取角色失败', 500);
        }
    }
}
