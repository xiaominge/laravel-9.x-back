<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

/**
 * 测试路由
 */
Route::middleware(['common', 'auth.admin'])->get('/test', function () {
    $roleModel = repository()->role->m();

    var_dump($roleModel::CREATED_AT);
    echo "<br>";
    var_dump($roleModel->timestamps);
    echo "<br>";

    $permissions = service()->permission->getLoginAdminPermission();
    print_r($permissions->toArray());
    die;
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
Route::middleware(['common', 'auth.admin'])
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

        // 角色管理
        Route::controller('RoleController')
            ->name('roles.')
            ->middleware('admin.permission.verify')
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
            ->middleware('admin.permission.verify')
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
            ->middleware('admin.permission.verify')
            ->group(function () {
                Route::get('admin/admins', 'index')->name('index');
                Route::get('admin/admins/create', 'create')->name('create');
                Route::post('admin/admins', 'store')->name('store');
                Route::get('admin/admins/{id}/edit', 'edit')->name('edit');
                Route::put('admin/admins/{id}', 'update')->name('update');
                Route::delete('admin/admins/{id}', 'destroy')->name('destroy');
            });
    });
