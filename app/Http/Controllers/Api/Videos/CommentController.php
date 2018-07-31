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
use Carbon\Carbon;

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

    public function like(Request $request) {
        if (is_null($request->uid)) {
            $code = 1000;
            $info = "token does not exit";
        } else {
            $validator = Validator::make($request->all(), [
                'comment_id' => 'required',
            ], [
                'comment_id.required' => 'comment_id不能为空',
            ]);
            if ($validator->fails()) {
                $valimsg = $validator->messages();
                if ($valimsg->has('comment_id')) {
                    $code = 1002;
                    $info = $valimsg->first('comment_id');
                } else {
                    $code = 1001;
                    $info = "未知错误";
                }
            } else {
                $comment_id = $request->input('comment_id');
                $commentObj = VideoComment::find($comment_id);
                if (is_null($commentObj)) {
                    $code = 1003;
                    $info = "comment_id不正确";
                } else {
                    $likeObj = VideoCommentLike::where(['comment_id' => $comment_id, 'created_by' => $request->uid])->first();
                    if (is_null($likeObj)) {
                        //点赞
                        $theObj = VideoCommentLike::create([
                            'comment_id' => $comment_id,
                            'created_by' => $request->uid,
                        ]);
                        if ($theObj) {
                            CommentHelper::updateLike($comment_id);
                            $code = 200;
                            $info = "点赞成功";
                        } else {
                            $code = 1003;
                            $info = "点赞失败";
                        }
                    } else {
                        //取消点赞
                        $affected = $likeObj->delete();
                        if ($affected) {
                            CommentHelper::updateLike($comment_id);
                            $code = 200;
                            $info = "取消成功";
                        } else {
                            $code = 1004;
                            $info = "取消失败";
                        }
                    }
                }

            }
        }

        return response()->json(compact('code', 'info', 'data'));
    }

    /**
     * 评论列表
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(Request $request) {
        $validator = Validator::make($request->all(), [
            'pid' => 'required',
        ], [
            'pid.required' => 'pid不能为空',
        ]);

        if ($validator->fails()) {
            $valimsg = $validator->messages();
            if ($valimsg->has('pid')) {
                $code = 1002;
                $info = $valimsg->first('pid');
            } else {
                $code = 1001;
                $info = "未知错误";
            }
        } else {
            $perPage = 20;
            $pid = $request->input('pid');
            $code = 200;
            $data = [];
            Carbon::setLocale('zh');
            $commentObj = VideoComment::where(["pid"=>$pid,"parent_id"=>0])->orderBy('created_at', 'desc')->paginate($perPage);
            if ($commentObj->isNotEmpty()) {
                $info = "non-nil";
                $results = $commentObj->toArray();
                $result = $results["data"];
                for ($i=0;$i<count($result);$i++) {
                    $data[$i]["comment_id"] = $result[$i]["id"];
                    $data[$i]["pid"] = $result[$i]["pid"];
                    $data[$i]["like_num"] = $result[$i]["like_num"];
                    $data[$i]["content"] = $result[$i]["content"];
                    $data[$i]["nickname"] = $result[$i]["nickname"];
                    $data[$i]["created_by"] = $result[$i]["created_by"];
                    $data[$i]["date"] = Carbon::parse($result[$i]["created_at"])->diffForHumans();
                    $data[$i]["reply"] = [];
                    $replyObj = VideoComment::where(["parent_id"=>$result[$i]["id"]])->orderBy('created_at', 'desc')->get();
                    if ($replyObj->isNotEmpty()) {
                        $reply = $replyObj->toArray();
                        for ($j=0;$j<count($reply);$j++) {
                            if ($j < 10) {
                                //只显示最后回复的10条，多出的就抛弃
                                $data[$i]["reply"][$j]["content"] = $reply[$j]["content"];
                                $data[$i]["reply"][$j]["nickname"] = $reply[$j]["nickname"];
                                $data[$i]["reply"][$j]["created_by"] = $reply[$j]["created_by"];
                            }
                        }
                    }
                }
            } else {
                $info = "nil";
            }
        }

        return response()->json(compact('code', 'info', 'data'));
    }

    public function pull(Request $request)
    {
        if (is_null($request->uid)) {
            $code = 1000;
            $info = "token does not exit";
        } else {
            $perPage = 10;
            $commentObj = VideoComment::where(['pid' => $request->pid])->where('parent_id', '==', 0)->paginate($perPage);
            if ($commentObj->isNotEmpty()) {
                $info = "";
                $code = 200;
                $comments = $commentObj->toArray();
                $list1 = $comments["data"];
                for ($i = 0; $i < count($list1); $i++) {
                    $data1[$i]["content"] = $list1[$i]["content"];
                    $data1[$i]["nickname"] = $list1[$i]["nickname"];
                    $data1[$i]["created_at"] = $list1[$i]["created_at"];
                    $data1[$i]["id"] = $list1[$i]["id"];
                }
            } else {
                $code = 1001;
                $info = "暂无评论";
            }
            $replyObj = VideoComment::where(['pid' => $request->pid])->where('parent_id', '!=', 0)->paginate($perPage);
            if ($replyObj->isNotEmpty()) {
                $replies = $replyObj->toarray();
                $list2 = $replies["data"];
                for ($i = 0; $i < count($list2); $i++) {
                    $data2[$i]["content"] = $list2[$i]["content"];
                    $data2[$i]["nickname"] = $list2[$i]["nickname"];
                    $data2[$i]["created_at"] = $list2[$i]["created_at"];
                    $data2[$i]["parent_id"] = $list2[$i]["parent_id"];
                }
            }
        }
        return response()->json(compact('code', 'info', 'data1','data2'));
    }

}