<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

/**
 * 测试路由
 */
Route::middleware(['common'])
    ->get('/test', function () {

        $userId = 31;
        $targetId = 21;

        $insertRet = service()->user->userSeenSaveToMongodb($userId, $targetId);
        if ($insertRet->status === true) {
            $latestInfo = mongodb('user_seen')
                ->where('target_id', $targetId)
                ->orderBy('created_at', 'desc')
                ->first();

            return business_handler()->ok($latestInfo);
        }

        return business_handler()->notFound("未找到记录");
    });

// 后台登录
Route::namespace('App\Http\Controllers\Admin')
    ->controller('LoginController')
    ->name('admin.login.')
    ->group(function () {
        Route::get('admin/login', 'showLoginForm')->name('form');
        Route::post('admin/login', 'login')->name('login');
    });

// 后台系统
Route::middleware(['auth.admin'])
    ->namespace('App\Http\Controllers\Admin')
    ->name('admin.')
    ->group(function () {
        // 登出
        Route::get('admin/logout', 'LoginController@logout')->name('logout');

        // 后台主页面
        Route::controller('HomeController')
            ->name('home.')
            ->group(function () {
                // 后台框架页
                Route::get('admin', 'index')->name('index');
                // 后台欢迎页
                Route::get('admin/welcome', 'welcome')->name('welcome');
                // 修改账号密码
                Route::get('admin/password', 'changePassword')->name('password.change');
                Route::put('admin/password', 'doChangePassword')->name('password.do-change');
            });

        // 错误页面
        Route::get('admin/error', 'ErrorController@index')->name('error');

        // 用户角色
        Route::controller('RoleController')
            ->middleware(['admin.permission.verify'])
            ->name('roles.')
            ->group(function () {
                Route::get('admin/roles', 'index')->name('index');
                Route::get('admin/roles/create', 'create')->name('create');
                Route::post('admin/roles', 'store')->name('store');
                Route::get('admin/roles/{id}/edit', 'edit')->name('edit');
                Route::put('admin/roles/{id}', 'update')->name('update');
                Route::delete('admin/roles/{id}', 'destroy')->name('destroy');
            });

        // 权限管理
        Route::controller('PermissionController')
            ->name('permissions.')
            ->group(function () {
                Route::get('admin/permissions', 'index')->name('index');
                Route::get('admin/permissions/create/{pid?}', 'create')->name('create');
                Route::post('admin/permissions', 'store')->name('store');
                Route::get('admin/permissions/{id}/edit', 'edit')->name('edit');
                Route::put('admin/permissions/{id}', 'update')->name('update');
                Route::delete('admin/permissions/{id}', 'destroy')->name('destroy');
            });

        // 管理员管理
        Route::controller('AdminController')
            ->name('admins.')
            ->group(function () {
                Route::get('admin/admins', 'index')->name('index');
                Route::get('admin/admins/create', 'create')->name('create');
                Route::post('admin/admins', 'store')->name('store');
                Route::get('admin/admins/{id}/edit', 'edit')->name('edit');
                Route::put('admin/admins/{id}', 'update')->name('update');
                Route::delete('admin/admins/{id}', 'destroy')->name('destroy');
            });
    });
