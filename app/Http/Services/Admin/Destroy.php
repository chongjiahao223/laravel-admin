<?php
namespace App\Http\Services\Admin;

use App\Http\Services\Base;
use App\Models\Admin;
use App\Models\AdminHasRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Destroy extends Base
{
    public static function dryRun(Request $request)
    {
        if (!$request->has('id')) return static::response([], '用户ID缺失');
        DB::beginTransaction();
        try {
            // 删除用户
            Admin::destroy($request->input('id'));
            // 删除用户角色
            AdminHasRole::where('admin_id', $request->input('id'))->delete();

            DB::commit();
            return static::response([], '删除成功', 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return static::response([], '删除失败', 500);
        }
    }
}
