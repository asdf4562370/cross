<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoExtend extends Model
{
    protected $table = 'Videos_extend';
    protected $fillable=[
        'pid',
        'play_count',
        'sales_volume',
        'comments_count',
        'favorite_count',
        ];
}
