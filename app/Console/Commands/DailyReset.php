<?php

namespace App\Console\Commands;

use App\Models\DailySale;
use App\Models\Setting;

use Illuminate\Console\Command;
use App\Services\GenerateDailySale;

class DailyReset extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:daily-reset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        \Log::info('DailyReset command started.');

        $resetTime = Setting::get('Reset Time') ?? '5:00';

        // get the hour part of the reset time
        $resetHour = \Carbon\Carbon::createFromFormat('H:i', $resetTime)->format('H');

        // get the current hour
        $currentHour = now()->format('H');

        // if the hour is same for example "5:00" or "5:15" are same.
        if ($currentHour === $resetHour)
        {
            \Log::info('Genrating a new Daily Sale started.');
            GenerateDailySale::createDailySale();
            \Log::info('Genrating a new Daily Sale completed.');
        }
        else
        {
            \Log::info("it's not the time to reset.");
        }


        \Log::info('DailyReset command completed.');
    }
}
