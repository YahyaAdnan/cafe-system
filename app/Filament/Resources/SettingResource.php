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
        $validation = $form->model->validation;
        $valueInput = SettingResource::getInputValidation($validation);
        return $form
            ->schema([
                TextInput::make('title')->disabled(),
                TextArea::make('description')->disabled(),
                $valueInput,
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

    private static function getInputValidation($validation)
    {
        $rules = explode('|', $validation);

        $input = TextInput::make('value');
        
        foreach ($rules as $key => $rule) 
        {
            // START: ADD VALIDATIONS FROM DATABASE
            if($rule == 'required')
            {
                $input = $input->required();
            }

            if($rule == 'numeric')
            {
                $input = $input->numeric();
            }

            if (strpos($rule, 'max:') === 0 && in_array('numeric', $rules)) 
            {
                $maxValue = intval(substr($rule, 4));

                $input = $input->maxValue($maxValue);
            }
    
            if (strpos($rule, 'min:') === 0 && in_array('numeric', $rules)) 
            {
                $minValue = intval(substr($rule, 4));

                $input = $input->minValue($minValue);
            }


            if (strpos($rule, 'max:') === 0 && !in_array('numeric', $rules)) 
            {
                $maxValue = intval(substr($rule, 4));

                $input = $input->maxValue($maxValue);
            }
    
            if (strpos($rule, 'min:') === 0 && !in_array('numeric', $rules)) 
            {
                $minValue = intval(substr($rule, 4));

                $input = $input->minValue($minValue);
            }

            // END: ADD VALIDATIONS FROM DATABASE  
        }

        return $input;
    }
}
