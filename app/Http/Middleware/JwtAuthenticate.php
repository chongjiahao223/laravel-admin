<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['无法根据token获取用户'], 404);
            }
        } catch (TokenExpiredException $e) {
            return static::makeException('令牌已失效', 401);
        } catch (TokenInvalidException $e) {
            return static::makeException('令牌无效', 401);
        } catch (JWTException $e) {
            return static::makeException('令牌缺失', 401);
        }

        return $next($request);
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
