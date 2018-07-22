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
            if (is_null($request->pid)) {
                $code = 1001;
                $info = "请输入视频pid";
            } else {
                $validator = Validator::make($request->all(), [
                    'contents' => 'required'
                ], [
                    'contents.required' => '评论不能为空',
                ]);
                if ($validator->fails()) {
                    $valimsg = $validator->messages();
                    if ($valimsg->has('contents')) {
                        $code = 1002;
                        $info = $valimsg->first('contents');
                    } else {
                        $code = 1003;
                        $info = "未知错误";
                    }
                } else {
                    $videoComObj = videoComment::create([
                        'pid' => $request->pid,
                        'parent_id' => 0,
                        'content' => $request->contents,
                        'created_by' => 0,
                    ]);
                    if(is_null($videoComObj)){
                        $code = 1004;
                        $info = "评论失败";
                    }else{
                        $code = 200;
                        $info = "评论成功";
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