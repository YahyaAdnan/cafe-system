<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
    ];
    
    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public function isDeletable()
    {
        if($this->id == 1 || $this->id == 2 || $this->id == 3)
        {
            return false;
        }

        if($this->expenses->isNotEmpty())
        {
            return false;
        }

        return true;
    }
}
