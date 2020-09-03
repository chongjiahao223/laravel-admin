<?php
namespace App\Http\Services\Role;

use App\Http\Services\Base;
use App\Models\Role;
use App\Models\RoleHasPermission;
use Illuminate\Http\Request;

class RolePermission extends Base
{
    public static function dryRun(Request $request)
    {
        // 验证

        // 添加
        $role = Role::select('id')->find($request->input('id', 0));
        if (!$role) return static::response([], '数据源不存在', 500);

        try {
            // 获取原有权限
            $roleHasPermission = RoleHasPermission::select('permission_id')->where('role_id', $role->id)->get()->pluck('permission_id');
            $diff = $roleHasPermission->diff($request->input('permission'));
            $create = collect($request->input('permission'))->diff($roleHasPermission);
            // 删除数据
            if ($diff->isNotEmpty()) {
                try {
                    RoleHasPermission::where('role_id', $request->input('id'))->whereIn('permission_id', $diff->toArray())->delete();
                } catch (\Exception $e) {
                    return static::response([], '删除权限失败', 500);
                }
            }
            // 添加数据
            if ($create->isNotEmpty()) {
                $data = [];
                $create->each(function ($item, $index) use ($request, &$data) {
                    $data[] = [
                        'permission_id' => $item,
                        'role_id' => $request->input('id')
                    ];
                });
                try {
                    RoleHasPermission::insert($data);
                } catch (\Exception $e) {
                    return static::response([], '添加权限失败', 500);
                }
            }
            return static::response([], '分配权限成功', 200);
        } catch (\Exception $e) {
            return static::response([], '分配权限失败', 500);
        }
    }
}
