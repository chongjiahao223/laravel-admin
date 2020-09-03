<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends Model
{
    //
    use SoftDeletes;
    protected $table = 'permissions';
    protected $fillable = ['name', 'display_name', 'icon', 'parent_id', 'sort', 'type', 'admin_id'];
    protected $appends = ['type_name'];

    const TYPE_BUTTON = 1;
    const TYPE_MENU = 2;
    protected static $typeArray = [
        self::TYPE_BUTTON => '按钮',
        self::TYPE_MENU => '菜单'
    ];

    /**
     * 子权限
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function child()
    {
        return $this->hasMany(Permission::class, 'parent_id', 'id');
    }

    /**
     *所有子权限递归
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function allChild()
    {
        return $this->child()->with(['allChild' => function($query) {
            $query->with('permissionAdmin');
        }]);
    }

    /**
     * 反向管理admin
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function permissionAdmin()
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'id');
    }

    /**
     * 权限类型访问器
     * @return mixed
     */
    public function getTypeNameAttribute()
    {
        return $this->type_name = self::$typeArray[$this->type];
    }
}
