@extends('estructuras.appAlumnos')

@section('tittle', 'AureaCursos - Inicio')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/inicios.css') }}">
@endpush

@section('contenido')
    <main class="max-w-6xl mx-auto bg-white p-8 rounded-xl shadow-2xl">
        <h1 class="text-3xl font-bold text-center text-purple-800 mb-8">Mis Cursos</h1>

        <section id="myCoursesContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Los cursos se cargarán aquí con JavaScript -->
        </section>

        <p id="noCoursesMessage" class="text-center text-gray-500 mt-8 hidden">Actualmente no estás inscrito en ningún curso.</p>
    </main>
@endsection

@push('scripts')
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script>
        // Datos simulados de los cursos del alumno
        const studentCourses = [
            {
                id: 'course1',
                title: 'Desarrollo Web Full Stack',
                description: 'Aprende a construir aplicaciones web completas desde cero, desde el front-end al back-end.',
                startDate: '01/08/2024',
                endDate: '01/12/2024',
                daysAndTimes: 'Martes y Jueves, 18:00 - 20:00 hs',
                modality: 'Online Sincrónico',
                instructor: 'Prof. Ana García',
                imageUrl: 'https://placehold.co/400x200/5a2d8a/ffffff?text=Web+Dev' // Violeta oscuro
            },
            {
                id: 'course2',
                title: 'Diseño Gráfico Profesional',
                description: 'Domina herramientas y principios de diseño para proyectos creativos e impactantes.',
                startDate: '15/09/2024',
                endDate: '15/01/2025',
                daysAndTimes: 'Lunes y Miércoles, 10:00 - 12:00 hs',
                modality: 'Presencial',
                instructor: 'Prof. Carlos Ruíz',
                imageUrl: 'https://placehold.co/400x200/6a3d9a/ffffff?text=Dise%C3%B1o' // Violeta oscuro
            },
            {
                id: 'course3',
                title: 'Introducción a la Inteligencia Artificial',
                description: 'Explora los fundamentos de la IA, algoritmos de aprendizaje automático y sus aplicaciones prácticas.',
                startDate: '01/10/2024',
                endDate: '01/02/2025',
                daysAndTimes: 'Viernes, 16:00 - 19:00 hs',
                modality: 'Híbrida',
                instructor: 'Dr. Laura Méndez',
                imageUrl: 'https://placehold.co/400x200/7a4dAA/ffffff?text=IA' // Violeta oscuro
            },
            {
                id: 'course4',
                title: 'Marketing Digital Estratégico',
                description: 'Desarrolla habilidades para planificar y ejecutar campañas de marketing online exitosas y medibles.',
                startDate: '01/11/2024',
                endDate: '01/03/2025',
                daysAndTimes: 'Sábados, 09:00 - 13:00 hs',
                modality: 'Online Asincrónico',
                instructor: 'Mtro. Pablo Castro',
                imageUrl: 'https://placehold.co/400x200/8a5dBb/ffffff?text=Marketing' // Violeta oscuro
            }
        ];

        const myCoursesContainer = document.getElementById('myCoursesContainer');
        const noCoursesMessage = document.getElementById('noCoursesMessage');

        // Función para renderizar los cursos del alumno
        function renderStudentCourses() {
            myCoursesContainer.innerHTML = ''; // Limpiar el contenedor antes de renderizar

            if (studentCourses.length === 0) {
                noCoursesMessage.classList.remove('hidden');
            } else {
                noCoursesMessage.classList.add('hidden');
                studentCourses.forEach(course => {
                    const courseCard = document.createElement('div');
                    // Cambiado de bg-purple-50 a bg-purple-700 para el color oscuro
                    // Cambiado border-purple-200 a border-purple-600 para un borde más oscuro
                    courseCard.className = 'bg-purple-700 p-6 rounded-lg shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border border-purple-600';
                    
                    courseCard.innerHTML = `
                        <img src="${course.imageUrl}" alt="Imagen del curso ${course.title}" class="w-full h-40 object-cover rounded-md mb-4">
                        <h3 class="text-xl font-semibold text-white mb-2">${course.title}</h3> <!-- Texto blanco para contraste -->
                        <p class="text-purple-100 text-sm mb-3">${course.description}</p> <!-- Tono más claro de violeta para descripción -->
                        <p class="text-white text-sm mb-2">Instructor: <span class="font-medium">${course.instructor}</span></p>
                        <p class="text-white text-sm mb-2">Inicio: <span class="font-medium">${course.startDate}</span></p>
                        <p class="text-white text-sm mb-2">Fin: <span class="font-medium">${course.endDate}</span></p>
                        <p class="text-white text-sm mb-2">Días y Horarios: <span class="font-medium">${course.daysAndTimes}</span></p>
                        <p class="text-white text-sm mb-4">Modalidad: <span class="font-medium">${course.modality}</span></p>
                        
                        <!-- La sección de progreso ha sido eliminada -->

                        <button
                            class="w-full bg-purple-800 text-white py-2 rounded-lg font-semibold hover:bg-purple-900 transition duration-300 ease-in-out transform hover:scale-105 shadow-md focus:outline-none focus:ring-4 focus:ring-purple-500 focus:ring-opacity-50"
                        >
                            Ir al Curso
                        </button>
                    `;
                    myCoursesContainer.appendChild(courseCard);
                });
            }
        }

        // Renderizar los cursos cuando el DOM esté completamente cargado
        document.addEventListener('DOMContentLoaded', renderStudentCourses);
    </script>
@endpush
