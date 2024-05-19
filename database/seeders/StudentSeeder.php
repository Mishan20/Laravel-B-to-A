<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Student;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         Student::factory(100)->create();
        // for ($i = 0; $i < 10; $i++) {
        //     $student = new Student();

        //     $student->name = 'John';
        //     $student->email = 'j@j.com';
        //     $student->phone = '1234567890';
        //     $student->status= 2;
        //     $student->save();
        // }
        
    }
}
