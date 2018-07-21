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
use App\Models\Video;

class CommentController extends Controller
{
    public function comment(Request $request)
    {
        if (is_null($request->uid)) {
            $code = 1000;
            $info = "token does not exit";
        } else {
            $videoObj = video::where(['pid' => $request->pid])->first();
            if (is_null($videoObj)) {
                $code = 1001;
                $info = "该视频ID不存在";
            } else {
                $validator = Validator::make($request->all(), [
                    'comment' => 'required'
                ], [
                    'comment.required' => '留言不能为空',
                ]);
                if ($validator->fails()) {
                    $valimsg = $validator->messages();
                    if ($valimsg->has('comment')) {
                        $code = 1002;
                        $info = $valimsg->first('comment');
                    } else {
                        $code = 1003;
                        $info = "未知错误";
                    }
                } else { 
                    $videoComObj =$videoObj->hasManyComment()->first();
                    $videoComObj->comment = $request->comment;
                    $videoComObj->pid = $request->pid;
                    $videoComObj->created_by = $videoObj->created_by;
                    $videoComObj->parent_id = $request->uid;
                    $videoComObj->save();
                    if ($videoComObj->comment==$request->comment) {
                        $code = 200;
                        $info = "评论成功";
                    } else {
                        $code = 1003;
                        $info = "评论失败";
                    }
                }
            }
        }

        return response()->json(compact('code', 'info', 'data'));
    }

    public function reply(Request $request)
    {

    }

}