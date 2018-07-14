<?php
/**
 * 消息通知控制器
 * User: hzg
 * Date: 2018-07-14
 * Time: 08:19
 */

namespace App\Http\Controllers\Api\Message;

use App\Models\User;
use App\Notifications\SystemMessage;
use Illuminate\Http\Request;

class MessageController
{
    public function test(Request $request) {
        for ($i=0;$i<5;$i++) {
            $r = mt_rand(10,99);
            $msg = [
                "type" => "交易",
                "title" => "卖出 我不是药神 ×1",
                "content" => "您的视频 【我不是药神】 于".date("Y-m-d H:i:s")."成功售出，".$r."元已入账。",
            ];
            User::find($request->uid)->notify(new SystemMessage($msg));
        }
    }

    public function pull(Request $request) {
        $perPage = 10;

        if (is_null($request->uid)) {
            $code = 1000;
            $info = "Token does not exist";
        } else {
            $notifiyObj = User::find($request->uid)->notifications()->paginate($perPage);
            $data = [];
            if ($notifiyObj->isNotEmpty()) {
                $notifiy = $notifiyObj->toArray();
                $list = $notifiy["data"];
                for ($i=0;$i<count($list);$i++) {
                    $data[$i]["id"] = $list[$i]["id"];
                    $data[$i]["type"] = $list[$i]["data"]["type"];
                    $data[$i]["title"] = $list[$i]["data"]["title"];
                    $data[$i]["content"] = $list[$i]["data"]["content"];
                    $data[$i]["date"] = $list[$i]["created_at"];
                }
            }
        }

        return response()->json(compact('code', 'info', 'data'));
    }
}