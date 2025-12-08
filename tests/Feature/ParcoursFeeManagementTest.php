<?php

namespace Tests\Feature;

use App\Models\Filiere;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class ParcoursFeeManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Créer les rôles et permissions nécessaires si ce n'est pas déjà fait
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $comptableRole = Role::firstOrCreate(['name' => 'comptable']);
        $permission = Permission::firstOrCreate(['name' => 'gerer_frais']);

        $adminRole->givePermissionTo($permission);
        $comptableRole->givePermissionTo($permission);
    }

    public function test_admin_can_create_parcours_with_fees(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $filiere = Filiere::factory()->create();

        $response = $this->actingAs($admin)->post(route('academique.parcours.store'), [
            'nom' => 'Nouveau Parcours Test',
            'id_filiere' => $filiere->id,
            'description' => 'Description du nouveau parcours',
            'frais_inscription' => 150000.00,
            'frais_formation' => 750000.00,
        ]);

        $response->assertRedirect(route('academique.parcours.index'));
        $this->assertDatabaseHas('parcours', [
            'nom' => 'Nouveau Parcours Test',
            'id_filiere' => $filiere->id,
            'frais_inscription' => 150000.00,
            'frais_formation' => 750000.00,
        ]);
    }
}
