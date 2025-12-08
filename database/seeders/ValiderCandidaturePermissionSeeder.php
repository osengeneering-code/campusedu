<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class ValiderCandidaturePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer la permission si elle n'existe pas
        $permission = Permission::firstOrCreate(['name' => 'valider_candidatures']);

        // Trouver les rôles admin et directeur_general
        $adminRole = Role::where('name', 'admin')->first();
        $directeurRole = Role::where('name', 'directeur_general')->first();

        // Assigner la permission aux rôles
        if ($adminRole) {
            $adminRole->givePermissionTo($permission);
        }
        if ($directeurRole) {
            $directeurRole->givePermissionTo($permission);
        }

        $this->command->info('Permission "valider_candidatures" created and assigned to "admin" and "directeur_general" roles.');
    }
}