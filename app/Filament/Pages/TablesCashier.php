<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;

class TablesCashier extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.tables-cashier';

//    public function mount()
//    {
//        if(!Auth::user()->authorized('view current invoices'))
//        {
//            abort(403);
//        }
//    }
}
