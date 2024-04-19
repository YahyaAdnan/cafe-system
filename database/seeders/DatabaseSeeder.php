<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\DailySale;
use App\Models\DeliverType;
use App\Models\Employee;
use App\Models\ExpenseCategory;
use App\Models\Extra;
use App\Models\Ingredient;
use App\Models\Inventory;
use App\Models\InventoryRecord;
use App\Models\InventoryUnit;
use App\Models\Item;
use App\Models\ItemCategory;
use App\Models\ItemIngredient;
use App\Models\ItemSubcategory;
use App\Models\ItemType;
use App\Models\Order;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Models\Price;
use App\Models\Printer;
use App\Models\Room;
use App\Models\RoomConfig;
use App\Models\Setting;
use App\Models\SocialMedia;
use App\Models\Supplier;
use App\Models\Table;
use App\Models\Transaction;
use Database\Factories\RoomFactory;
use Illuminate\Database\Seeder;
use App\Models\Invoice;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {


        // \App\Models\User::factory(10)->create();
        $this->call(PermissionsSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(SettingSeeder::class);
        DailySale::factory(10)->create();
         Room::factory(10)->create();
      //  Printer::factory(10)->create();
        DeliverType::factory(10)->create();
        Employee::factory(10)->create();
        ExpenseCategory::factory(10)->create();
        Extra::factory(10)->create();
        Ingredient::factory(10)->create();
       // Inventory::factory(10)->create();
      InventoryUnit::factory(10)->create();
       // InventoryRecord::factory(10)->create();
        Invoice::factory(10)->create();
        ItemCategory::factory(10)->create();
        Item::factory(10)->create();
      //  ItemIngredient::factory(10)->create();
        ItemSubcategory::factory(10)->create();
        ItemType::factory(10)->create();
        Order::factory(10)->create();
      //  Payment::factory(10)->create();
       PaymentMethod::factory(10)->create();
        Price::factory(10)->create();
        Setting::factory(10)->create();
        SocialMedia::factory(10)->create();
     //   Supplier::factory(10)->create();
        Table::factory(10)->create();
        Transaction::factory(10)->create();
        Printer::create([
            "title"=>"Printer 1",
            "printer_id"=>"73259189",
            "room_id"=>"1",
        ]);
    }
}
