<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SettingResource\Pages;
use App\Filament\Resources\SettingResource\RelationManagers;
use App\Models\Setting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TextArea;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        // $rules = explode('|', $form->model->validation);

        // $input = TextInput::make('value');

        // START: ADD VALIDATIONS FROM DATABASE
        // if(isset($rules['required']))
        // {
        //     $input = $input->required();
        // }

        // if(isset($rules['numeric']))
        // {
        //     $input = $input->numeric();
        // }

        // if(isset($rules['max']))
        // {
        //     $input = $input->numeric();
        // }

        // END: ADD VALIDATIONS FROM DATABASE

        return $form
            ->schema([
                TextInput::make('title')->disabled(),
                TextArea::make('description')->disabled(),
                TextInput::make('value'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->sortable(),
                TextColumn::make('value')->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ]);
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
            'index' => Pages\ListSettings::route('/'),
            'create' => Pages\CreateSetting::route('/create'),
            'edit' => Pages\EditSetting::route('/{record}/edit'),
        ];
    }

    // private function getInputValidation()
    // {

    // }
}
