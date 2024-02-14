<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'chairs',
        'note',
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
