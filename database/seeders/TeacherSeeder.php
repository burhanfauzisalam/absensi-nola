<?php

namespace Database\Seeders;

use App\Models\Teacher;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TeacherSeeder extends Seeder
{
    public function run()
    {
        Teacher::create([
            'nama' => 'Teacher 1',
            'username' => 'teacher1',
            'email' => 'teacher1@mail.com',
            'gender' => 'male',
            'password' => Hash::make('teacher1'),
        ]);
    }
}
