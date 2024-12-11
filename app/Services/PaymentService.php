<?php
namespace App\Services;

use App\Models\Invoice;
use App\Models\Payment;
use App\Models\PaymentMethod;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components;
use Filament\Forms\Get;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PaymentService
{
    public static function createPayemnt(Invoice $invoice)
    {
        return Action::make("Payment")
            ->label("Payment Create")
            ->icon('heroicon-m-currency-dollar')
            ->form([
                Components\Fieldset::make('Payment')
                ->schema([
                    Components\Hidden::make('invoice_id')
                        ->default($invoice->id),
                    Components\Select::make('payment_method_id')
                        ->default(fn() => PaymentMethod::first()?->id)
                        ->columnSpan(12)
                        ->createOptionForm([
                            Components\TextInput::make('title')
                            ->required()
                            ->maxLength(64),
                        ])
                        ->createOptionUsing(function (array $data) {
                            return PaymentMethod::create($data)->id;
                        })
                        ->native(false)
                        ->options(PaymentMethod::pluck('title', 'id'))
                        ->required(),
                    Components\TextInput::make('amount')
                        ->default(fn() => $invoice->remaining)
                        ->columnSpan([
                            'sm' => 12,
                            'md' => 6,
                            'lg' => 4,
                        ])
                        ->suffix("IQD")
                        ->numeric()
                        ->required()
                        ->minValue(1)
                        ->maxValue(fn() => $invoice->remaining)
                        ->live(),
                    Components\TextInput::make('paid')
                        ->default(fn() => $invoice->remaining)
                        ->columnSpan([
                            'sm' => 12,
                            'md' => 6,
                            'lg' => 4,
                        ])
                        ->suffix("IQD")
                        ->numeric()
                        ->required()
                        ->minValue(fn (Get $get) => $get('amount'))
                        ->maxValue(10000000)
                        ->live(),
                    Components\Placeholder::make('Return')
                        ->content(function (Get $get)  {
                            try {
                                return number_format($get('paid') - $get('amount')) . ' IQD';
                            } catch (\Throwable $th) {
                                return '0 IQD';
                            }
                        })
                        ->columnSpan(['sm' => 12, 'md' => 12, 'lg' => 4]),
                    Components\TextInput::make('note')
                        ->columnSpan(12)
                        ->maxLength(64),
                ])
                ->columns(12),
            ])
            ->action(fn(array $data) => Payment::create($data))
            ->successRedirectUrl('invoices/' . $invoice->id)
            ->hidden(!Auth::user()->authorized('create payments'));
            #TODO: URL JUST REFRESH.
    }

    public static function showPayments(Invoice $invoice)
    {
        return Action::make('show')
            ->label('Show Payments')
            ->icon('heroicon-m-eye')
            ->modalContent(fn (): View => view('show-payment', ["invoice" => $invoice]))
            ->modalCancelAction(false)
            ->modalSubmitAction(false)
            ->hidden(!Auth::user()->authorized('create payments'));
    }

}