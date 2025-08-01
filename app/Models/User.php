<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens, HasFactory, Notifiable;
    // use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
      
    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }  

    public function authorized($action)
    {
        try {
            return $this->role->hasPermissionTo($action);
        } catch (\Throwable $th) {
            return false;
        }
    }  

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function isDeletable()
    {
        if($this->expenses->isNotEmpty())
        {
            return false;
        }

        if($this->orders->isNotEmpty())
        {
            return false;
        }

        if($this->payments->isNotEmpty())
        {
            return false;
        }

        if($this->transactions->isNotEmpty())
        {
            return false;
        }
        
        return true;
    }
}
