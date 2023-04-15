<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;

class AdminPermissionVerify
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $routeName = Route::currentRouteName();
        if (in_array($routeName, $this->publicRoutes())) {
            return $next($request);
        }
        $permissions = service()->permission->getLoginAdminPermission();
        $userPermissions = $permissions->pluck('route')->toArray();
        if (in_array($routeName, $userPermissions)) {
            return $next($request);
        } else {
            Log::channel('stack')->info('NO-AUTH: ' . $routeName);
            return $this->returnErrorMsg('您没有相关权限执行该操作');
        }
    }

    /**
     * 返回带有错误信息的响应
     * @param $message
     * @return \Illuminate\Http\RedirectResponse|mixed
     */
    private function returnErrorMsg($message)
    {
        if (request()->ajax() || request()->wantsJson()) {
            return business_handler_user()->fail($message);
        } else {
            return back()->withErrors($message);
        }
    }

    /**
     * 公开路由
     * @return array
     */
    private function publicRoutes()
    {
        return [];
    }
}
