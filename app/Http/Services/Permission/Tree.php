<?php
namespace App\Http\Services\Permission;

use App\Http\Services\Base;
use App\Models\Permission;
use Illuminate\Http\Request;

class Tree extends Base
{
    public static function dryRun(Request $request)
    {
        try {
            $permissions = Permission::with('allChild')
                ->where('parent_id', 0)
                ->get();
            $data[] = [
                'id' => 0,
                'name' => 'top',
                'display_name' => '顶级权限',
                'all_child' => $permissions
            ];
            return static::response($data, '获取成功', 200);
        } catch (\Exception $e) {
            return static::response([], '获取失败', 500);
        }

    }
}
