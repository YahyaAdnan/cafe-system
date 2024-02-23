<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'value',
        'validation'
    ];

    public static function get($title)
    {
        return Setting::where('title', $title)->first()->value;
    }

    public static function getTaxes()
    {
        return Setting::where('title', 'Taxes')->first()->value;
    }

    public static function getServices()
    {
        return Setting::where('title', 'Services')->first()->value;
    }
}
