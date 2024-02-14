<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
    ];

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
