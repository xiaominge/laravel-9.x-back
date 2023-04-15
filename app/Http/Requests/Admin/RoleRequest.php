<?php

namespace App\Http\Requests\Admin;

use App\Foundation\Util\Request\BaseRequest as BaseRequest;

class RoleRequest extends BaseRequest
{

    protected array $rules = [
        'admin.roles.store' => [
            'name' => 'required|min:2|max:45',
            'key' => 'required|max:16',
            'description' => 'required|max:255',
            'permissions' => 'required',
        ],
        'admin.roles.update' => [
            'name' => 'required|min:2|max:45',
            'description' => 'required|max:255',
            'permissions' => 'required',
        ],
    ];

    protected array $messages = [
        'admin.roles.store' => [
            'name.required' => '请输入角色名称',
            'name.min' => '角色名称最小 2 个字符',
            'name.max' => '角色名称最大 45 个字符',
            'key.required' => '请输入角色标识',
            'key.max' => '角色标识最大 16 个字符',
            'description.required' => '请输入角色描述',
            'description.max' => '角色描述最大 255 个字符',
            'permissions.required' => '请选择角色拥有的权限',
        ],
        'admin.roles.update' => [
            'name.required' => '请输入角色名称',
            'name.min' => '角色名称最小 2 个字符',
            'name.max' => '角色名称最大 45 个字符',
            'description.required' => '请输入角色描述',
            'description.max' => '角色描述最大 255 个字符',
            'permissions.required' => '请选择角色拥有的权限',
        ],
    ];
}
