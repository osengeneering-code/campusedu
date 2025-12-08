<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class GererFraisPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer la permission si elle n'existe pas
        $permission = Permission::firstOrCreate(['name' => 'gerer_frais']);

        // Trouver les rôles admin et comptable
        $adminRole = Role::where('name', 'admin')->first();
        $comptableRole = Role::where('name', 'comptable')->first();

        // Assigner la permission aux rôles
        if ($adminRole) {
            $adminRole->givePermissionTo($permission);
        }
        if ($comptableRole) {
            $comptableRole->givePermissionTo($permission);
        }

        $this->command->info('Permission "gerer_frais" created and assigned to "admin" and "comptable" roles.');
    }
}