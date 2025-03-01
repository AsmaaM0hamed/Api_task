<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {

        for ($i = 1; $i <= 2; $i++) {
            User::create([
                'name' => "Manager {$i}",
                'email' => "manager{$i}@example.com",
                'password' => Hash::make('12345678'),
                'type' => 'manager'
            ]);
        }


        for ($i = 1; $i <= 8; $i++) {
            User::create([
                'name' => "Employee {$i}",
                'email' => "employee{$i}@example.com",
                'password' => Hash::make('12345678'),
                'type' => 'user'
            ]);
        }
    }
}
