<?php

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;
use Carbon\Carbon;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/**
 * 测试路由
 */
Route::middleware(['common'])
    ->get('/test/{part?}', function ($part = '') {

        $userId = 31;
        $targetId = 21;
        $return = [];

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
        } else if ($part == 'cache') {
            $adminsRedisKey = config('redis_store.test.admins.key');
            $adminsRedisTtl = config('redis_store.test.admins.ttl');
            $rolesRedisKey = config('redis_store.test.roles.key');
            $rolesRedisTtl = config('redis_store.test.roles.ttl');
            $uidRedisKey = config('redis_store.counter.user_uid');

            $admins = cache_store()->remember($adminsRedisKey, $adminsRedisTtl, function () {
                return repository()->admin->m()->get()->toArray();
            });
            $roles = repository()->role->m()->get()->toArray();
            $rolesPutRet = cache_store()
                ->tags(['role', 'info'])
                ->put($rolesRedisKey, $roles, $rolesRedisTtl);
            $rolesRet = $rolesPutRet ? cache_store()
                ->tags('role', 'info')
                ->get($rolesRedisKey) : '';
            $uid = redis()->incr($uidRedisKey);

            // $permission = repository()->permission->m()->findOrFail(99);

            $return['cache'][$adminsRedisKey] = $admins;
            $return['cache'][$rolesRedisKey] = $rolesRet;
            $return['cache'][$uidRedisKey] = $uid;
        } else {
            // 定义二维数组
            $arr = [[1], [2, 'sum' => [3]]];
            // 框架方法
            $arr1 = Arr::collapse($arr);
            $arr2 = array_collapse($arr);
            // 内置函数
            $arr3 = array_reduce($arr, "array_merge", []);
            // 语法
            $arr4 = array_merge([], ...$arr);
            // 遍历
            $arr5 = [];
            foreach ($arr as $val) {
                $arr5 = array_merge($arr5, $val);
            }
            $return['collapse']['arr1'] = $arr1;
            $return['collapse']['arr2'] = $arr2;
            $return['collapse']['arr3'] = $arr3;
            $return['collapse']['arr4'] = $arr4;
            $return['collapse']['arr5'] = $arr5;

            $return['sprintf'] = sprintf("%.3f", 0.12);

            $array1 = array(0 => 'zero_a', 2 => 'two_a', 3 => 'three_a', 'h' => 'ddd');
            $array2 = array(1 => 'one_b', 3 => 'three_b', 4 => 'four_b', 'h' => 'eee');
            $result1 = $array1 + $array2;
            $result2 = array_merge($array1, $array2);
            $return['merge1'] = $result1;
            $return['merge2'] = $result2;
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
