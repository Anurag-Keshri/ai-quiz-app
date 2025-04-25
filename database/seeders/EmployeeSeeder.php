<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('employees')->insert([
            [
                'name' => 'John Doe',
                'department' => 'Engineering',
                'salary' => 75000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Jane Smith',
                'department' => 'Human Resources',
                'salary' => 60000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Alice Johnson',
                'department' => 'Finance',
                'salary' => 80000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Bob Brown',
                'department' => 'Marketing',
                'salary' => 55000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
