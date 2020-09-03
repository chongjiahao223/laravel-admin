<?php

namespace App\Http\Controllers\Admin\Role;

use App\Http\Controllers\Controller;
use App\Http\Services\Role\Destroy;
use App\Http\Services\Role\Index;
use App\Http\Services\Role\RoleAll;
use App\Http\Services\Role\RolePermission;
use App\Http\Services\Role\Store;
use App\Http\Services\Role\Update;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * 角色列表数据
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        //
        return Index::dryRun($request);
    }

    /**
     * 新增角色
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        //
        return Store::dryRun($request);
    }

    /**
     * 编辑角色
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        //
        return Update::dryRun($request);
    }

    /**
     * 分配权限
     * @param Request $request
     * @return mixed
     */
    public function rolePermission(Request $request)
    {
        return RolePermission::dryRun($request);
    }

    /**
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request)
    {
        return Destroy::dryRun($request);
    }

    /**
     * 获取全部角色（不带分页）
     * @param Request $request
     * @return mixed
     */
    public function RoleAll(Request $request)
    {
        return RoleAll::dryRun($request);
    }
}
