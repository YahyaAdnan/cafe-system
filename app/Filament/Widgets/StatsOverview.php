<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\DailySale;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $invoices =  DailySale::activeDailySale()->invoices;
        return [
            Stat::make('Totla Current Amount', number_format($invoices->pluck('amount')->sum()) . ' IQD'),
            Stat::make('Bounce rate', '21%'),
            Stat::make('Average time on page', '3:12'),
        ];
    }
}
