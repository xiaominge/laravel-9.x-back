<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/**
 * 测试路由
 */
Route::middleware(['common'])
    ->get('/test', function () {

        $response = guzzle_client()->request('get', 'https://api.jisuapi.com/weather/query');
        $responseContents = $response->getBody()->getContents();
        return business_handler()->ok(json_decode($responseContents, true));

        $requestJson = request_json_payload();

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

Route::middleware(['common'])
    ->namespace('App\Http\Controllers\Api')
    ->name('api.')
    ->group(function () {
        // 用户角色
        Route::controller('RoleController')
            ->name('roles.')
            ->group(function () {
                Route::post('admin/roles', 'store')->name('store');
            });
    });
