<?php
namespace App\Http\Services\Admin;

use App\Http\Services\Base;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class Update extends Base
{
    protected static $ruler = [
        'id'  => 'required|integer',
        'name'  => '',
        'phone'   => '',
        'password'  => 'required|min:6|max:14',
        'password_confirmation'  => 'required|same:password'
    ];
    protected static $message = [
        'id.required' => '用户ID缺失',
        'id.integer' => '用户ID参数类型错误',
        'name.required' => '请输入用户名',
        'name.max' => '用户名最长14位',
        'name.unique' => '用户名重复',
        'phone.required' => '请输入手机号',
        'phone.numeric' => '手机号输入类型错误',
        'phone.regex' => '手机号输入格式错误',
        'phone.unique' => '手机号重复',
        'password.required' => '请输入密码',
        'password.min' => '请输入6~14位密码',
        'password.max' => '请输入6~14位密码',
        'password_confirmation.required' => '请输入确认密码',
        'password_confirmation.same' => '两次密码不一致',
    ];
    public static function dryRun(Request $request)
    {
        $verify = static::verify($request);
        if ($verify) return static::response([], $verify, 500);
        $admin = Admin::select('id')->find($request->input('id'));
        if (!$admin) return static::response([], '数据源不存在');

        try {
            $admin->name = $request->input('name');
            $admin->phone = $request->input('phone');
            $admin->password = $request->input('password');
            $admin->save();
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
            'max:14',
            Rule::unique('admins')->where(function ($query) use ($request) {
                return $query->where('id', '<>', $request->input('id'))->whereNull('deleted_at');
            })
        ];
        static::$ruler['phone'] = [
            'required',
            'numeric',
            'regex:/^1[3456789][0-9]{9}$/',
            Rule::unique('admins')->where(function ($query) use ($request) {
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
