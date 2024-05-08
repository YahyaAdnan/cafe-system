<?php

namespace App\Filament\Resources\InvoiceResource\Pages;

use App\Filament\Resources\InvoiceResource;
use Filament\Actions;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use App\Services\DiscountService;
use App\Models\Table as Seating;
use App\Models\Employee;
use App\Models\DeliverType;
// TESTING
// use App\Services\GenerateReceipt;
// use App\Models\Invoice;

class EditInvoice extends EditRecord
{
    protected static string $resource = InvoiceResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['fixed_discount'] = $data['discount_rate'] == 0;
        
        return $data;
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->columnSpan(12),
                Toggle::make('fixed_discount')
                    ->columnSpan(12)
                    ->live(),
                TextInput::make('discount_rate')
                    ->columnSpan(12)
                    ->visible(fn(Get $get) => !$get('fixed_discount'))
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(DiscountService::maximumRateDiscount()),
                TextInput::make('discount_fixed')
                    ->columnSpan(12)
                    ->visible(fn(Get $get) => $get('fixed_discount'))
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(DiscountService::maximumFixedeDiscount()),
                Toggle::make('dinning_in')
                    ->columnSpan(12)
                    ->live(),
                Select::make('table_id')
                    ->visible(fn(Get $get) => $get('dinning_in'))
                    ->required(fn(Get $get) => $get('dinning_in'))
                    ->label('Table')
                    ->searchable()
                    ->columnSpan(6)
                    ->options(Seating::pluck('title', 'id')),
                Select::make('employee_id')
                    ->visible(fn(Get $get) => $get('dinning_in'))
                    ->required(fn(Get $get) => $get('dinning_in'))
                    ->label('Employee')
                    ->searchable()
                    ->columnSpan(6)
                    ->options(Employee::pluck('name', 'id')),
                Select::make('deliver_type_id')
                    ->visible(fn(Get $get) => !$get('dinning_in'))
                    ->required(fn(Get $get) => !$get('dinning_in'))
                    ->label('Deliver Type')
                    ->searchable()
                    ->columnSpan(6)
                    ->options(DeliverType::pluck('title', 'id')),
                TextInput::make('note')
                    ->maxLength(64)
                    ->columnSpan(12),
            ])
            ->columns(12);
    }

    // Just to make sure the hidden data due to switching toggles is set to null.
    protected function mutateFormDataBeforeSave(array $data): array
    {
        // In case: dinning-in.
        if($data['dinning_in'])
        {
            $data['deliver_type_id'] =  null;
        }
        
        // In case: dinning-out.
        if(!$data['dinning_in'])
        {
            $data['table_id'] =  null;
            $data['employee_id'] =  null;
        }

        // In case: discount fixed (IQD)
        if($data['fixed_discount'])
        {
            $data['discount_rate'] =  0;
        }
                
        // In case: discount not fixed (percentage %)
        if(!$data['fixed_discount'])
        {
            $data['discount_fixed'] =  0;
        }

        return $data;
    }
}
