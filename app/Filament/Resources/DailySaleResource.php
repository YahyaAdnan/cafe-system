<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DailySaleResource\Pages;
use App\Filament\Resources\DailySaleResource\RelationManagers;
use App\Models\DailySale;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Hidden;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\Filter;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use  App\Services\GenerateDailySale;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class DailySaleResource extends Resource
{
    protected static ?string $model = DailySale::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Finance';

    public static function canCreate(): bool
    {
        return Auth::user()->authorized('create daily_sales');
    }

    public static function form(Form $form): Form
    {
        $title = GenerateDailySale::getTitle();

        return $form
            ->schema([
                TextInput::make('title')->disabled(),
                Hidden::make('title')->default($title),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->sortable()->toggleable(true)->searchable(),
                TextColumn::make('invoices_count')->counts('invoices')->toggleable(true)->sortable(),
                TextColumn::make('invoices_sum_amount')->sum('invoices', 'amount')->badge()
                    ->color("success")->money('IQD')->toggleable()->sortable(true)->label("Total Amount"),
                TextColumn::make('invoices_sum_remaining')->sum('invoices', 'remaining')
                    ->badge()->color(function (DailySale $dailySale) {
                        if($dailySale->invoices->pluck('remaining')->sum() > 0)
                        {
                            return "danger";
                        }
                        return "success";
                    })->money('IQD')->toggleable(true)->sortable()->label("Total Remaining"),
                TextColumn::make('created_at')->dateTime()->toggleable(true)->sortable()
            ])
            ->filters([
                Filter::make('created_at')
                    ->form([
                        DatePicker::make('created_from'),
                        DatePicker::make('created_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
            ])
            ->checkIfRecordIsSelectableUsing(
                fn(DailySale $dailySale) => $dailySale->isDeletable()
            )
            ->recordUrl(null);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDailySales::route('/'),
            'create' => Pages\CreateDailySale::route('/create'),
            // 'edit' => Pages\EditDailySale::route('/{record}/edit'),
        ];
    }
}
