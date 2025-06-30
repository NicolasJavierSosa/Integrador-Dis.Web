<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Course;
use App\Models\Inscription;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class CoursesAndInscriptionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear 5 cursos
        $courses = [
            [
                'name' => 'Programación Web con Laravel',
                'description' => 'Aprende a desarrollar aplicaciones web modernas con Laravel Framework',
                'category' => 'Desarrollo Web',
                'owner' => 'Prof. Juan Pérez',
                'begin_date' => '2025-07-15',
                'end_date' => '2025-09-15',
                'insc_date_limit' => '2025-07-10',
                'quota' => 6,
                'mode' => 'Presencial',
                'insc_cost' => 50.00,
                'month_cost' => 150.00,
                'schedule' => json_encode(['19:00-21:00']),
                'days' => json_encode(['Lunes', 'Miércoles'])
            ],
            [
                'name' => 'Diseño UX/UI',
                'description' => 'Fundamentos del diseño de experiencia e interfaz de usuario',
                'category' => 'Diseño',
                'owner' => 'Prof. Ana García',
                'begin_date' => '2025-08-01',
                'end_date' => '2025-10-01',
                'insc_date_limit' => '2025-07-25',
                'quota' => 5,
                'mode' => 'Virtual',
                'insc_cost' => 30.00,
                'month_cost' => 120.00,
                'schedule' => json_encode(['18:00-20:00']),
                'days' => json_encode(['Martes', 'Jueves'])
            ],
            [
                'name' => 'Marketing Digital',
                'description' => 'Estrategias de marketing en el mundo digital',
                'category' => 'Marketing',
                'owner' => 'Prof. Carlos Mendoza',
                'begin_date' => '2025-07-20',
                'end_date' => '2025-09-20',
                'insc_date_limit' => '2025-07-15',
                'quota' => 4,
                'mode' => 'Híbrida',
                'insc_cost' => 40.00,
                'month_cost' => 130.00,
                'schedule' => json_encode(['19:30-21:30']),
                'days' => json_encode(['Lunes', 'Viernes'])
            ],
            [
                'name' => 'Análisis de Datos con Python',
                'description' => 'Introducción al análisis de datos usando Python y pandas',
                'category' => 'Data Science',
                'owner' => 'Prof. María Rodriguez',
                'begin_date' => '2025-08-05',
                'end_date' => '2025-10-05',
                'insc_date_limit' => '2025-07-30',
                'quota' => 3,
                'mode' => 'Virtual',
                'insc_cost' => 45.00,
                'month_cost' => 140.00,
                'schedule' => json_encode(['20:00-22:00']),
                'days' => json_encode(['Miércoles', 'Sábado'])
            ],
            [
                'name' => 'Fotografía Digital',
                'description' => 'Técnicas profesionales de fotografía digital',
                'category' => 'Arte',
                'owner' => 'Prof. Luis Torres',
                'begin_date' => '2025-07-25',
                'end_date' => '2025-09-25',
                'insc_date_limit' => '2025-07-20',
                'quota' => 2,
                'mode' => 'Presencial',
                'insc_cost' => 35.00,
                'month_cost' => 110.00,
                'schedule' => json_encode(['17:00-19:00']),
                'days' => json_encode(['Jueves', 'Domingo'])
            ]
        ];

        $createdCourses = [];
        foreach ($courses as $courseData) {
            $createdCourses[] = Course::create($courseData);
        }

        // Crear 20 estudiantes
        $students = [
            ['dni' => '12345670', 'name' => 'María', 'surname' => 'González', 'email' => 'maria.gonzalez@email.com', 'gender' => 'Femenino', 'birth_date' => '1995-03-15'],
            ['dni' => '23456789', 'name' => 'Juan', 'surname' => 'López', 'email' => 'juan.lopez@email.com', 'gender' => 'Masculino', 'birth_date' => '1992-07-22'],
            ['dni' => '34567890', 'name' => 'Ana', 'surname' => 'Martín', 'email' => 'ana.martin@email.com', 'gender' => 'Femenino', 'birth_date' => '1998-11-03'],
            ['dni' => '45678901', 'name' => 'Pedro', 'surname' => 'Sánchez', 'email' => 'pedro.sanchez@email.com', 'gender' => 'Masculino', 'birth_date' => '1990-09-18'],
            ['dni' => '56789012', 'name' => 'Laura', 'surname' => 'Fernández', 'email' => 'laura.fernandez@email.com', 'gender' => 'Femenino', 'birth_date' => '1997-01-25'],
            ['dni' => '67890123', 'name' => 'Carlos', 'surname' => 'Ruiz', 'email' => 'carlos.ruiz@email.com', 'gender' => 'Masculino', 'birth_date' => '1993-05-12'],
            ['dni' => '78901234', 'name' => 'Sofía', 'surname' => 'Moreno', 'email' => 'sofia.moreno@email.com', 'gender' => 'Femenino', 'birth_date' => '1996-08-07'],
            ['dni' => '89012345', 'name' => 'Diego', 'surname' => 'Jiménez', 'email' => 'diego.jimenez@email.com', 'gender' => 'Masculino', 'birth_date' => '1994-12-30'],
            ['dni' => '90123456', 'name' => 'Elena', 'surname' => 'Herrera', 'email' => 'elena.herrera@email.com', 'gender' => 'Femenino', 'birth_date' => '1999-04-14'],
            ['dni' => '01234567', 'name' => 'Miguel', 'surname' => 'Castro', 'email' => 'miguel.castro@email.com', 'gender' => 'Masculino', 'birth_date' => '1991-10-08'],
            ['dni' => '11234567', 'name' => 'Carmen', 'surname' => 'Vega', 'email' => 'carmen.vega@email.com', 'gender' => 'Femenino', 'birth_date' => '1995-06-21'],
            ['dni' => '21234567', 'name' => 'Alejandro', 'surname' => 'Ramos', 'email' => 'alejandro.ramos@email.com', 'gender' => 'Masculino', 'birth_date' => '1992-02-17'],
            ['dni' => '31234567', 'name' => 'Lucía', 'surname' => 'Ortega', 'email' => 'lucia.ortega@email.com', 'gender' => 'Femenino', 'birth_date' => '1998-09-05'],
            ['dni' => '41234567', 'name' => 'Roberto', 'surname' => 'Silva', 'email' => 'roberto.silva@email.com', 'gender' => 'Masculino', 'birth_date' => '1990-01-13'],
            ['dni' => '51234567', 'name' => 'Patricia', 'surname' => 'Mendez', 'email' => 'patricia.mendez@email.com', 'gender' => 'Femenino', 'birth_date' => '1997-07-28'],
            ['dni' => '61234567', 'name' => 'Fernando', 'surname' => 'Cruz', 'email' => 'fernando.cruz@email.com', 'gender' => 'Masculino', 'birth_date' => '1993-11-16'],
            ['dni' => '71234567', 'name' => 'Raquel', 'surname' => 'Delgado', 'email' => 'raquel.delgado@email.com', 'gender' => 'Femenino', 'birth_date' => '1996-03-09'],
            ['dni' => '81234567', 'name' => 'Andrés', 'surname' => 'Vargas', 'email' => 'andres.vargas@email.com', 'gender' => 'Masculino', 'birth_date' => '1994-05-24'],
            ['dni' => '91234567', 'name' => 'Beatriz', 'surname' => 'Flores', 'email' => 'beatriz.flores@email.com', 'gender' => 'Femenino', 'birth_date' => '1999-12-02'],
            ['dni' => '02234567', 'name' => 'Javier', 'surname' => 'Peña', 'email' => 'javier.pena@email.com', 'gender' => 'Masculino', 'birth_date' => '1991-08-11']
        ];

        $createdStudents = [];
        foreach ($students as $studentData) {
            $createdStudents[] = User::create([
                'role' => 'student',
                'dni' => $studentData['dni'],
                'name' => $studentData['name'],
                'surname' => $studentData['surname'],
                'gender' => $studentData['gender'],
                'birth_date' => $studentData['birth_date'],
                'email' => $studentData['email'],
                'address' => 'Dirección ejemplo',
                'phone' => '123456789',
                'password' => Hash::make('password123')
            ]);
        }

        // Distribuir estudiantes en cursos
        $courseDistribution = [
            0 => 6, // Laravel: 6 estudiantes
            1 => 5, // UX/UI: 5 estudiantes  
            2 => 4, // Marketing: 4 estudiantes
            3 => 3, // Python: 3 estudiantes
            4 => 2  // Fotografía: 2 estudiantes
        ];

        $studentIndex = 0;
        foreach ($courseDistribution as $courseIndex => $studentCount) {
            for ($i = 0; $i < $studentCount; $i++) {
                Inscription::create([
                    'user_id' => $createdStudents[$studentIndex]->id,
                    'course_id' => $createdCourses[$courseIndex]->id,
                    'inscripcion_date' => now()->subDays(rand(1, 30))
                ]);
                $studentIndex++;
            }
        }

        $this->command->info('✅ Creados 5 cursos y 20 estudiantes con sus inscripciones');
    }
}
