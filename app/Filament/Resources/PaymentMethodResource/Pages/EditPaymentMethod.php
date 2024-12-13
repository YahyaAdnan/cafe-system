<?php

namespace App\Filament\Resources\PaymentMethodResource\Pages;

use App\Models\PaymentMethod;
use App\Filament\Resources\PaymentMethodResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPaymentMethod extends EditRecord
{
    protected static string $resource = PaymentMethodResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->disabled(fn(PaymentMethod $paymentMethod) => !$paymentMethod->isDeletable()),            
        ];
    }
}
