<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    //
    use SoftDeletes;
    protected $table = 'roles';
    protected $fillable = ['name', 'status'];
    protected $appends = ['status_name'];
    protected $roleHasPermission = 'role_has_permissions';

    const STATUS_OPEN = 1;
    const STATUS_CLOSE = 2;

    protected static $statusArray = [
        self::STATUS_OPEN => '开启',
        self::STATUS_CLOSE => '关闭'
    ];

    /**
     * 角色状态访问器
     * @return string
     */
    public function getStatusNameAttribute()
    {
        return $this->attributes['status_name'] = self::$statusArray[$this->status];
    }

    /**
     * 多对多关联
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permission()
    {
        return $this->belongsToMany(Permission::class, $this->roleHasPermission, 'role_id', 'permission_id');
    }

    public function roleAdmin()
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'id');
    }
}
