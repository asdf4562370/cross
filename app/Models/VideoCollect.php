<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoCollect extends Model
{
    protected $table = 'videos_collect';

    protected $fillable = [
        'pid',
        'title',
        'created_by',
    ];
}