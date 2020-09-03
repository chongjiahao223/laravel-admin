<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable implements JWTSubject
{
    //
    use Notifiable, SoftDeletes;

    protected $table = 'admins';
    protected $fillable = [
        'name','phone', 'password','api_token','remember_token',
    ];
    protected $hidden = ['password'];
    protected $appends = ['status_name'];
    protected $adminHasRole = 'admin_has_roles';

    const STATUS_OPEN = 1;
    const STATUS_CLOSE = 2;

    protected static $statusArray = [
        self::STATUS_OPEN => '开启',
        self::STATUS_CLOSE => '关闭'
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * 密码修改器
     * @param $value
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    /**
     * 定义status访问器
     * @return string
     */
    public function getStatusNameAttribute()
    {
        return $this->status_name = self::$statusArray[$this->status];
    }

    /**
     * 多对多关联
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function role()
    {
        return $this->belongsToMany(Role::class, $this->adminHasRole, 'admin_id', 'role_id');
    }
}
