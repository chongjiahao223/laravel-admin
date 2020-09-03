<?php
namespace App\Http\Services\Admin;

use App\Http\Services\Base;
use App\Models\Admin;
use App\Models\AdminHasRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminRole extends Base
{
    protected static $ruler = [
        'id'  => 'required|integer',
        'role' => 'required|array'
    ];
    protected static $message = [
        'id.required' => '用户ID缺失',
        'id.integer' => '用户ID参数类型错误',
        'role.required' => '请选择角色',
        'role.array' => '角色参数类型错误'
    ];
    public static function dryRun(Request $request)
    {
        // 验证
        $verify = static::verify($request);
        if ($verify) return static::response([], $verify, 500);
        $admin = Admin::select('id')->find($request->input('id', 0));
        if (!$admin) return static::response([], '用户不存在', 500);
        // 分配角色
        try {
            // 获取原有角色
            $adminHasRole = AdminHasRole::select('role_id')->where('admin_id', $request->input('id'))->get()->pluck('role_id');
            $create = collect($request->input('role'))->diff($adminHasRole);
            if ($adminHasRole->isNotEmpty()) {
                AdminHasRole::where('admin_id', $request->input('id'))->whereNotIn('role_id', $request->input('role'))->delete();
            }
            if ($create->isNotEmpty()) {
                $data = [];
                $create->each(function ($item, $index) use ($request, &$data) {
                    $data[] = [
                        'admin_id' => $request->input('id'),
                        'role_id' => $item
                    ];
                });
                AdminHasRole::insert($data);
            }
            return static::response([], '分配角色成功', 200);
        } catch (\Exception $e) {
            return static::response([], '分配角色失败', 500);
        }
    }

    /**
     * 验证
     * @param Request $request
     * @return mixed|void
     */
    private static function verify(Request $request)
    {
        $validator = Validator::make($request->all(), static::$ruler, static::$message);
        if ($validator->fails()) {
            $errors = $validator->errors()->getMessages();
            foreach($errors as $key=>$value)
            {
                return $value[0];
            }
        }
        return ;
    }
}
