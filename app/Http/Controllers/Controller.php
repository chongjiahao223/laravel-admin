<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        $request = request()->all() + ['token' => request()->header('Authorization')];
        \Log::channel('daily')->info("请求数据为：" . json_encode($request, JSON_UNESCAPED_UNICODE));
    }

    /**
     * 统一返回接口
     * @param array $data
     * @param string $message
     * @param int $code
     * @param int $headerCode
     * @return \Illuminate\Http\JsonResponse
     */
    protected static function response($data = [], string $message = 'ok', int $code = 200, int $headerCode = 200)
    {
        $response = [
            'message' => $message,
            'code' => $code,
            'data' => $data
        ];
        \Log::channel('daily')->info("返回数据为：" . json_encode($response, JSON_UNESCAPED_UNICODE));
        return response()->json($response, $headerCode);
    }

    /**
     * 统一返回接口带分页
     * @param LengthAwarePaginator $data
     * @param string $message
     * @param int $code
     * @param int $headerCode
     * @return \Illuminate\Http\JsonResponse
     */
    protected static function responseWithPage(LengthAwarePaginator $data, string $message = 'ok', int $code = 200, int $headerCode = 200)
    {
        $response = [
            'message' => $message,
            'total' => $data->total(),
            'limit' => $data->perPage(),
            'page' => $data->currentPage(),
            'data' => $data->items(),
            'code' => $code
        ];
        \Log::channel('daily')->info("返回数据为：" . json_encode($response, JSON_UNESCAPED_UNICODE));
        return response()->json($response, $headerCode);
    }
}
