<?php
/**
 * 用户模型
 * Created by Rush.
 * Date: 2017/08/04
 * Time: 12:03
 */

namespace App;

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

/**
 * App\Models\User
 *
 * @mixin \Eloquent
 * @property int $id
 * @property string $uid 防猜UID
 * @property string $username
 * @property string $nickname 昵称
 * @property string $email
 * @property string $password
 * @property string $access_token 访问令牌
 * @property string $slat 盐值
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereAccessToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereNickname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereSlat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereUsername($value)
 */
class User extends Model
{
    use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uid',
        'introducer_id',
        'username',
        'nickname',
        'email',
        'password',
        'access_token',
        'slat'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'slat', 'access_token',
    ];

    public function hasOnePreference() {
        return $this->hasOne('App\Models\UserPreference','uid','uid');
    }
}
