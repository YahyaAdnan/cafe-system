<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = [
        'permission_id',
        'role_id',
    ];

    protected $table = "permissions";

    public $timestamps = false;
    
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_has_permission');
    }
}
