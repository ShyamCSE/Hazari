<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin
        $admin = User::create([
            'name' => 'Hazari Admin',
            'email' => 'admin@hazari.com',
            'password' => Hash::make('password'), // 🔒 Use env('DEFAULT_PASSWORD') if needed
            'country_code' => '+91',
            'mobile' => '9999999999',
            'status' => true,
            'type' => 1, // 1 = admin
        ]);

        // Create Users under this Admin
        User::create([
            'name' => 'John Doe',
            'email' => 'john@hazari.com',
            'password' => Hash::make('password'),
            'country_code' => '+91',
            'mobile' => '8888888888',
            'status' => true,
            'type' => 0, // 0 = user
            'admin_id' => $admin->id,
        ]);

        User::create([
            'name' => 'Jane Smith',
            'email' => 'jane@hazari.com',
            'password' => Hash::make('password'),
            'country_code' => '+91',
            'mobile' => '7777777777',
            'status' => false,
            'type' => 0,
            'admin_id' => $admin->id,
        ]);
    }
}
