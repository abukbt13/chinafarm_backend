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
            ['email' => 'chinafarm01@gmail.com'],
            [
                'name' => 'China Farm 01',
                'password' => Hash::make('2025@YearOfProgress'), // change later
            ]
        );

        // Assign the role
        $admin->assignRole($adminRole);

        echo "✅ Admin user chinafarm01 created successfully.\n";
        echo "🔑 Email: chinafarm01@gmail.com | Password: 2025@YearOfProgress\n";
    }
}
