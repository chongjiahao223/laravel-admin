<?php
namespace App\Http\Services\Admin;

use App\Http\Services\Base;
use App\Models\Admin;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class Index extends Base
{
    public static function dryRun(Request $request)
    {
        try {
            $admins = Admin::with('role')
                ->when($request->input('name'), function (Builder $query) use ($request) {
                    return $query->where('name', 'like', "%{$request->input('name')}%");
                })
                ->when($request->input('phone'), function (Builder $query) use ($request) {
                    return $query->where('phone', 'like', "%{$request->input('phone')}%");
                })
                ->when($request->input('status'), function (Builder $query) use ($request) {
                    return $query->where('status', $request->input('status'));
                })
                ->paginate($request->input('limit', 10));

            foreach ($admins->items() as &$value) {
                $value->roles = $value->role->pluck('id');
                unset($value->role);
            }

            return static::responseWithPage($admins, '获取成功', 200);
        } catch (\Exception $e) {
            return static::response([], '获取失败', 500);
        }
    }
}
