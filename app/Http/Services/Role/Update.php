<?php
namespace App\Http\Services\Role;

use App\Http\Services\Base;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class Update extends Base
{
    protected static $ruler = [
        'id'  => 'required|integer',
        'name'  => '',
    ];
    protected static $message = [
        'id.required' => '角色ID参数缺失',
        'id.integer' => '角色ID参数类型错误',
        'name.required' => '请输入角色名称',
        'name.unique' => '角色名称重复',
        'name.max' => '角色名称超多最大长度(200)',
    ];
    public static function dryRun(Request $request)
    {
        $verify = static::verify($request);
        if ($verify) return static::response([], $verify, 500);
        $role = Role::select('id', 'status')->find($request->input('id', 0));
        if (!$role) return static::response([], '数据源不存在', 500);

        try {
            $role->name = $request->input('name');
            $role->save();
            return static::response([], '编辑成功', 200);
        } catch (\Exception $e) {
            return static::response([], '编辑失败', 500);
        }
    }

    /**
     * 验证
     * @param Request $request
     * @return mixed|void
     */
    private static function verify(Request $request)
    {
        static::$ruler['name'] = [
            'required',
            'max:20',
            Rule::unique('roles')->where(function ($query) use ($request) {
                return $query->where('id', '<>', $request->input('id'))->whereNull('deleted_at');
            })
        ];
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
