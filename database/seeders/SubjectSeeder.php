<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Support\Str;

class SubjectSeeder extends Seeder
{
    public function run(): void
    {
        // Lista de matérias padrão + professores
        $defaultSubjects = [
            [
                'subject_name' => 'Matemática',
                'teacher_name' => 'Carlos Silva',
                'cpf' => '11111111111',
            ],
            [
                'subject_name' => 'Português',
                'teacher_name' => 'Ana Souza',
                'cpf' => '22222222222',
            ],
            [
                'subject_name' => 'História',
                'teacher_name' => 'Marcos Lima',
                'cpf' => '33333333333',
            ],
            [
                'subject_name' => 'Geografia',
                'teacher_name' => 'Luciana Alves',
                'cpf' => '5555555555',
            ],
            [
                'subject_name' => 'Química',
                'teacher_name' => 'Larissa Gonçalves',
                'cpf' => '66666666666',
            ],
            [
                'subject_name' => 'Física',
                'teacher_name' => 'Junior Sombra',
                'cpf' => '77777777777',
            ],
            [
                'subject_name' => 'Biologia',
                'teacher_name' => 'Victor Bruno',
                'cpf' => '88888888888',
            ],
            [
                'subject_name' => 'Ciências',
                'teacher_name' => 'Fabiana Amorim',
                'cpf' => '99999999999',
            ],
            [
                'subject_name' => 'Religião',
                'teacher_name' => 'Tatiane Lima',
                'cpf' => '12345678901',
            ],
            [
                'subject_name' => 'Educação Física',
                'teacher_name' => 'Marcos Sombra',
                'cpf' => '23456789012',
            ],
            [
                'subject_name' => 'Artes',
                'teacher_name' => 'Marcos Sombra',
                'cpf' => '34567890123',
            ],
            [
                'subject_name' => 'Inglês',
                'teacher_name' => 'Marcos Sombra',
                'cpf' => '12345678902',
            ],
        ];

        foreach ($defaultSubjects as $data) {
            // Cria professor se não existir
         
            $teacher = Teacher::firstOrCreate(
                ['cpf' => $data['cpf']], // busca por CPF (único)
                [
                    'name' => $data['teacher_name'],
                    'birth_date' => '1980-01-01',
                    'email' => strtolower(Str::slug($data['teacher_name'], '.')) . rand(100, 999) . '@escola.com', // e-mail único
                    'phone' => '1199' . rand(1000000, 9999999),
                    'address' => 'Rua Exemplo, 123',
                    'hire_date' => now()->subYears(5),
                    'status' => 'active',
                    'qualification' => 'Licenciatura em Educação',
                ]
            );

            $asciiName = Str::ascii($data['subject_name']); // remove acentos: "Química" → "Quimica"

            Subject::firstOrCreate(
                ['name' => $data['subject_name']],
                [
                    'teacher_id' => $teacher->id,
                    'is_default' => true,
                    'code' => strtoupper(substr($asciiName, 0, 3)) . rand(100, 999), // gera código sem acento
                    'workload' => 40,
                    'grade_level' => '9 Ano', // sem "º"
                    'status' => 'active',
                ]
            );
        }
    }
}
