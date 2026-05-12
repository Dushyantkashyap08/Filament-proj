<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get Admin role and assign all permissions to it
        $adminRole = Role::where('name', 'Admin')->first();
        if ($adminRole) {
            $adminRole->syncPermissions([
                'Add users',
                'Add Posts',
                'Edit Posts',
                'Delete Posts',
                'Add Categories',
                'Delete Categories',
                'View Posts',
                'Delete Users',
            ]);
        }

        // Get Customer role and assign specific permissions
        $customerRole = Role::where('name', 'Customer')->first();
        if ($customerRole) {
            $customerRole->syncPermissions([
                'Add Posts',
                'Edit Posts',
                'View Posts',
            ]);
        }

        // Get users by ID
        $adminUser = User::find(1); // Admin1
        $dushyantUser = User::find(2); // dushyant
        $aitayUser = User::find(3); // Aitay

        // For Admin user (user_id = 1):
        if ($adminUser) {
            // Assign direct permissions
            $adminUser->givePermissionTo(['Add users', 'Delete Users']);
            // Assign Admin role
            $adminUser->assignRole('Admin');
        }

        // For dushyant (user_id = 2):
        if ($dushyantUser) {
            // Assign Customer role
            $dushyantUser->assignRole('Customer');
            // Assign "Add Categories" permission directly
            $dushyantUser->givePermissionTo('Add Categories');
        }

        // For Aitay (user_id = 3):
        if ($aitayUser) {
            // Assign Customer role
            $aitayUser->assignRole('Customer');
            // Assign "Add Categories" permission directly
            $aitayUser->givePermissionTo('Add Categories');
        }
    }
}
