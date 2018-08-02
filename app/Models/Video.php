<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $fillable = [
        'pid',
        'type',
        'level',
        'title',
        'content',
        'currency',
        'price',
        'comments',
        'duration',
        'screen_orientation',
        'clip_begin',
        'origin_filename',
        'origin_filesize',
        'video_cover',
        'reson',
        'status',
        'expire',
        'created_by',
    ];

    /**
     * 待审核--后台管理，待审核视频
     * @return mixed
     */
    public function scopeWaitAudit() {
        return $this->where(['status' => 'encoded']);
    }

    /**
     * 注意：select中的pid不能取消，取消则取不到数据
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hasManyVideoUrl() {
        return $this->hasMany('App\Models\VideoUrl','pid','pid')->select('pid','line','quality','url','size');
    }

    public function hasOneExtend() {
        return $this->hasOne('App\Models\VideoExtend','pid','pid');
    }

}
