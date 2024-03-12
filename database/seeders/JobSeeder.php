<?php

namespace Database\Seeders;

use App\Models\Job;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Job::create([
            'job_name' => 'Software Engineer',
            'status' => 'active',
        ]);
        
        Job::create([
            'job_name' => 'Data Analyst',
            'status' => 'active',
        ]);
        
        Job::create([
            'job_name' => 'Marketing Manager',
            'status' => 'inactive',
        ]);
        
        Job::create([
            'job_name' => 'Graphic Designer',
            'status' => 'active',
        ]);
        
        Job::create([
            'job_name' => 'Sales Representative',
            'status' => 'active',
        ]);
    }
}
