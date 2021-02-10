<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class EmployeesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Employees::insert([
            'developer'=>'Dev1',
            'sure'=>1,
            'zorluk'=>1,
            'calisan'=>1,
        ]);
        \App\Models\Employees::insert([
            'developer'=>'Dev2',
            'sure'=>1,
            'zorluk'=>2,
            'calisan'=>1,
        ]);
        \App\Models\Employees::insert([
            'developer'=>'Dev3',
            'sure'=>1,
            'zorluk'=>3,
            'calisan'=>1,
        ]);
        \App\Models\Employees::insert([
            'developer'=>'Dev4',
            'sure'=>1,
            'zorluk'=>4,
            'calisan'=>1,
        ]);
        \App\Models\Employees::insert([
            'developer'=>'Dev5',
            'sure'=>1,
            'zorluk'=>5,
            'calisan'=>1,
        ]);
        
    }
}
