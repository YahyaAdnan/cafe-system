<?php

namespace App\Filament\Resources\OfferResource\Pages;

use App\Filament\Resources\OfferResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Models\Item;
use App\Models\Price;
use App\Models\Offer;
use App\Models\OfferEntity;

class CreateOffer extends CreateRecord
{
    protected static string $resource = OfferResource::class;

    protected function handleRecordCreation(array $data): Offer
    {
        $offer = Offer::create([
            'date' => $data['date'], 
            'active' => true, 
            'title' => $data['title'], 
            'title_ar' => $data['title_ar'], 
            'title_ku' => $data['title_ku'], 
        ]);

        foreach ($data['offerEntities'] as $key => $offerEntity) 
        {
            $offerEntity = OfferEntity::create([
                'offer_id' => $offer->id,
                'price' => $offerEntity['price'],
                'show' => $offerEntity['show'],
                'active' => $offerEntity['active'],
            ]);

            foreach ($offerEntity['items'] as $key => $items) 
            {
                $offerEntity->items()->sync(Item::find($items));

                if($offerEntity['active'])
                {
                    $price = Price::create([
                        'item_id' => $item,
                        'title' => $data['title'],
                        'amount' => $data['amount'],
                    ]);

                    $offerEntity->prices()->sync($price);
                }
            }
        }

        return $offer;
    }
}
