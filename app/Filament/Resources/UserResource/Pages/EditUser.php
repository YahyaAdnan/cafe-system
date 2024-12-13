<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Models\User;
use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->disabled(fn(User $user) => !$user->isDeletable()),
        ];
    }
}
