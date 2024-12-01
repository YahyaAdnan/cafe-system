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

    public static function takeAway()
    {
        $table = Table::where('title', '#')->first();
    
        if (!$table) 
        {
            $table = Table::create([
                'title' => '#',
                'chairs' => 0, 
                'note' => null,
            ]);
        }
    
        return $table;
    }
    
    public function activeInvoicesCount()
    {
        return $this->invoices->where('active', 1)->count();
    }
    
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function activeInvoices()
    {
        return $this->hasMany(Invoice::class)->where('active', 1);
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
