<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Department;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $dept = Department::create([
            'name' => 'Teknik Informatika',
        ]);
        User::create([
            'nrp' => '5023241067',
            'name' => 'Admin Coordinator',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'coordinator',
            'department_id' => $dept->id,
        ]);
    }
}
