<?php

namespace Database\Seeders;

use App\Enums\ModalidadEnum;
use App\Enums\DiaSemanaEnum;
use App\Models\Course;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Inscription;
use Illuminate\Support\Facades\Hash;

class CoursesAndInscriptionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear 10 cursos variados
        $courses = [
            [
                'nombre' => 'Programación Web con Laravel',
                'descripcion' => 'Aprende a crear aplicaciones web con Laravel.',
                'fecha_inicio' => '2025-07-10',
                'fecha_fin' => '2025-09-10',
                'fecha_limite_inscripcion' => '2025-07-05',
                'cupo' => 10,
                'costo_inscripcion' => 50.00,
                'costo_mensual' => 150.00,
                'horario' => ['19:00-21:00'],
                'modalidad' => ModalidadEnum::PRESENCIAL->value,
                'dias' => [DiaSemanaEnum::LUNES->value, DiaSemanaEnum::MIERCOLES->value],
            ],
            [
                'nombre' => 'Introducción a Python',
                'descripcion' => 'Curso básico de programación con Python.',
                'fecha_inicio' => '2025-08-01',
                'fecha_fin' => '2025-10-01',
                'fecha_limite_inscripcion' => '2025-07-25',
                'cupo' => 8,
                'costo_inscripcion' => 40.00,
                'costo_mensual' => 120.00,
                'horario' => ['18:00-20:00'],
                'modalidad' => ModalidadEnum::VIRTUAL->value,
                'dias' => [DiaSemanaEnum::MARTES->value, DiaSemanaEnum::JUEVES->value],
            ],
            [
                'nombre' => 'Data Science con R',
                'descripcion' => 'Análisis de datos con R.',
                'fecha_inicio' => '2025-07-20',
                'fecha_fin' => '2025-09-20',
                'fecha_limite_inscripcion' => '2025-07-15',
                'cupo' => 6,
                'costo_inscripcion' => 45.00,
                'costo_mensual' => 140.00,
                'horario' => ['20:00-22:00'],
                'modalidad' => ModalidadEnum::HIBRIDA->value,
                'dias' => [DiaSemanaEnum::MIERCOLES->value, DiaSemanaEnum::VIERNES->value],
            ],
            [
                'nombre' => 'Marketing Digital',
                'descripcion' => 'Promoción de productos en internet.',
                'fecha_inicio' => '2025-08-05',
                'fecha_fin' => '2025-10-05',
                'fecha_limite_inscripcion' => '2025-07-30',
                'cupo' => 12,
                'costo_inscripcion' => 60.00,
                'costo_mensual' => 180.00,
                'horario' => ['19:30-21:30'],
                'modalidad' => ModalidadEnum::VIRTUAL->value,
                'dias' => [DiaSemanaEnum::JUEVES->value],
            ],
            [
                'nombre' => 'Fotografía Digital',
                'descripcion' => 'Curso de técnicas de fotografía.',
                'fecha_inicio' => '2025-07-25',
                'fecha_fin' => '2025-09-25',
                'fecha_limite_inscripcion' => '2025-07-20',
                'cupo' => 5,
                'costo_inscripcion' => 35.00,
                'costo_mensual' => 100.00,
                'horario' => ['17:00-19:00'],
                'modalidad' => ModalidadEnum::PRESENCIAL->value,
                'dias' => [DiaSemanaEnum::SABADO->value],
            ],
            [
                'nombre' => 'Diseño UX/UI',
                'descripcion' => 'Fundamentos de UX y UI.',
                'fecha_inicio' => '2025-08-10',
                'fecha_fin' => '2025-10-10',
                'fecha_limite_inscripcion' => '2025-08-05',
                'cupo' => 7,
                'costo_inscripcion' => 55.00,
                'costo_mensual' => 160.00,
                'horario' => ['18:30-20:30'],
                'modalidad' => ModalidadEnum::HIBRIDA->value,
                'dias' => [DiaSemanaEnum::MARTES->value, DiaSemanaEnum::VIERNES->value],
            ],
            [
                'nombre' => 'Inglés Básico',
                'descripcion' => 'Curso introductorio de inglés.',
                'fecha_inicio' => '2025-07-15',
                'fecha_fin' => '2025-09-15',
                'fecha_limite_inscripcion' => '2025-07-10',
                'cupo' => 15,
                'costo_inscripcion' => 30.00,
                'costo_mensual' => 90.00,
                'horario' => ['17:30-19:30'],
                'modalidad' => ModalidadEnum::PRESENCIAL->value,
                'dias' => [DiaSemanaEnum::LUNES->value, DiaSemanaEnum::MIERCOLES->value],
            ],
            [
                'nombre' => 'Excel Avanzado',
                'descripcion' => 'Automatización y análisis con Excel.',
                'fecha_inicio' => '2025-07-22',
                'fecha_fin' => '2025-09-22',
                'fecha_limite_inscripcion' => '2025-07-17',
                'cupo' => 9,
                'costo_inscripcion' => 25.00,
                'costo_mensual' => 80.00,
                'horario' => ['18:00-20:00'],
                'modalidad' => ModalidadEnum::VIRTUAL->value,
                'dias' => [DiaSemanaEnum::MARTES->value],
            ],
            [
                'nombre' => 'Redacción Creativa',
                'descripcion' => 'Desarrollo de habilidades de escritura.',
                'fecha_inicio' => '2025-08-15',
                'fecha_fin' => '2025-10-15',
                'fecha_limite_inscripcion' => '2025-08-10',
                'cupo' => 8,
                'costo_inscripcion' => 40.00,
                'costo_mensual' => 110.00,
                'horario' => ['19:00-21:00'],
                'modalidad' => ModalidadEnum::HIBRIDA->value,
                'dias' => [DiaSemanaEnum::JUEVES->value],
            ],
            [
                'nombre' => 'Gestión de Proyectos',
                'descripcion' => 'Planificación y gestión de proyectos.',
                'fecha_inicio' => '2025-07-28',
                'fecha_fin' => '2025-09-28',
                'fecha_limite_inscripcion' => '2025-07-23',
                'cupo' => 10,
                'costo_inscripcion' => 50.00,
                'costo_mensual' => 130.00,
                'horario' => ['18:00-20:00'],
                'modalidad' => ModalidadEnum::PRESENCIAL->value,
                'dias' => [DiaSemanaEnum::LUNES->value],
            ],
        ];

        $createdCourses = [];
        foreach ($courses as $courseData) {
            $courseData['horario'] = json_encode($courseData['horario']);
            $courseData['dias'] = json_encode($courseData['dias']);
            $createdCourses[] = Course::create($courseData);
        }

        // Crear 20 estudiantes de ejemplo
        for ($i = 1; $i <= 20; $i++) {
            $student = User::create([
                'role' => 'student',
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

            // Inscribirlos en cursos aleatorios
            $course = $createdCourses[array_rand($createdCourses)];
            $student->cursos()->attach($course->codigo, [
                'fecha_inscripcion' => now()->subDays(rand(1, 10)),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->command->info('✅ Se crearon 10 cursos, 20 estudiantes y se realizaron inscripciones.');
    }
}
