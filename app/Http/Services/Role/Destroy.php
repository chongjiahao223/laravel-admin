<?php
namespace App\Http\Services\Role;

use App\Http\Services\Base;
use App\Models\AdminHasRole;
use App\Models\Role;
use App\Models\RoleHasPermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class Destroy extends Base
{
    protected static $ruler = [
        'id'  => 'required|integer',
    ];
    protected static $message = [
        'id.required' => '角色ID参数缺失',
        'id.integer' => '角色ID参数类型错误',
    ];
    public static function dryRun(Request $request)
    {
        $verify = static::verify($request);
        if ($verify) return static::response([], $verify, 500);
        DB::beginTransaction();
        try {
            // 删除角色
            Role::destroy($request->input('id'));
            // 删除角色权限中间表
            RoleHasPermission::where('role_id', $request->input('id'))->delete();
            // 删除用户角色中间表
            AdminHasRole::where('role_id', $request->input('id'))->delete();

            DB::commit();
            return static::response([], '删除角色成功', 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return static::response([], '删除角色失败', 500);
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
