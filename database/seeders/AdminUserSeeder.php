<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        // Create the admin user
        $admin = User::firstOrCreate(
            ['email' => 'nikol@gmail.com'],
            [
                'name' => 'Nikola',
                'password' => Hash::make('password123'), // change later
            ]
        );

        // Assign the role
        $admin->assignRole($adminRole);

        echo "✅ Admin user Nikola created successfully.\n";
        echo "🔑 Email: nikol@gmail.com | Password: password123\n";
    }
}
