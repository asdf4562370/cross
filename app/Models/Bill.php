<?php
/**
 * 账单模型
 * User: hzg
 * Date: 2018-06-19
 * Time: 15:05
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $fillable = [
        'currency',
        'amount',
        'balance',
        'business_type',
        'description',
        'status',
        'created_by',
    ];
}