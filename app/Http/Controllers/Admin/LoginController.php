<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * 登录成功后跳转到的链接
     *
     * @var string
     */
    protected $redirectTo = '/admin';

    /**
     * 登录表单页面
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    /**
     * 登录用户字段名
     *
     * @return string
     */
    public function username()
    {
        return 'name';
    }

    /**
     * 登录所用的看守器
     *
     * @return mixed
     */
    protected function guard()
    {
        return Auth::guard('admin');
    }

    /**
     * 认证成功返回的响应
     * @param Request $request
     * @param $user
     * @return \Illuminate\Http\JsonResponse
     */
    protected function authenticated(Request $request, $user)
    {
        return business_handler_user()->success(null, '登录成功，请稍等...');
    }

    /**
     * 返回用户登出的响应
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function loggedOut(Request $request)
    {
        return redirect()->route('admin.login.form');
    }
}
