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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use PDOException;

class MessageController
{
    public function test(Request $request)
    {
        if (is_null($request->uid)) {
            $code = 1000;
            $info = "Token does not exit";
        } else {
            $code = 200;
            $info = "insert message success";
            for ($i = 0; $i < 5; $i++) {
                $r = mt_rand(10, 99);
                $msg = [
                    "type" => "交易",
                    "title" => "卖出 我不是药神 ×1",
                    "content" => "您的视频 【我不是药神】 于" . date("Y-m-d H:i:s") . "成功售出，" . $r . "元已入账。",
                ];
                $userObj = User::where(["uid" => $request->uid])->first();
                $userObj->notify(new SystemMessage($msg));
            }
        }

        return response()->json(compact('code', 'info'));
    }

    public function pull(Request $request)
    {
        $perPage = 10;
        if (is_null($request->uid)) {
            $code = 1000;
            $info = "Token does not exist";
        } else {
            $userObj = User::where(["uid" => $request->uid])->first();
            if (is_null($userObj)) {
                $code = 1001;
                $info = "用户信息丢失";
            } else {
                $notifiyObj = $userObj->notifications()->paginate($perPage);
                $data = [];
                if ($notifiyObj->isNotEmpty()) {
                    $userObj->unreadNotifications->MarkAsRead();
                    $notifiy = $notifiyObj->toArray();
                    $list = $notifiy["data"];
                    for ($i = 0; $i < count($list); $i++) {
                        $data[$i]["id"] = $list[$i]["id"];
                        $data[$i]["type"] = $list[$i]["data"]["type"];
                        $data[$i]["title"] = $list[$i]["data"]["title"];
                        $data[$i]["content"] = $list[$i]["data"]["content"];
                        $data[$i]["date"] = $list[$i]["created_at"];
                    }
                } else {
                    $code = "1002";
                    $info = "暂无交易消息";
                }
            }
        }

        return response()->json(compact('code', 'info', 'data'));
    }

    public function delById(Request $request)
    {
        if (is_null($request->uid)) {
            $code = 1000;
            $info = "Token does not exit";
        } else {
            $code = 200;
            $info = "delete success!";
            $userObj = user::where(['uid' => $request->uid])->first();
            print_r($request->all());
            $data = $request->all();
            for ($i = 0; $i < count($data); $i++) {
                $userObj->notifications()->where(['id' => $data[$i]])->delete();
            }
        }

        return response()->json(compact('code', 'info', 'data'));
    }

    public function delete(Request $request)
    {
        if (is_null($request->uid)) {
            $code = 1000;
            $info = "Token does not exit";
        } else {
            $validator = Validator::make($request->all(), [
                'ids' => 'required'
            ], [
                'ids.required' => '消息ID不能为空',
            ]);

            if ($validator->fails()) {
                $valimsg = $validator->messages();
                if ($valimsg->has('ids')) {
                    $code = 1001;
                    $info = $valimsg->first('ids');
                } else {
                    $code = 1000;
                    $info = "未知错误";
                }
            } else {
                $ids = $request->input('ids');
                $idArr = explode(",", $ids);
                if (count($idArr) > 0) {
                    try {
                        DB::beginTransaction();
                        $userObj = user::where(['uid' => $request->uid])->first();
                        if (is_null($userObj)) {
                            $code = 1003;
                            $info = "用户信息丢失";
                        } else {
                            $n = 0;
                            for ($i = 0; $i < count($idArr); $i++) {
                                $affected = $userObj->notifications()->where(['id' => $idArr[$i]])->delete();
                                $n += $affected;
                            }
                            if ($n == count($idArr)) {
                                DB::commit();
                                $code = 200;
                                $info = '删除成功';
                            } else {
                                DB::rollback();
                                $code = 1005;
                                $info = '删除失败-2';
                            }
                        }
                    } catch (PDOException $e) {
                        DB::rollback();
                        $code = 1004;
                        $info = '删除失败-1';
                    }
                } else {
                    $code = 1002;
                    $info = "消息ID不存在";
                }
            }
        }

        return response()->json(compact('code', 'info', 'data'));
    }
}