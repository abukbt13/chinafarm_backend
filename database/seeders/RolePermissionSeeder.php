<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
     public function run(): void
    {
        // Clear cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // ===== Define Permissions =====
        $permissions = [
            // Posts
            'create_posts',
            'edit_posts',
            'delete_posts',
            'view_posts',

            // Farmers
            'create_farmers',
            'edit_farmers',
            'delete_farmers',
            'view_farmers',

            // Expenses
            'create_expenses',
            'edit_expenses',
            'delete_expenses',
            'view_expenses',
        ];

        // Create permissions if not exist
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // ===== Create Roles =====
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $farmer = Role::firstOrCreate(['name' => 'farmer']);

        // ===== Assign Permissions to Roles =====
        // Admin gets everything
        $admin->givePermissionTo(Permission::all());

        // Farmer gets only limited permissions
        $farmerPermissions = [
            'create_posts',
            'edit_posts',
            'view_posts',
            'view_farmers',
        ];
        $farmer->givePermissionTo($farmerPermissions);

        // Refresh cache
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        echo "Roles and Permissions seeded successfully.\n";
    }
}
