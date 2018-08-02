<?php
/**
 * 评论模型
 * Created by TRush.
 * Date: 2018-07-21
 * Time: 08:23
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoComment extends Model
{
    protected $table = 'videos_comment';

    protected $fillable = [
        'pid',
        'parent_id',
        'content',
        'like_num',
        'nickname',
        'created_by',
    ];
}