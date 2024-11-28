<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
      'title',
      'cashier',
      'monitor',
      'printing',
    ];


    public function printers()
    {
        return $this->hasMany(Printer::class,'room_id');
    }

    public function roomConfig()
    {
        return $this->morphMany(RoomConfig::class,'room_id');
    }
}
