<?php

namespace App\Http\Middleware;

use App\Http\Services\Admin\Info;
use Closure;
use Illuminate\Http\Request;

class PermissionMiddleware
{
    /**
     * 权限验证
     *
     * @param $request
     * @param Closure $next
     * @param $permission
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function handle($request, Closure $next, $permission)
    {
        // 验证账号
        $admin = auth('api')->user();
        if (!$admin) static::makeException('获取账户信息错误', 401);

        if ($admin->status == 2) {
            auth('api')->logout();
            static::makeException('账户已停用', 401);
        }

        // 获取该账户全部权限
        $requests = new Request();
        $permissionRes = Info::dryRun($requests)->getData();
        if ($permissionRes->code !== 200) static::makeException('账户权限拉取错误', 401);
        $permissionRes = $permissionRes->data->permission;

        $permissions = is_array($permission)
            ? $permission
            : explode('|', $permission);

        foreach ($permissions as $permission) {
            if (in_array($permission, $permissionRes)) {
                return $next($request);
            }
        }

        return static::makeException('账户没有权限访问', 403);
    }

    /**
     * 统一返回接口
     * @param $message
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    protected static function makeException($message, int $code = 401)
    {
        $response = [
            'message' => $message,
            'data' => [],
            'code' => $code
        ];
        \Log::info("返回数据为：" . json_encode($response, JSON_UNESCAPED_UNICODE));
        return response()->json($response, $code);
    }
}
