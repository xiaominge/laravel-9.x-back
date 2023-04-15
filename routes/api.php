<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Carbon\Carbon;

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
    ->get('/test/{part?}', function ($part = 'request') {

        $userId = 31;
        $targetId = 21;
        $return = [];
        $return['sprintf'] = sprintf("%.3f", 0.12);
        if ($part == 'weather') {
            try {
                $response = guzzle_client()->request('get', 'https://api.jisuapi.com/weather/query');
                if ($response->getStatusCode() !== 200) {
                    $return['guzzleResponseMsg'] = '响应状态码不是 200';
                } else {
                    $responseContents = $response->getBody()->getContents();
                    $return['responseContents'] = json_decode($responseContents, true);
                }
            } catch (\GuzzleHttp\Exception\GuzzleException $e) {
                $return['guzzleResponseMsg'] = $e->getMessage();
            }
        } else if ($part == 'request') {
            $requestQuery = request_query();
            $requestHeader = request_header();
            $requestJson = request_json_payload();
            $return['requestQuery'] = $requestQuery;
            $return['requestHeader'] = $requestHeader;
            $return['requestJson'] = $requestJson;
            $return['os'] = user_agent()->os;
        } else if ($part == 'storage') {
            $userPhotoName = 'user_' . $userId . '_photo.jpg';
            $userPhotoPath = 'user/photo';
            $userPhotoPathName = $userPhotoPath . '/' . $userPhotoName;
            storage_disk()->makeDirectory($userPhotoPath);
            $userPhotoPut = storage_disk()->put($userPhotoPathName, file_get_contents("http://oss.cyzone.cn/2023/0206/ace23328329fddf23c934634b0f28d3d.jpg"));
            $userPhotoUrl = storage_disk()->url($userPhotoPathName);
            $userPhotoSize = storage_disk()->size($userPhotoPathName);
            $userPhotoSetTime = storage_disk()->lastModified($userPhotoPathName);
            $return['user_photo_put'] = $userPhotoPut;
            $return['user_photo_url'] = $userPhotoUrl;
            $return['user_photo_size'] = $userPhotoSize;
            $return['user_photo_set_time'] = Carbon::createFromTimestamp($userPhotoSetTime)->toDateTimeString();
            $return['storage_files'] = storage_disk()->files();
            $return['storage_all_files'] = storage_disk()->allFiles();
            $return['storage_dirs'] = storage_disk()->directories();
            $return['storage_all_dirs'] = storage_disk()->allDirectories();
            storage_disk()->delete($userPhotoPathName);
        } else if ($part == 'mongodb') {
            $insertRet = service()->user->userSeenSaveToMongodb($userId, $targetId);
            if ($insertRet->status === true) {
                $latestInfo = mongodb('user_seen')
                    ->where('target_id', $targetId)
                    ->orderBy('created_at', 'desc')
                    ->first();

                $return['latestInfo'] = $latestInfo;
            } else {
                $return['latestInfoMsg'] = "userSeenSaveToMongodb 失败";
                $return['latestInfoStatus'] = $insertRet->status;
            }
        } else if ($part == "time") {
            $arr = [
                1 => 'substr_start',
                1000000 => 'substr_end',
                1000001 => 'sprintf_start',
                2000000 => 'sprintf_end',
                2000001 => 'bc_start',
                3000000 => 'bc_end',
            ];
            for ($i = 1; $i <= 3000000; $i++) {
                if ($i <= 1000000) {
                    $t = get_millisecond("substr");
                } else if ($i <= 2000000) {
                    $t = get_millisecond("sprintf");
                } else {
                    $t = get_millisecond("bc");
                }
                if (isset($arr[$i])) {
                    $return['time'][$i] = $i;
                    $return['time'][$arr[$i]] = $t;
                }
            }
            $return['time']['substr'] = $return['time']['substr_end'] - $return['time']['substr_start'];
            $return['time']['sprintf'] = $return['time']['sprintf_end'] - $return['time']['sprintf_start'];
            $return['time']['bc'] = $return['time']['bc_end'] - $return['time']['bc_start'];
        }

        return business_handler_user()->success($return);
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
