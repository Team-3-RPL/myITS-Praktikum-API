<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Department;
use App\Models\Practicum;
use App\Models\Activity;
use App\Models\Submission;
use App\Models\Attachment;

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
        User::create([
            'nrp' => '5023241068',
            'name' => 'Agus Asdos',
            'email' => 'agus@example.com',
            'password' => bcrypt('password'),
            'role' => 'assistant',
            'department_id' => $dept->id,
        ]);
        $practicum = Practicum::create([
            'name' => 'Sistem Operasi',
            'department_id' => $dept->id,
        ]);
        $activity = Activity::create([
            'name' => 'Praktikum 1',
            'activity_type' => 'practicum',
            'has_submission' => true,
            'start_time' => now(),
            'end_time' => now()->addDays(7),
            'description' => 'Praktikum pertama',
            'location' => 'Online',
            'practicum_id' => $practicum->id,
        ]);
        Attachment::create([
            'filename' => 'test1.docx',
            'activity_id' => $activity->id,
        ]);
        Attachment::create([
            'filename' => 'test2.docx',
            'activity_id' => $activity->id,
        ]);
    }
}
