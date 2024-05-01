<?php
namespace App\Services;

use App\Models\OfferEntity;
use App\Models\Offer;
use App\Models\Price;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class OfferService
{
    public static function store($offerEntity)
    {
        $offerEntityModel = OfferEntity::create([
            'offer_id' => $offerEntity['offer_id'],
            'price' => $offerEntity['price'],
            'show' => $offerEntity['show'],
            'active' => $offerEntity['active'],
        ]);

        $offerEntityModel->items()->attach($offerEntity['items']);

        $offerEntityModel->setPrices();
    }

    public static function update($offerEntity)
    {
        $offerEntityModel = OfferEntity::find($offerEntity['id']);
        $offerEntityModel->update($offerEntity);

        // Let's rebuild the items relations.
        // First detach every item. 
        // Lastly, we attach the items we have from the form data.
        $offerEntityModel->items()->detach();
        foreach ($offerEntity['items'] as $key => $item) 
        {
            $offerEntityModel->items()->attach($item);
        }

        // Check the method in the OfferEntity model to understand it.
        $offerEntityModel->setPrices();
    }
}