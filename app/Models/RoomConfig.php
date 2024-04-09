<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomConfig extends Model
{
    use HasFactory;
    protected $fillable = [
        'room_id',
        'roomable_id',
        'roomable_type',
    ];

    public function roomable()
    {
        return $this->morphTo();
    }

    public function room()
    {
        return $this->belongsTo(Room::class,'room_id');
    }

}
