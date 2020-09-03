<?php

namespace App\Http\Controllers\Admin\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\Admin\AdminRole;
use App\Http\Services\Admin\Destroy;
use App\Http\Services\Admin\Index;
use App\Http\Services\Admin\Info;
use App\Http\Services\Admin\Store;
use App\Http\Services\Admin\Update;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    /**
     * 用户列表数据
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        //
        return Index::dryRun($request);
    }

    /**
     * 创建一个管理员
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return Store::dryRun($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        return 'show';
    }

    /**
     * 编辑用户
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        //
        return Update::dryRun($request);
    }

    /**
     * 删除用户
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request)
    {
        //
        return Destroy::dryRun($request);
    }

    /**
     * 分配角色
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function adminRole(Request $request)
    {
        return AdminRole::dryRun($request);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function info(Request $request)
    {
        return Info::dryRun($request);
    }
}
