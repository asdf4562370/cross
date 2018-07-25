<?php
/**
 * 找出最多点赞的评论，放入评论冗余
 * Created by TRush.
 * Date: 2018/07/25
 * Time: 07:44
 *
 * 在命令行执行以下操作：
 * php artisan commentliketotals
 *
 */
namespace App\Console\Commands;

use App\Models\Video;
use App\Models\VideoComment;
use App\Models\VideoCommentLike;
use App\Models\VideoExtend;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class CommentTotals extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'commenttotals';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '找出最多点赞的评论';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $cacheKey = "comment_totals";
        $cacheVal = Cache::get($cacheKey);
        if (!is_null($cacheVal)) {
            $comment_id = $cacheVal[0];
            $commentObj = VideoComment::find($comment_id);
            if (!is_null($commentObj)) {
                $pid = $commentObj->pid;

                $likeCount = VideoCommentLike::where(['comment_id' => $comment_id])->count();
                //---更新点赞数---\
                if ($likeCount != $commentObj->like_num) {
                    //点赞数与统计不相符，则更新点赞数
                    $commentObj->update(["like_num"=>$likeCount]);
                }
                //---更新点赞数---/

                //---更新评论冗余---\
                $likeMax = VideoComment::where(['pid' => $pid])->max('like_num');
                $results = VideoComment::where(['like_num' => $likeMax])->orderBy('created_at', 'desc')->first();
                if (!is_null($results)) {
                    $result = $results->toArray();
                    $data = [
                        "comment_id" => $result["id"],
                        "pid" => $result["pid"],
                        "like_num" => $result["like_num"],
                        "content" => $result["content"],
                        "nickname" => $result["nickname"],
                        "created_by" => $result["created_by"],
                        "date" => $result["created_at"],
                        "reply" => [],
                    ];
                    $replyObj = VideoComment::where(["parent_id"=>$result["id"]])->orderBy('created_at', 'desc')->get();
                    if ($replyObj->isNotEmpty()) {
                        $reply = $replyObj->toArray();
                        for ($j=0;$j<count($reply);$j++) {
                            if ($j < 10) {
                                //只显示最后回复的10条，多出的就抛弃
                                $data["reply"][$j]["content"] = $reply[$j]["content"];
                                $data["reply"][$j]["nickname"] = $reply[$j]["nickname"];
                                $data["reply"][$j]["created_by"] = $reply[$j]["created_by"];
                            }
                        }
                    }
                    Video::where(["pid"=>$pid])->update(["comments"=>json_encode($data)]);
                }
                //---更新评论冗余---/

                //---更新评论数量---\
                $commentCount = VideoComment::where(['pid' => $pid,'parent_id' => 0])->count();
                VideoExtend::where(['pid' => $pid])->update(["comments_count"=>$commentCount]);
                //---更新评论数量---/

                array_splice($cacheVal, 0, 1);
                Cache::forever($cacheKey, $cacheVal);
            }
        }
    }
}
