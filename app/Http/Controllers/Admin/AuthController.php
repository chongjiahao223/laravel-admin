<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //
    /**
     * 登录验证字段
     * @var array
     */
    private static $rules = [
        'phone' => ['required', 'regex: /^1[3456789]\d{9}$/'],
        'password' => 'required',
    ];

    /**
     * 登录验证字段对应信息
     * @var string[]
     */
    private static $messages = [
        'phone.required' => '请输入登录账号',
        'phone.regex' => '登录账号格式错误',
        'password.required' => '请输入登录密码',
    ];

    /**
     * 登录授权
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $verify = $this->verify($request);
        if ($verify) {
            return static::response([], $verify, 401);
        }
        $credentials = request(['phone', 'password']);

        $token = '';
        // 记住密码设定token有效期
        if ($request->input('remember')) {
            $token = auth('api')->setTTL(1440)->attempt($credentials);
        } else {
            $token = auth('api')->attempt($credentials);
        }

        if (!$token) {
            return static::response([], '授权失败', 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * 验证登录信息
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    private function verify(Request $request)
    {
        $validator = Validator::make($request->all(), static::$rules, static::$messages);
        if ($validator->fails()) {
            $errors = $validator->errors()->getMessages();
            foreach($errors as $key=>$value)
            {
                return $value[0];
            }
        }
        return ;
    }

    /**
     * 获取经过身份验证的用户
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return static::response(auth('api')->user(), '获取授权用户成功', 200);
    }

    /**
     * 登出
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth('api')->logout();

        return static::response([], '退出成功', 200);
    }

    /**
     * 刷新token
     * 刷新token，如果开启黑名单，以前的token便会失效。
     * 值得注意的是用上面的getToken再获取一次Token并不算做刷新，两次获得的Token是并行的，即两个都可用。
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    /**
     * 获取token结构
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return static::response([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ], '授权成功', 200);
    }
}
