@extends('estructuras.appAlumnos')

@section('tittle', 'AureaCursos - Inicio')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/inicios.css') }}">
@endpush

@section('contenido')
    <main class="max-w-6xl mx-auto bg-white p-8 rounded-xl shadow-2xl">
        <h1 class="text-3xl font-bold text-center text-purple-800 mb-8">Mis Cursos</h1>

        <div id="messageContainer" class="mt-4 p-3 rounded-lg text-center font-medium hidden"></div>

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
        let studentCourses = [ // Cambiado a 'let' para permitir la modificación
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
        const messageContainer = document.getElementById('messageContainer'); // Referencia al contenedor de mensajes

        // Función para mostrar mensajes (éxito o error)
        function showMessage(msg, type) {
            messageContainer.textContent = msg;
            messageContainer.classList.remove('hidden', 'bg-green-100', 'text-green-700', 'bg-red-100', 'text-red-700');
            if (type === 'success') {
                messageContainer.classList.add('bg-green-100', 'text-green-700');
            } else if (type === 'error') {
                messageContainer.classList.add('bg-red-100', 'text-red-700');
            }
            setTimeout(() => {
                messageContainer.classList.add('hidden');
            }, 3000);
        }

        // Función para dar de baja un curso
        function unsubscribeCourse(courseId) {
            const initialLength = studentCourses.length;
            studentCourses = studentCourses.filter(course => course.id !== courseId);
            if (studentCourses.length < initialLength) {
                showMessage('Curso dado de baja exitosamente.', 'success');
                renderStudentCourses(); // Volver a renderizar la lista de cursos
            } else {
                showMessage('Error al dar de baja el curso.', 'error');
            }
        }

        // Función para renderizar los cursos del alumno
        function renderStudentCourses() {
            myCoursesContainer.innerHTML = ''; // Limpiar el contenedor antes de renderizar

            if (studentCourses.length === 0) {
                noCoursesMessage.classList.remove('hidden');
            } else {
                noCoursesMessage.classList.add('hidden');
                studentCourses.forEach(course => {
                    const courseCard = document.createElement('div');
                    courseCard.className = 'bg-purple-700 p-6 rounded-lg shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border border-purple-600';
                    
                    courseCard.innerHTML = `
                        <img src="${course.imageUrl}" alt="Imagen del curso ${course.title}" class="w-full h-40 object-cover rounded-md mb-4">
                        <h3 class="text-xl font-semibold text-white mb-2">${course.title}</h3>
                        <p class="text-purple-100 text-sm mb-3">${course.description}</p>
                        <p class="text-white text-sm mb-2">Instructor: <span class="font-medium">${course.instructor}</span></p>
                        <p class="text-white text-sm mb-2">Inicio: <span class="font-medium">${course.startDate}</span></p>
                        <p class="text-white text-sm mb-2">Fin: <span class="font-medium">${course.endDate}</span></p>
                        <p class="text-white text-sm mb-2">Días y Horarios: <span class="font-medium">${course.daysAndTimes}</span></p>
                        <p class="text-white text-sm mb-4">Modalidad: <span class="font-medium">${course.modality}</span></p>
                        
                        <button
                            data-id="${course.id}"
                            class="unsubscribe-btn w-full bg-red-600 text-white py-2 rounded-lg font-semibold hover:bg-red-700 transition duration-300 ease-in-out transform hover:scale-105 shadow-md focus:outline-none focus:ring-4 focus:ring-red-500 focus:ring-opacity-50 mt-2"
                        >
                            Dar de Baja Curso
                        </button>
                    `;
                    myCoursesContainer.appendChild(courseCard);
                });

                // Añadir event listeners a los botones de "Dar de Baja" después de renderizar
                document.querySelectorAll('.unsubscribe-btn').forEach(button => {
                    button.addEventListener('click', (e) => {
                        const courseId = e.currentTarget.dataset.id;
                        unsubscribeCourse(courseId);
                    });
                });
            }
        }

        // Renderizar los cursos cuando el DOM esté completamente cargado
        document.addEventListener('DOMContentLoaded', renderStudentCourses);
    </script>
@endpush