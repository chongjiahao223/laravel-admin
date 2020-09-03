<?php
namespace App\Http\Services\Role;

use App\Http\Services\Base;
use App\Models\Role;
use Illuminate\Http\Request;

class Index extends Base
{
    public static function dryRun(Request $request)
    {
        try {
            $roles = Role::with('roleAdmin')->with('permission')->paginate($request->input('limit', 10));
            foreach ($roles->items() as &$value) {
                $value->permissions = $value->permission->pluck('id');
                unset($value->permission);
            }
            return static::responseWithPage($roles, '获取角色成功', 200);
        } catch (\Exception $e) {
            return static::response([], '获取角色失败', 500);
        }
    }
}
