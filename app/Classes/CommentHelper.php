<?php
/**
 * 评论助手
 * Created by TRush.
 * Date: 2018-07-25
 * Time: 07:53
 */

namespace App\Classes;


use Illuminate\Support\Facades\Cache;

class CommentHelper
{
    public static function updateTotals($comment_id) {
        $cacheKey = "comment_totals";
        $cacheVal = Cache::get($cacheKey);
        if (is_null($cacheVal)) {
            Cache::forever($cacheKey, [
                $comment_id,
            ]);
        } else {
            if (!in_array($comment_id, $cacheVal)) {
                array_push($cacheVal,$comment_id);
                Cache::forever($cacheKey, $cacheVal);
            }
        }
    }
}