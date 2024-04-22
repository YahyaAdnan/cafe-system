<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role as RoleModel;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'guard_name'
    ];
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->guard_name = 'web';
        });
    }

    protected $table = "roles";

    public $timestamps = false;

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_has_permissions');
    }
    
    public function getPermissionsName()
    {
        return implode(', ', $this->permissions->pluck('name')->toArray()) . '.';
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function isDeletable()
    {
        if($this->name == 'admin')
        {
            return false;
        }

        return $this->permissions->isNotEmpty();
    }
}