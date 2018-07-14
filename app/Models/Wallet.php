<?php
/**
 * 用户钱包模型
 * User: hzg
 * Date: 2018-06-18
 * Time: 01:05
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $table = 'wallet';

    protected $fillable = [
        'ticket',
        'diamond',
        'frozen_diamond',
        'last_withdraw_type',
        'last_withdraw_time',
        'created_by',
    ];
}