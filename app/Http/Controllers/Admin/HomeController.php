<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminRequest;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth.admin']);
    }

    /**
     * 主页
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $permissions = service()
            ->permission
            ->getLoginAdminPermission()
            ->sortByDesc('sort')
            ->values();
        $topMenus = $permissions->where('pid', 0)->toArray();
        $permissionsGroupByPid = $permissions->groupBy('pid')->toArray();
//        dd($topMenus, $permissionsGroupByPid, $permissions->toArray());
        return view('admin.home.home', compact(
            'topMenus', 'permissionsGroupByPid'
        ));
    }

    /**
     * 欢迎页
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function welcome()
    {
        $statistics = [];
        $server = $_SERVER;
        $statistics['admin'] = repository()->admin->m()->undeleted()->count();
        $statistics['role'] = repository()->role->m()->undeleted()->count();
        return view('admin.home.welcome', compact('server', 'statistics'));
    }

    /**
     * 修改密码
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function changePassword()
    {
        return view('admin.home.password');
    }

    /**
     * 修改密码保存
     * @param AdminRequest $request
     * @return mixed
     */
    public function doChangePassword(AdminRequest $request)
    {
        // 检查旧密码是否正确
        $admin = auth('admin')->user();
        if (!Hash::check($request->old_password, $admin->password)) {
            return business_handler_user()->fail('输入的旧密码不正确');
        }
        if ($request->password != $request->confirm_password) {
            return business_handler_user()->fail('两次输入的密码不一致');
        }

        $admin->password = bcrypt($request->password);
        $db = $admin->save();

        if ($db) {
            return business_handler_user()->success([], '密码修改成功');
        }
        return business_handler_user()->fail('密码修改失败');
    }
}
