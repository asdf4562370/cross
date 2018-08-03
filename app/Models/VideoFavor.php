<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoFavor extends Model
{
    protected $table = 'videos_favor';

    protected $fillable = [
        'pid',
        'title',
        'created_by',
    ];
}