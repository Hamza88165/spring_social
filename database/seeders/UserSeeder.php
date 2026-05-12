<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Admin;
use App\Models\Employee;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin
        $adminUser = User::create([
            'full_name' => 'Admin AYMD',
            'email'     => 'admin@aymd.com',
            'password'  => Hash::make('password'),
            'type'      => 'admin',
        ]);

        Admin::create([
            'user_id'     => $adminUser->id,
            'permissions' => 'all',
            'last_login'  => now(),
        ]);

        // Create Employee 1
        $emp1 = User::create([
            'full_name' => 'Mahmoud Benjelloun',
            'email'     => 'mahmoud@aymd.com',
            'password'  => Hash::make('password'),
            'type'      => 'employee',
        ]);

        Employee::create([
            'user_id'    => $emp1->id,
            'department' => 'Social Media',
            'phone'      => '0612345678',
        ]);

        // Create Employee 2
        $emp2 = User::create([
            'full_name' => 'Employé Deux',
            'email'     => 'emp2@aymd.com',
            'password'  => Hash::make('password'),
            'type'      => 'employee',
        ]);

        Employee::create([
            'user_id'    => $emp2->id,
            'department' => 'Design',
            'phone'      => '0698765432',
        ]);
    }
}