<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\BusinessException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PermissionRequest as PermissionRequest;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        $permissions = repository()->permission->allFormatPermissions();
        $permissions = collect($permissions)->map(function ($item) {
            return (object)$item;
        });
        return response_view('admin.permissions.index', [
            'permissions' => $permissions,
        ]);
    }

    public function create($pid = null)
    {
        $permissions = repository()->permission->allFormatPermissions();
        $permissions = collect($permissions)->map(function ($item) {
            return (object)$item;
        });
        return response_view('admin.permissions.create', compact('permissions', 'pid'));
    }

    public function store(PermissionRequest $request)
    {
        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'icon' => $request->icon ?? '',
            'pid' => $request->pid,
            'sort' => $request->sort ?? '0',
            'route' => $request->route ?? '',
            'created_at' => time(),
            'updated_at' => time(),
        ];
        repository()->permission->m()->create($data);
        return business_handler_user()->success('', '权限创建成功');
    }

    public function edit(Request $request, $id)
    {
        try {
            $permission = repository()->permission->findById($id);
            $permissions = repository()->permission->allFormatPermissions();
            $permissions = collect($permissions)->map(function ($item) {
                return (object)$item;
            });
            return response_view('admin.permissions.edit', [
                'permission' => $permission,
                'permissions' => $permissions,
            ]);
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.error')
                ->withErrors([
                    'msg' => $e->getMessage(),
                ]);
        }
    }

    public function update(PermissionRequest $request, $id)
    {
        try {
            $permission = repository()->permission->findById($id);

            $data = [
                'name' => $request->name,
                'description' => $request->description,
                'icon' => $request->icon ?? '',
                'pid' => $request->pid,
                'route' => $request->route ?? '',
                'sort' => $request->sort ?? '0',
                'updated_at' => time(),
            ];
            $permission->update($data);

            return business_handler_user()->success('', '权限更新成功');
        } catch (\Exception $e) {
            return business_handler_user()->fail($e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            // 检测此权限有没有在被使用
            $permission = repository()->permission->findById($id);
            $roleIds = $permission->roles->pluck('id')->toArray();
            if ($roleIds) {
                return business_handler_user()->fail('权限正在被使用，无法删除');
            }

            $allPermission = repository()->permission->all();
            $permissions = repository()->permission->getPermissionsList([$permission->id], $allPermission);
            repository()->permission->m()
                ->whereIn('id', $permissions)
                ->update(['deleted_at' => time()]);

            return business_handler_user()->success('', '权限删除成功');
        } catch (BusinessException $e) {
            return business_handler_user()->fail('权限删除失败');
        }
    }

}
