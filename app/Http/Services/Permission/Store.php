<?php
namespace App\Http\Services\Permission;

use App\Http\Services\Base;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class Store extends Base
{
    protected static $ruler = [
        'parentId' => 'required|numeric',
        'name'  => '',
        'display_name'  => 'required',
        'type' => 'required|in:1,2',
        'sort' => 'required|numeric',
    ];
    protected static $message = [
        'parentId.required' => '请选择父级权限',
        'parentId.numeric' => '父级权限参数类型错误',
        'name.required' => '请输入权限名称',
        'name.unique' => '权限名称重复',
        'name.max' => '权限名称超多最大长度(200)',
        'display_name.required' => '请输入显示名称',
        'type.required' => '请选择权限类型',
        'type.in' => '权限类型参数错误',
        'sort.required' => '请输入排序数字',
        'sort.numeric' => '排序参数错误',
    ];
    public static function dryRun(Request $request)
    {
        $verify = static::verify($request);
        if ($verify) return static::response([], $verify, 500);

        try {
            Permission::create([
                'name' => $request->input('name'),
                'display_name' => $request->input('display_name'),
                'parent_id' => $request->input('parentId', 0),
                'sort' => $request->input('sort', 0),
                'type' => $request->input('type', 2),
                'admin_id' => auth('api')->id()
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
            Rule::unique('permissions')->where(function ($query) {
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
