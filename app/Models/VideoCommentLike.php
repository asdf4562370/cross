<?php
/**
 * 评论点赞模型
 * Created by TRush.
 * Date: 2018-07-24
 * Time: 21:22
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoCommentLike extends Model
{
    protected $table = 'videos_comment_like';

    protected $fillable = [
        'comment_id',
        'created_by',
    ];

}