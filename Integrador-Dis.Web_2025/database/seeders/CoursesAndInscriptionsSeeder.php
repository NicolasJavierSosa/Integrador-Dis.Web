<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\User;
use App\Enums\ModalidadEnum;
use App\Enums\DiaSemanaEnum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CoursesAndInscriptionsSeeder extends Seeder
{
    public function run(): void
    {
        // === 1️⃣ Crear 10 cursos ===
        $courses = [
            [
                'nombre' => 'Programación Web con Laravel',
                'descripcion' => 'Aprende a crear aplicaciones web con Laravel.',
                'fecha_inicio' => '2025-07-10',
                'fecha_fin' => '2025-09-10',
                'fecha_limite_inscripcion' => '2025-07-05',
                'cupo' => 15,
                'horario' => json_encode([
                    ['day' => DiaSemanaEnum::LUNES->value, 'time' => '19:00-21:00'],
                    ['day' => DiaSemanaEnum::MIERCOLES->value, 'time' => '19:00-21:00'],
                ]),
                'modalidad' => ModalidadEnum::PRESENCIAL->value,
                'dias' => json_encode([
                    DiaSemanaEnum::LUNES->value,
                    DiaSemanaEnum::MIERCOLES->value,
                ]),
            ],
            [
                'nombre' => 'Introducción a Python',
                'descripcion' => 'Curso básico de programación con Python.',
                'fecha_inicio' => '2025-08-01',
                'fecha_fin' => '2025-10-01',
                'fecha_limite_inscripcion' => '2025-07-25',
                'cupo' => 12,
                'horario' => json_encode([
                    ['day' => DiaSemanaEnum::MARTES->value, 'time' => '18:00-20:00'],
                    ['day' => DiaSemanaEnum::JUEVES->value, 'time' => '18:00-20:00'],
                ]),
                'modalidad' => ModalidadEnum::VIRTUAL->value,
                'dias' => json_encode([
                    DiaSemanaEnum::MARTES->value,
                    DiaSemanaEnum::JUEVES->value,
                ]),
            ],
            // 🚩 Agrega más cursos aquí, mismo formato:
            [
                'nombre' => 'Diseño UX/UI',
                'descripcion' => 'Principios de experiencia de usuario.',
                'fecha_inicio' => '2025-09-01',
                'fecha_fin' => '2025-11-30',
                'fecha_limite_inscripcion' => '2025-08-28',
                'cupo' => 20,
                'horario' => json_encode([
                    ['day' => DiaSemanaEnum::VIERNES->value, 'time' => '17:00-19:00'],
                ]),
                'modalidad' => ModalidadEnum::HIBRIDA->value,
                'dias' => json_encode([
                    DiaSemanaEnum::VIERNES->value,
                ]),
            ],
            [
                'nombre' => 'Marketing Digital',
                'descripcion' => 'Estrategias de marketing en línea.',
                'fecha_inicio' => '2025-10-01',
                'fecha_fin' => '2025-12-01',
                'fecha_limite_inscripcion' => '2025-09-25',
                'cupo' => 25,
                'horario' => json_encode([
                    ['day' => DiaSemanaEnum::LUNES->value, 'time' => '18:00-20:00'],
                    ['day' => DiaSemanaEnum::MIERCOLES->value, 'time' => '18:00-20:00'],
                ]),
                'modalidad' => ModalidadEnum::VIRTUAL->value,
                'dias' => json_encode([
                    DiaSemanaEnum::LUNES->value,
                    DiaSemanaEnum::MIERCOLES->value,
                ]),
            ],
            [
                'nombre' => 'Bases de Datos con MySQL',
                'descripcion' => 'Aprende a manejar bases de datos relacionales.',
                'fecha_inicio' => '2025-07-15',
                'fecha_fin' => '2025-09-15',
                'fecha_limite_inscripcion' => '2025-07-10',
                'cupo' => 18,
                'horario' => json_encode([
                    ['day' => DiaSemanaEnum::MARTES->value, 'time' => '19:00-21:00'],
                    ['day' => DiaSemanaEnum::JUEVES->value, 'time' => '19:00-21:00'],
                ]),
                'modalidad' => ModalidadEnum::PRESENCIAL->value,
                'dias' => json_encode([
                    DiaSemanaEnum::MARTES->value,
                    DiaSemanaEnum::JUEVES->value,
                ]),
            ],
            [
                'nombre' => 'Bases de Datos con PostgreSQL',
                'descripcion' => 'Aprende a manejar bases de datos relacionales.',
                'fecha_inicio' => '2025-07-15',
                'fecha_fin' => '2025-09-15',
                'fecha_limite_inscripcion' => '2025-07-10',
                'cupo' => 18,
                'horario' => json_encode([
                    ['day' => DiaSemanaEnum::MARTES->value, 'time' => '19:00-21:00'],
                    ['day' => DiaSemanaEnum::JUEVES->value, 'time' => '19:00-21:00'],
                ]),
                'modalidad' => ModalidadEnum::PRESENCIAL->value,
                'dias' => json_encode([
                    DiaSemanaEnum::MARTES->value,
                    DiaSemanaEnum::JUEVES->value,
                ]),
            ],
        ];

        $createdCourses = [];
        foreach ($courses as $courseData) {
            $createdCourses[] = Course::create($courseData);
        }

        // === 2️⃣ Crear 30 alumnos ===
        for ($i = 1; $i <= 30; $i++) {
            $student = User::create([
                // Puedes quitar 'role' => 'student' si quieres
                'dni' => str_pad($i, 8, '0', STR_PAD_LEFT),
                'name' => "Alumno{$i}",
                'surname' => "Apellido{$i}",
                'gender' => $i % 2 === 0 ? 'Femenino' : 'Masculino',
                'birth_date' => '2000-01-01',
                'email' => "alumno{$i}@correo.com",
                'address' => 'Calle Falsa 123',
                'phone' => '123456789',
                'password' => Hash::make('password123'),
            ]);

            // Asignar rol correcto
            $student->assignRole('student');

            // Inscribirlo a 1-2 cursos aleatorios
            $selectedCourses = collect($createdCourses)->random(rand(1, 2));
            foreach ($selectedCourses as $course) {
                $student->cursos()->attach($course->codigo, [
                    'fecha_inscripcion' => now(),
                ]);
            }
        }


        // === 3️⃣ Crear 5 profesores ===
        for ($j = 1; $j <= 5; $j++) {
            $teacher = User::create([
                'role' => 'teacher', 
                'dni' => str_pad(9000 + $j, 8, '0', STR_PAD_LEFT),
                'name' => "Profesor{$j}",
                'surname' => "Apellido{$j}",
                'gender' => $j % 2 === 0 ? 'Femenino' : 'Masculino',
                'birth_date' => '1985-01-01',
                'email' => "profesor{$j}@correo.com",
                'address' => 'Calle Docente 456',
                'phone' => '987654321',
                'password' => Hash::make('password123'),
            ]);

            $teacher->assignRole('teacher'); 
        }

        $admin = User::create([
        'dni' => '77777777',
        'role' => 'admin',
        'name' => 'Admin',
        'surname' => 'Master',
        'gender' => 'Masculino',
        'birth_date' => '1990-01-01',
        'email' => 'admin@correo.com',
        'address' => 'Oficina Principal',
        'phone' => '111111111',
        'password' => Hash::make('admin123'), 
    ]);

    $admin->assignRole('admin');


        $this->command->info('✅ Se crearon cursos, 30 alumnos, 5 profesores e inscripciones aleatorias.');
    }
}