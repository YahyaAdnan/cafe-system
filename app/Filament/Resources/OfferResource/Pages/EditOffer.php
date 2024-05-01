<?php

namespace App\Filament\Resources\OfferResource\Pages;

use App\Filament\Resources\OfferResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use App\Models\Offer;
use App\Models\OfferEntity;
use App\Services\OfferService;

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
                'id' => $offerEntity->id,
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
        // $record->update($data);
        // dd($record->offerEntities->whereNotIn('id', array_column( $data['offerEntities'], 'id')));
        // dd(array_column( $data['offerEntities'], 'id'));
        $deletedEntities = $record->offerEntities
            ->whereNotIn('id', array_column( $data['offerEntities'], 'id'));
        foreach ($deletedEntities as $key => $deletedEntity) 
        {
            $deletedEntity->delete();
        }

        foreach ($data['offerEntities'] as $key => $offerEntity) 
        {
            // if the 
            if(isset($offerEntity['id']))
            {
                OfferService::update($offerEntity);
            }
            else
            {
                OfferService::store(
                    array_merge(
                        $offerEntity,
                        ['offer_id' => $record->id]
                    )
                );
            }
        }

        return $record;
    }
}
