<?php

namespace App\Http\Controllers\Api\Videos;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\VideoCollect;
use App\Models\Video;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class CollectController extends Controller
{
    public function collect(Request $request)
    {
        if (is_null($request->uid)) {
            $code = 1000;
            $info = "token does not exit";
        } else {
            $validator = Validator::make($request->all(), [
                'pid' => 'required',
            ], [
                'pid.required' => 'pid不能为空',
            ]);
            if ($validator->fails()) {
                $valimsg = $validator->messages();
                if ($valimsg->has('pid')) {
                    $code = 1001;
                    $info = $valimsg->first('pid');
                } else {
                    $code = 1002;
                    $info = "未知错误";
                }
            } else {
                $pid = $request->input('pid');
                $videoObj = Video::where(['pid' => $pid])->first();
                if (is_null($videoObj)) {
                    $code = 1003;
                    $info = "该视频id不存在";
                } else {
                    $title = $videoObj->title;
                    $videoColObj = VideoCollect::where(['pid' => $pid])->first();
                    if (is_null($videoColObj)) {
                        $theObj = VideoCollect::create([
                            'pid' => $pid,
                            'created_by' => $request->uid,
                            'title' => $title,
                        ]);
                        if ($theObj) {
                            $code = 200;
                            $info = "收藏成功";
                        } else {
                            $code = 1004;
                            $info = "收藏失败";
                        }
                    } else {
                        $code = 1005;
                        $info = "该视频已经存在";
                    }
                }
            }
        }
        return response()->json(compact('code', 'info'));
    }


    public function del(Request $request)
    {
        if (is_null($request->uid)) {
            $code = 1000;
            $info = "token does not exit";
        } else {
            $validator = Validator::make($request->all(), [
                'pid' => 'required',
            ], [
                'pid.required' => 'pid不能为空'
            ]);
            if ($validator->fails()) {
                $valimsg = $validator->message();
                if ($valimsg->has('pid')) {
                    $code = 1001;
                    $info = $valimsg->first('pid');
                } else {
                    $code = 1002;
                    $info = "未知错误";
                }
            } else {
                $pid = $request->input('pid');
                $videoColObj = VideoCollect::where(['pid' => $pid])->first();
                if (!is_null($videoColObj)) {
                    $theObj = $videoColObj->delete();
                    if ($theObj) {
                        $code = 200;
                        $info = "取消成功";
                    } else {
                        $code = 1003;
                        $info = "取消失败";
                    }
                }
            }
        }
        return response()->json(compact('code', 'info'));
    }

    public function list(Request $request)
    {
        if (is_null($request->uid)) {
            $code = 1000;
            $info = "token does not exit";
        } else {
            $code = 200;
            $data=[];
            $perpage=10;
            Carbon::setLocale('zh');
            $videoColObj=VideoCollect::where(['created_by'=>$request->uid])->orderBy('created_at','desc')->paginate($perpage);
            if($videoColObj->isNotEmpty()){
                $info = "";
                $collections=$videoColObj->toArray();
                $collection=$collections["data"];
                for($i=0;$i<count($collection);$i++){
                    $data[$i]['pid']=$collection[$i]['pid'];
                    $data[$i]['title']=$collection[$i]['title'];
                    $data[$i]['date']=Carbon::parse($collection[$i]['created_at'])->diffForHumans();
                    }
            }else{
                $info = "暂无收藏视频";
            }
        }
        return response()->json(compact('code','info','data'));
    }
}
