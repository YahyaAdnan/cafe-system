<?php

namespace App\Filament\Resources\IngredientResource\Pages;

use App\Models\Ingredient;
use App\Filament\Resources\IngredientResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditIngredient extends EditRecord
{
    protected static string $resource = IngredientResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->disabled(fn(Ingredient $ingredient) => !$ingredient->isDeletable()),
        ];
    }
}
