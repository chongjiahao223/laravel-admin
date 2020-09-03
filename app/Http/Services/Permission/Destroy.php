<?php
namespace App\Http\Services\Permission;

use App\Http\Services\Base;
use App\Models\Permission;
use Illuminate\Http\Request;

class Destroy extends Base
{
    public static function dryRun(Request $request)
    {
        if (!$request->has('id')) return static::response([], '请求参数缺失', 400);

        // 查询权限
        $permission = Permission::with('child')->find($request->input('id'));
        if (!$permission) return static::response([], '权限不存在', 404);

        // 判断是否有子权限
        if ($permission->child->isNotEmpty()) return static::response([], '存在子权限，禁止删除', 403);

        try {
            $permission->delete();
            return static::response([], '删除成功');
        } catch (\Exception $e) {
            return static::response([], '删除失败，请重试', 500);
        }
    }
}
