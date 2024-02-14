<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\InventoryUnit;

class InventoryUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        InventoryUnit::create([
            "title" => "KG"
        ]);

        InventoryUnit::create([
            "title" => "Grams"
        ]);

        InventoryUnit::create([
            "title" => "Liters"
        ]);

        InventoryUnit::create([
            "title" => "Boxes"
        ]);

        InventoryUnit::create([
            "title" => "Bottles"
        ]);

        InventoryUnit::create([
            "title" => "Piece"
        ]);
    }
}
