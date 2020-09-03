<?php
namespace App\Http\Services\Role;

use App\Http\Services\Base;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class Store extends Base
{
    protected static $ruler = [
        'name'  => '',
    ];
    protected static $message = [
        'name.required' => '请输入角色名称',
        'name.unique' => '角色名称重复',
        'name.max' => '角色名称超多最大长度(200)',
    ];
    public static function dryRun(Request $request)
    {
        $verify = static::verify($request);
        if ($verify) return static::response([], $verify, 500);
        try {
            Role::create([
                'name' => $request->input('name', ''),
            ]);
            return static::response([], '添加成功', 200);
        } catch (\Exception $e) {
            return static::response([], '添加失败', 500);
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
            'max:200',
            Rule::unique('roles')->where(function ($query) {
                return $query->whereNull('deleted_at');
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
