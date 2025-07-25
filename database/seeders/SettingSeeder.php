<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::create([
            'title' => 'Cafe Name',
            'description' => '',
            'value' => 'Cafe',
            'validation' => 'required|min:2|max:32',
        ]);

        Setting::create([
            'title' => 'Image',
            'description' => '',
            'value' => '0',
            'validation' => 'nullable|image',
        ]);

        Setting::create([
            'title' => 'Color',
            'description' => '',
            'value' => '0',
            'validation' => 'required|color',
        ]);
    
        Setting::create([
            'title' => 'description',
            'description' => '',
            'value' => '0',
            'validation' => 'required|min:2|max:64',
        ]);

        Setting::create([
            'title' => 'Password',
            'description' => 'Password used for the ',
            'value' => '1234',
            'validation' => 'required|min:2|max:32',
        ]);

        Setting::create([
            'title' => 'Reset Time',
            'description' => 'The Reset time for the Daily Sale Required for the accounting.',
            'value' => '5:00',
            'validation' => 'required|time',
        ]);

        Setting::create([
            'title' => 'Taxes',
            'description' => '',
            'value' => '5',
            'validation' => 'required|numeric|min:0|max:100',
        ]);

        Setting::create([
            'title' => 'Services',
            'description' => '',
            'value' => '10',
            'validation' => 'required|numeric|min:0|max:100',
        ]);

        Setting::create([
            'title' => 'Max Fixed Discount',
            'description' => '',
            'value' => '0',
            'validation' => 'required|numeric|min:0|max:2000000000',
        ]);

        Setting::create([
            'title' => 'Max Rate Discount',
            'description' => '',
            'value' => '0',
            'validation' => 'required|numeric|min:0|max:100',
        ]);

        Setting::create([
            'title' => 'Max Item Discount',
            'description' => '',
            'value' => '0',
            'validation' => 'required|numeric|min:0|max:2000000000',
        ]);

        // Setting::create([
        //     'title' => 'Primary Color',
        //     'description' => '',
        //     'validation' => 'required|color',
        // ]);
    }
}
