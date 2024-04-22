<?php

namespace App\Filament\Resources\RoleResource\Pages;

use App\Filament\Resources\RoleResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreateRole extends CreateRecord
{
    protected static string $resource = RoleResource::class;

    // protected function handleRecordCreation(array $data) : Model
    // {
    //     $role = Role::create(['name' => $data['name']]);
    //     $permissions = Permission::whereIn('id', $data['permissions'])->get();
    //     $role->givePermissionTo($permissions);

    //     return $role;
    // }
}
