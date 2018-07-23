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
use App\Models\Video;

class CommentController extends Controller
{
    public function comment(Request $request)
    {
        if (is_null($request->uid)) {
            $code = 1000;
            $info = "token does not exit";
        } else {
            $validator = Validator::make($request->all(), [
                'content' => ['required', 'max:200'],
                'pid' => 'required',
                'nickname' => 'required',
            ], [
                'content.required' => '评论不能为空',
                'pid.required' => '视频pid不能为空',
                'content.max' => '评论长度不能超过200字',
                'nickname.required' => '昵称不能为空',
            ]);

            if ($validator->fails()) {
                $valimsg = $validator->messages();
                if ($valimsg->has('content')) {
                    $code = 1002;
                    $info = $valimsg->first('content');
                } else if ($valimsg->has('pid')) {
                    $code = 1003;
                    $info = $valimsg->first('pid');
                } else if ($valimsg->has('nickname')) {
                    $code = 1004;
                    $info = $valimsg->first('nickname');
                } else {
                    $code = 1005;
                    $info = "未知错误";
                }
            } else {
                $content = $request->input('content');
                $nickname = $request->input('nickname');
                $pid = $request->input('pid');
                $videoComObj = videoComment::create([
                    'pid' => $pid,
                    'parent_id' => 0,
                    'content' => $content,
                    'created_by' => $request->uid,
                    'nickname' => $nickname,
                ]);
                if ($videoComObj) {
                    $code = 200;
                    $info = "评论成功";
                } else {
                    $code = 1001;
                    $info = "数据连接失败";
                }
            }
        }

        return response()->json(compact('code', 'info', 'data'));
    }

    public function reply(Request $request)
    {
        if (is_null($request->uid)) {
            $code = 1000;
            $info = "token does not exit";
        } else {
            $validator = Validator::make($request->all(), [
                'content' => ['required', 'max:200'],
                'parent_id' => 'required',
                'pid' => 'required',
                'nickname' => 'required',
            ], [
                'content.required' => '内容不能为空',
                'content.max' => '回复内容最多不超过200个字',
                'pid.required' => '视频pid不能为空',
                'parent_id.required' => '这条评论不存在或被删除',
                'nickname' => '昵称不能为空',
            ]);
            if ($validator->fails()) {
                $valimsg = $validator->messages();
                if ($valimsg->has('content')) {
                    $code = 1001;
                    $info = $valimsg->first('content');
                } else if ($valimsg->has('parent_id')) {
                    $code = 1002;
                    $info = $valimsg->first('parent_id');
                } else if ($valimsg->has('pid')) {
                    $code = 1003;
                    $info = $valimsg->first('pid');
                } else if ($valimsg->has('nickname')) {
                    $code = 1004;
                    $info = $valimsg->first('nickname');
                }
            } else {
                $pid = $request->input('pid');
                $parentId = $request->input('parent_id');
                $content = $request->input('content');
                $nickname = $request->input('nickname');
                $videoObj = Video::where(['pid' => $pid])->first();
                if (is_null($videoObj)) {
                    $code = 1005;
                    $info = "视频id不存在";
                } else {
                    $videoComObj = VideoComment::where(['id' => $parentId])->first();
                    if (is_null($videoComObj)) {
                        $code = 1006;
                        $info = "评论不存在或被删除";
                    } else {
                        $replyObj = VideoComment::create([
                            'pid' => $pid,
                            'parent_id' => $parentId,
                            'content' => $content,
                            'created_by' => $request->uid,
                            'nickname' => $nickname,
                        ]);
                        if ($replyObj) {
                            $code = 200;
                            $info = "回复成功";
                        } else {
                            $code = 1007;
                            $info = "回复失败";
                        }
                    }
                }
            }
        }

        return response()->json(compact('code', 'info', 'data'));

    }

}