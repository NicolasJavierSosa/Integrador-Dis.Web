@extends('estructuras.app')
@section('tittle', 'AureaCursos - Inicio')
@push('css')
    <link rel="stylesheet" href="{{asset('css/inicios.css')}}" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f5f3ff; /* Very light lilac background */
        }
        .btn-primary {
            background-color: #8b5cf6; /* Deeper lilac */
            color: white;
            transition: background-color 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #7c3aed; /* Even deeper lilac on hover */
        }
        .modal-overlay {
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .modal-overlay.hidden {
            display: none;
        }
        .modal-overlay #modal-content {
            opacity: 0;
            transform: scale(0.95);
            transition: all 0.3s ease-out;
        }
        .modal-overlay.active #modal-content {
            opacity: 1;
            transform: scale(1);
        }
        /* Style for editable content */
        [contenteditable="true"] {
            outline: 2px dashed #a78bfa; /* Lilac dashed outline */
            padding: 4px;
            border-radius: 4px;
        }
        /* Style for hidden courses (admin view) */
        .course-card-hidden {
            opacity: 0.5;
            filter: blur(1px); /* Slightly blur the content */
        }
    </style>
@endpush

@section('contenido')
    <!-- aca el contenido para agregar -->
     <main class="flex-grow p-8 bg-gray-50 bg-opacity-50">
        <!-- Sección de Presentación -->
        <section id="presentation-section" class="mb-10 p-6 bg-purple-100 rounded-lg shadow-inner relative">
            <div class="flex justify-center items-center mb-4">
                <h1 id="presentation-title" class="text-4xl font-extrabold text-purple-800 text-center" contenteditable="false">¡Bienvenido a Instituto XXX!</h1>
                <!-- Pencil icon for presentation section -->
                <button id="edit-presentation-btn" class="ml-4 p-2 bg-purple-200 rounded-full hover:bg-purple-300 focus:outline-none edit-pencil hidden" onclick="toggleSectionEdit('presentation-section', ['presentation-title', 'presentation-description'])">
                    <svg class="w-5 h-5 text-purple-700" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.38-2.828-2.829z"></path>
                    </svg>
                </button>
            </div>
            <p id="presentation-description" class="text-lg text-purple-700 leading-relaxed text-center max-w-3xl mx-auto" contenteditable="false">
                Explora nuestra amplia variedad de cursos diseñados para potenciar tu futuro.
            </p>
            <button id="save-presentation-btn" class="btn-primary mt-4 py-2 px-4 rounded-lg hidden mx-auto block" onclick="toggleSectionEdit('presentation-section', ['presentation-title', 'presentation-description'])">
                Guardar Cambios
            </button>
        </section>

        <!-- Sección de Cursos -->
        <section id="courses-section">
            <div class="flex justify-center items-center mb-6">
                <h2 id="courses-title" class="text-3xl font-bold text-purple-800 text-center" contenteditable="false">Nuestros Cursos</h2>
                <!-- Pencil icon for courses section -->
                <button id="edit-courses-btn" class="ml-4 p-2 bg-purple-200 rounded-full hover:bg-purple-300 focus:outline-none edit-pencil hidden" onclick="toggleSectionEdit('courses-section', ['courses-title'])">
                    <svg class="w-5 h-5 text-purple-700" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.38-2.828-2.829z"></path>
                    </svg>
                </button>
            </div>
            <div id="course-list" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- JS cargará los cursos aquí -->
            </div>
            <button id="save-courses-btn" class="btn-primary mt-4 py-2 px-4 rounded-lg hidden mx-auto block" onclick="toggleSectionEdit('courses-section', ['courses-title'])">
                Guardar Cambios
            </button>
        </section>
    </main>
    <div id="course-modal" class="fixed inset-0 z-50 hidden modal-overlay">
        <div class="bg-white p-8 rounded-xl shadow-2xl max-w-lg w-full relative transform transition-all duration-300 scale-95 opacity-0" id="modal-content">
            <button onclick="closeModal()" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 text-3xl font-semibold">&times;</button>
            <h3 id="modal-title" class="text-3xl font-bold text-purple-800 mb-4"></h3>
            <p id="modal-description" class="text-gray-700 mb-4 leading-relaxed"></p>
            <div class="grid grid-cols-2 gap-y-2 mb-6">
                <p class="text-gray-600 font-semibold">Días y Horarios:</p>
                <p id="modal-schedule" class="text-gray-800"></p>
                <p class="text-gray-600 font-semibold">Modalidad:</p>
                <p id="modal-modality" class="text-gray-800"></p>
            </div>
            <button onclick="handleEnrollment()" class="btn-primary w-full py-3 rounded-lg text-lg font-semibold shadow-lg hover:shadow-xl transition duration-300 ease-in-out">
                Inscribirse ahora
            </button>
            <div id="auth-message-box" class="mt-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded-md hidden">
                Debes iniciar sesión para inscribirte.
            </div>
        </div>
    </div>

    <!-- Custom Alert/Message Box -->
    <div id="custom-alert" class="fixed bottom-8 right-8 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-[100] hidden transition-all duration-300 ease-in-out transform translate-y-full opacity-0">
        ¡Inscripción exitosa!
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
         // Mock authentication status (can be toggled for testing)
        let isLoggedIn = true; // Set to true to simulate logged-in user and show edit pencils

        // Sample course data
        const courses = [
            {
                id: 1,
                title: 'Desarrollo Web Full Stack',
                description: 'Aprende a construir aplicaciones web completas desde cero, dominando tanto el frontend como el backend.',
                schedule: 'Lunes y Miércoles 18:00 - 21:00',
                modality: 'Virtual',
                isVisible: true, // New property: initially visible
            },
            {
                id: 2,
                title: 'Diseño Gráfico Avanzado',
                description: 'Explora las técnicas más recientes en diseño gráfico, ilustración digital y branding.',
                schedule: 'Martes y Jueves 19:00 - 22:00',
                modality: 'Presencial',
                isVisible: true,
            },
            {
                id: 3,
                title: 'Marketing Digital Estratégico',
                description: 'Domina las herramientas y estrategias para posicionar marcas y productos en el entorno digital.',
                schedule: 'Viernes 17:00 - 20:00',
                modality: 'Virtual',
                isVisible: true,
            },
            {
                id: 4,
                title: 'Programación Python para IA',
                description: 'Introducción a la programación con Python enfocada en inteligencia artificial y machine learning.',
                schedule: 'Sábados 09:00 - 13:00',
                modality: 'Presencial',
                isVisible: true,
            }
        ];

        function loadCourses() {
            const courseList = document.getElementById('course-list');
            courseList.innerHTML = ''; // Clear existing content

            courses.forEach(course => {
                // Determine if the course should be visually marked as hidden for the admin
                const hiddenClass = !course.isVisible && isLoggedIn ? 'course-card-hidden' : '';
                const hiddenBadge = !course.isVisible && isLoggedIn ? `<span class="absolute top-2 left-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full z-10">OCULTO</span>` : '';

                // For a non-admin user (isLoggedIn === false), you would filter courses here:
                // if (!isLoggedIn && !course.isVisible) {
                //     return; // Skip rendering this course for non-admins if it's hidden
                // }

                const courseCard = `
                    <div id="course-${course.id}-card" class="bg-white p-6 rounded-lg shadow-md hover:shadow-xl transition duration-300 ease-in-out transform hover:-translate-y-1 relative ${hiddenClass}">
                        ${hiddenBadge}
                        <div class="flex justify-between items-center mb-3">
                            <h3 id="course-${course.id}-title" class="text-2xl font-bold text-purple-700">${course.title}</h3>
                            <!-- Pencil icon for individual course card to toggle visibility -->
                            <button id="toggle-visibility-course-${course.id}-btn" class="p-1 bg-purple-200 rounded-full hover:bg-purple-300 focus:outline-none edit-pencil hidden" onclick="toggleCourseVisibility(${course.id})">
                                <svg class="w-4 h-4 text-purple-700" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.38-2.828-2.829z"></path>
                                </svg>
                            </button>
                        </div>
                        <p id="course-${course.id}-description" class="text-gray-600 mb-4">${course.description.substring(0, 100)}...</p>
                        <div class="flex justify-between items-center text-sm text-gray-500 mb-4">
                            <span>Días: ${course.schedule.split(' ')[0]}</span>
                            <span>Modalidad: ${course.modality}</span>
                        </div>
                        <!-- Button to open modal, always active -->
                        <button id="open-modal-course-${course.id}-btn" class="btn-primary py-2 px-4 rounded-lg w-full text-center mt-2" onclick="openModal(${course.id})">
                            Ver Detalles
                        </button>
                    </div>
                `;
                courseList.innerHTML += courseCard;
            });
            initEditPencils();
        }

        /**
         * Toggles the edit mode for a specific section (Presentation, Courses section title).
         * @param {string} sectionId - The ID of the section container.
         * @param {string[]} elementToEditIds - An array of IDs of the elements within the section to make editable.
         */
        function toggleSectionEdit(sectionId, elementToEditIds) {
            const editButton = document.getElementById(`edit-${sectionId.replace('-section', '')}-btn`);
            const saveButton = document.getElementById(`save-${sectionId.replace('-section', '')}-btn`);

            let isInEditMode = false;

            // Check if any of the target elements are currently contenteditable
            for (const id of elementToEditIds) {
                const element = document.getElementById(id);
                if (element && element.contentEditable === 'true') {
                    isInEditMode = true;
                    break;
                }
            }

            if (isInEditMode) {
                // Exit edit mode (save changes - conceptually)
                elementToEditIds.forEach(id => {
                    const element = document.getElementById(id);
                    if (element) {
                        element.contentEditable = 'false';
                        element.style.outline = ''; // Remove the outline
                        // In a real app, you would send the updated content to the server here
                        console.log(`Content of ${id} saved:`, element.textContent);
                    }
                });
                editButton.classList.remove('hidden');
                saveButton.classList.add('hidden');
            } else {
                // Enter edit mode
                elementToEditIds.forEach(id => {
                    const element = document.getElementById(id);
                    if (element) {
                        element.contentEditable = 'true';
                        element.focus(); // Focus on the first editable element
                    }
                });
                editButton.classList.add('hidden');
                saveButton.classList.remove('hidden');
            }
        }

        /**
         * Toggles the visibility status of an individual course card.
         * This function is specific to the course card's pencil icon.
         * @param {number} courseId - The ID of the course.
         */
        function toggleCourseVisibility(courseId) {
            const courseIndex = courses.findIndex(c => c.id === courseId);
            if (courseIndex === -1) return;

            // Toggle the visibility status
            courses[courseIndex].isVisible = !courses[courseIndex].isVisible;
            console.log(`Course ${courseId} visibility toggled to: ${courses[courseIndex].isVisible}`);

            // Re-load courses to reflect the change visually
            loadCourses(); // This will re-render all courses with updated visibility states
            showCustomAlert(`Curso "${courses[courseIndex].title}" ${courses[courseIndex].isVisible ? 'visible' : 'oculto'}.`);
        }


        function openModal(courseId) {
            const course = courses.find(c => c.id === courseId);
            if (!course) return;

            document.getElementById('modal-title').textContent = course.title;
            document.getElementById('modal-description').textContent = course.description;
            document.getElementById('modal-schedule').textContent = course.schedule;
            document.getElementById('modal-modality').textContent = course.modality;

            const modal = document.getElementById('course-modal');
            const modalContent = document.getElementById('modal-content');
            modal.classList.remove('hidden');
            // Add a small delay to allow the 'hidden' class to be removed before adding 'active'
            setTimeout(() => {
                modal.classList.add('active');
            }, 10);

            // Hide auth message if already shown
            document.getElementById('auth-message-box').classList.add('hidden');
        }

        function closeModal() {
            const modal = document.getElementById('course-modal');
            const modalContent = document.getElementById('modal-content');
            modal.classList.remove('active');
            // Add a small delay to allow the transition to complete before adding 'hidden'
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300); // Match this duration with the CSS transition duration
        }

        function handleEnrollment() {
            const authMessageBox = document.getElementById('auth-message-box');
            if (isLoggedIn) {
                // Simulate successful enrollment
                showCustomAlert('¡Inscripción exitosa!');
                closeModal();
            } else {
                authMessageBox.classList.remove('hidden');
            }
        }

        function showCustomAlert(message) {
            const customAlert = document.getElementById('custom-alert');
            customAlert.textContent = message;
            customAlert.classList.remove('hidden');
            // Animate in
            setTimeout(() => {
                customAlert.classList.add('translate-y-0', 'opacity-100');
            }, 10);

            // Animate out after 3 seconds
            setTimeout(() => {
                customAlert.classList.remove('translate-y-0', 'opacity-100');
                customAlert.classList.add('translate-y-full', 'opacity-0');
                setTimeout(() => {
                    customAlert.classList.add('hidden');
                }, 300); // Match this duration with the CSS transition duration
            }, 3000);
        }

        // Function to initialize edit pencils visibility based on isLoggedIn
        function initEditPencils() {
            if (isLoggedIn) {
                document.querySelectorAll('.edit-pencil').forEach(btn => {
                    btn.classList.remove('hidden');
                });
            }
        }

        // Load courses and initialize edit pencils when the DOM is fully loaded
        document.addEventListener('DOMContentLoaded', () => {
            loadCourses();
        });
    </script>
@endpush