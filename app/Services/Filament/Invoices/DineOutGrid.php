<?php
namespace App\Services\Filament\Invoices;

use App\Models\DeliverType;
use App\Models\Invoice;
use Filament\Forms\Components\Select;
use Filament\Support\Enums\ActionSize;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\Layout\Grid;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class DineOutGrid
{    
    public static function make(Table $table)
    {
        return $table
            ->query(Invoice::where('active', 1)->where('dinning_in', 0))
            ->columns([
                // START: THE GRID OF TABLES.
                Grid::make()
                ->columns(1)
                ->schema([
                    TextColumn::make('title')
                        ->size(TextColumn\TextColumnSize::Large)
                        ->weight(FontWeight::Bold)
                        ->alignment('center')
                        ->searchable(),
                    TextColumn::make('deliverType.title')
                        ->size(TextColumn\TextColumnSize::Medium)
                        ->weight(FontWeight::Light)
                        ->alignment('left')
                        ->searchable(),
                    TextColumn::make('amount')
                        ->prefix('Money: ')
                        ->money('IQD')
                        ->size(TextColumn\TextColumnSize::Medium)
                        ->weight(FontWeight::Light)
                        ->alignment('left')
                        ->searchable(),
                ])
                // END: THE GRID OF TABLES.
            ])
            ->headerActions([
                Action::make('create')
                    ->label('New Invoice')
                    ->icon('heroicon-s-plus')
                    ->size(ActionSize::Large)
                    ->form([
                        Select::make('deliver_type_id')
                            ->searchable()
                            ->label('Deliver Type')
                            ->options(DeliverType::pluck('title', 'id'))
                            ->required(),
                    ])->action(function (array $data, Seat $seat): void {
                        $invoice = GenerateInovice::dineOut([
                            'deliver_type_id' => $data['deliver_type_id'],
                        ]);
                    }),
            ])
            ->recordUrl(fn (Invoice $invoice): string => "invoices/$invoice->id")
            ->contentGrid(['md' => 2, 'xl' => 3])
            ->paginated(false);
    }
}