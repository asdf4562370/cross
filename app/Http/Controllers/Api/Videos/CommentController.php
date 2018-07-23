<?php
/**
 * 评论控制器
 * Created by TRush.
 * Date: 2018-07-21
 * Time: 07:23
 */

namespace App\Http\Controllers\Api\Videos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\VideoComment;

class CommentController extends Controller
{
    public function comment(Request $request)
    {
        if (is_null($request->uid)) {
            $code = 1000;
            $info = "token does not exit";
        } else {
            $validator = Validator::make($request->all(), [
                'contents' => ['required', 'max:200'],
                'pid' => 'required',
                'nickname' => 'required'
            ], [
                'contents.required' => '评论不能为空',
                'pid.required' => '视频pid不能为空',
                'contents.max' => '评论长度不能超过200字',
                'nickname.required' => '昵称不能为空',
            ]);

            if ($validator->fails()) {
                $valimsg = $validator->messages();
                if ($valimsg->has('contents')) {
                    $code = 1002;
                    $info = $valimsg->first('contents');
                } else if ($valimsg->has('pid')) {
                    $code = 1003;
                    $info = $valimsg->first('pid');
                } else if ($valimsg->has('nickname')) {
                    $code = 1003;
                    $info = $valimsg->first('nickname');
                } else {
                    $code = 1003;
                    $info = "未知错误";
                }
            } else {
                $videoComObj = videoComment::create([
                    'pid' => $request->pid,
                    'parent_id' => 0,
                    'content' => $request->contents,
                    'created_by' => $request->uid,
                    'nickname' =>$request->nickname,
                ]);
                if ($videoComObj) {
                    $code = 200;
                    $info = "评论成功";
                } else {
                    $code = 1004;
                    $info = "数据连接失败";
                }
            }
        }

        return response()->json(compact('code', 'info', 'data'));
    }

    public function reply(Request $request)
    {

    }

}