<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'title_ar',
        'title_ku',
        'image',
        'is_available',
        'show',
        'show_ingredients',
        'item_type_id',
        'item_category_id',
        'item_subcategory_id',
        'note',
    ];

    public function available()
    {
        if(!$this->is_available)
        {
            return false;
        }

        foreach($this->itemIngredients->where('main', 1) as $itemIngredient)
        {
            if(!$itemIngredient->ingredient->is_available)
            {
                return false;
            }
        }

        return true;
    }

    public function  getAssociatedRoomConfig()
    {
        $roomConfig = RoomConfig::where('roomable_type',self::class)
                                 ->where('roomable_id',$this->id)
                                ->first();
        if ($roomConfig)
            return $roomConfig->room_id;

        $roomConfig = RoomConfig::where('roomable_type',ItemCategory::class)
            ->where('roomable_id',$this->item_category_id)
            ->first();
        if ($roomConfig)
            return $roomConfig->room_id;

        $roomConfig = RoomConfig::where('roomable_type',ItemType::class)
            ->where('roomable_id',$this->item_type_id)
            ->first();
        if ($roomConfig)
            return $roomConfig->room_id;
            else{
                $roomConfig = null;
                return  $roomConfig;
            }


    }

    public function itemCategory()
    {
        return $this->belongsTo(ItemCategory::class);
    }

    public function extras()
    {
        return $this->belongsToMany(Extra::class, 'extra_items', 'item_id', 'extra_id');
    }

    public function itemSubcategory()
    {
        return $this->belongsTo(ItemSubcategory::class);
    }

    public function itemType()
    {
        return $this->belongsTo(ItemType::class);
    }

    public function itemIngredients()
    {
        return $this->hasMany(ItemIngredient::class);
    }

    public function prices()
    {
        return $this->hasMany(Price::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function offerEntities()
    {
        return $this->belongsToMany(OfferEntity::class, 'offer_entities_items', 'item_id', 'offer_entity_id');
    }

    public function isDeletable()
    {
        if($this->orders->isNotEmpty())
        {
            return false;
        }

        return true;
    }


}
