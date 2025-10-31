<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subject;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $materiasPadrao = [
            'Matemática',
            'Português',
            'História',
            'Geografia',
            'Ciências',
            'Inglês',
            'Educação Física',
            'Artes',
            'Ensino Religioso'
        ];

        foreach ($materiasPadrao as $nome) {
            Subject::firstOrCreate(['name' => $nome]);
        }
    }
}
