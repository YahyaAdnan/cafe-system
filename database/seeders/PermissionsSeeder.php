<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // ***************************************
        // ********** START PERMISIONS ***********
        // ***************************************

        Permission::create(['name' => 'list payments']);
        Permission::create(['name' => 'view payments']);
        Permission::create(['name' => 'create payments']);
        Permission::create(['name' => 'update payments']);
        Permission::create(['name' => 'delete payments']);

        Permission::create(['name' => 'list invoices']);
        Permission::create(['name' => 'view invoices']);
        Permission::create(['name' => 'create invoices']);
        Permission::create(['name' => 'update invoices']);
        Permission::create(['name' => 'delete invoices']);

        Permission::create(['name' => 'list orders']);
        Permission::create(['name' => 'view orders']);
        Permission::create(['name' => 'create orders']);
        Permission::create(['name' => 'update orders']);
        Permission::create(['name' => 'delete orders']);

        // Permisions for users
        $currentPermissions = Permission::all();
        $userRole = Role::create(['name' => 'user']);
        $userRole->givePermissionTo($currentPermissions);

        Permission::create(['name' => 'list ingredients']);
        Permission::create(['name' => 'view ingredients']);
        Permission::create(['name' => 'create ingredients']);
        Permission::create(['name' => 'update ingredients']);
        Permission::create(['name' => 'delete ingredients']);

        Permission::create(['name' => 'list item_types']);
        Permission::create(['name' => 'view item_types']);
        Permission::create(['name' => 'create item_types']);
        Permission::create(['name' => 'update item_types']);
        Permission::create(['name' => 'delete item_types']);

        Permission::create(['name' => 'list item_categories']);
        Permission::create(['name' => 'view item_categories']);
        Permission::create(['name' => 'create item_categories']);
        Permission::create(['name' => 'update item_categories']);
        Permission::create(['name' => 'delete item_categories']);

        Permission::create(['name' => 'list item_subcategories']);
        Permission::create(['name' => 'view item_subcategories']);
        Permission::create(['name' => 'create item_subcategories']);
        Permission::create(['name' => 'update item_subcategories']);
        Permission::create(['name' => 'delete item_subcategories']);

        Permission::create(['name' => 'list items']);
        Permission::create(['name' => 'view items']);
        Permission::create(['name' => 'create items']);
        Permission::create(['name' => 'update items']);
        Permission::create(['name' => 'delete items']);
        
        Permission::create(['name' => 'list item_ingredients']);
        Permission::create(['name' => 'view item_ingredients']);
        Permission::create(['name' => 'create item_ingredients']);
        Permission::create(['name' => 'update item_ingredients']);
        Permission::create(['name' => 'delete item_ingredients']);

        Permission::create(['name' => 'list prices']);
        Permission::create(['name' => 'view prices']);
        Permission::create(['name' => 'create prices']);
        Permission::create(['name' => 'update prices']);
        Permission::create(['name' => 'delete prices']);

        Permission::create(['name' => 'list tables']);
        Permission::create(['name' => 'view tables']);
        Permission::create(['name' => 'create tables']);
        Permission::create(['name' => 'update tables']);
        Permission::create(['name' => 'delete tables']);

        Permission::create(['name' => 'list payment_methods']);
        Permission::create(['name' => 'view payment_methods']);
        Permission::create(['name' => 'create payment_methods']);
        Permission::create(['name' => 'update payment_methods']);
        Permission::create(['name' => 'delete payment_methods']);

        Permission::create(['name' => 'list expense_categories']);
        Permission::create(['name' => 'view expense_categories']);
        Permission::create(['name' => 'create expense_categories']);
        Permission::create(['name' => 'update expense_categories']);
        Permission::create(['name' => 'delete expense_categories']);

        Permission::create(['name' => 'list expenses']);
        Permission::create(['name' => 'view expenses']);
        Permission::create(['name' => 'create expenses']);
        Permission::create(['name' => 'update expenses']);
        Permission::create(['name' => 'delete expenses']);

        Permission::create(['name' => 'list users']);
        Permission::create(['name' => 'view users']);
        Permission::create(['name' => 'create users']);
        Permission::create(['name' => 'update users']);
        Permission::create(['name' => 'delete users']);

        Permission::create(['name' => 'list daily_sales']);
        Permission::create(['name' => 'view daily_sales']);
        Permission::create(['name' => 'create daily_sales']);
        Permission::create(['name' => 'update daily_sales']);
        Permission::create(['name' => 'delete daily_sales']);

        Permission::create(['name' => 'list deliver_types']);
        Permission::create(['name' => 'view deliver_types']);
        Permission::create(['name' => 'create deliver_types']);
        Permission::create(['name' => 'update deliver_types']);
        Permission::create(['name' => 'delete deliver_types']);

        Permission::create(['name' => 'list employees']);
        Permission::create(['name' => 'view employees']);
        Permission::create(['name' => 'create employees']);
        Permission::create(['name' => 'update employees']);
        Permission::create(['name' => 'delete employees']);

        Permission::create(['name' => 'list inventories']);
        Permission::create(['name' => 'view inventories']);
        Permission::create(['name' => 'create inventories']);
        Permission::create(['name' => 'update inventories']);
        Permission::create(['name' => 'delete inventories']);

        Permission::create(['name' => 'list inventory_records']);
        Permission::create(['name' => 'view inventory_records']);
        Permission::create(['name' => 'create inventory_records']);
        Permission::create(['name' => 'update inventory_records']);
        Permission::create(['name' => 'delete inventory_records']);

        Permission::create(['name' => 'list inventory_units']);
        Permission::create(['name' => 'view inventory_units']);
        Permission::create(['name' => 'create inventory_units']);
        Permission::create(['name' => 'update inventory_units']);
        Permission::create(['name' => 'delete inventory_units']);

        Permission::create(['name' => 'list extras']);
        Permission::create(['name' => 'view extras']);
        Permission::create(['name' => 'create extras']);
        Permission::create(['name' => 'update extras']);
        Permission::create(['name' => 'delete extras']);

        Permission::create(['name' => 'list suppliers']);
        Permission::create(['name' => 'view suppliers']);
        Permission::create(['name' => 'create suppliers']);
        Permission::create(['name' => 'update suppliers']);
        Permission::create(['name' => 'delete suppliers']);

        Permission::create(['name' => 'list transactions']);
        Permission::create(['name' => 'view transactions']);
        Permission::create(['name' => 'create transactions']);
        Permission::create(['name' => 'update transactions']);
        Permission::create(['name' => 'delete transactions']);

        // Create admin role and assign all permissions
        $allPermissions = Permission::all();
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo($allPermissions);

        $user = \App\Models\User::where('name', 'admin')->first();

        if ($user) {
            $user->assignRole($adminRole);
        }

        // ***************************************
        // ********** END PERMISIONS ***********
        // ***************************************
    }
}
