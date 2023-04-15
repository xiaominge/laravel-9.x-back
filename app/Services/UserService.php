<?php

namespace App\Services;

use App\Foundation\Service\Service;

class UserService extends Service
{
    /**
     * 用户看过的人, 存入 mongodb
     * @param $userId
     * @param $targetId
     */
    public function userSeenSaveToMongodb($userId, $targetId)
    {
        $randMessage = [
            '(｡･∀･)ﾉﾞ嗨',
            '你好呀~',
        ];
        $createData = [
            'user_id' => (int)$userId,
            'target_id' => (int)$targetId,
            'msg' => array_random($randMessage),
            'created_at' => time(),
        ];
        if (mongodb('user_seen')->insert($createData)) {
            return result_return()->success([$userId => $targetId]);
        }

        return result_return()->failure();
    }
}
