<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'active'
    ];

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
    
    public function isDeletable()
    {
        if($this->invoices->isNotEmpty())
        {
            return false;
        }

        return true;
    }
    
}
