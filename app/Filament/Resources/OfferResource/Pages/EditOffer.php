<?php

namespace App\Filament\Resources\OfferResource\Pages;

use App\Filament\Resources\OfferResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use App\Models\Offer;

class EditOffer extends EditRecord
{
    protected static string $resource = OfferResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $offer = Offer::find($data['id']);
        $data['offerEntities'] = array();

        foreach ($offer->offerEntities as $key => $offerEntity)
        {
            $data['offerEntities'][] = array(
                'items' => $offerEntity->items->pluck('id')->toArray(),
                'price' => $offerEntity->price,
                'show' => $offerEntity->show,
                'active' => $offerEntity->active,
            );
        }

        return $data;
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        //TO-DO: MAKE IT HANDLE THE OUTPUTS.
    }
}
