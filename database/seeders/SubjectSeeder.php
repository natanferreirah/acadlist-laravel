<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    public function run(): void
    {   
        Subject::create([
            'name' => 'Matemática',
            'code' => 'MAT01',
            'workload' => 40,
            'department' => 'Exatas',
            'status' => 'active',
        ]);
        // Adicione mais
    }
}
