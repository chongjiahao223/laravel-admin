<?php

namespace App\Http\Controllers\Admin\Permission;

use App\Http\Controllers\Controller;
use App\Http\Services\Permission\Destroy;
use App\Http\Services\Permission\Index;
use App\Http\Services\Permission\Store;
use App\Http\Services\Permission\Tree;
use App\Http\Services\Permission\Update;
use Illuminate\Http\Request;

class PermissionController extends Controller
{

    /**
     * 权限列表
     * @param Request $request
     * @return array
     */
    public function index(Request $request)
    {
        //
        return Index::dryRun($request);
    }

    /**
     * 获取权限树
     * @param Request $request
     * @return int
     */
    public function tree(Request $request)
    {
        return Tree::dryRun($request);
    }

    /**
     * 添加角色
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        return Update::dryRun($request);
    }

    /**
     * 权限删除
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, $id)
    {
        //
        $request->offsetSet('id', $id);
        return Destroy::dryRun($request);
    }
}
