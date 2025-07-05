@extends('estructuras.app')
@section('tittle', 'AureaCursos - Gestion de Cursos')
@push('css')
    <link rel="stylesheet" href="{{asset('css/gestion.css')}}">
    <style>
        .modal-overlay {
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            position: fixed; /* Asegura que cubra toda la ventana */
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 50; /* Z-index alto para que aparezca por encima de todo */
        }
        .modal-overlay.hidden {
            display: none;
        }
        .modal-content {
            opacity: 0;
            transform: scale(0.95);
            transition: all 0.3s ease-out;
            max-height: 90vh; /* Ensure modal content itself can scroll if it's too long */
            overflow-y: auto; /* Enable vertical scrolling within the modal if content overflows */
        }
        .modal-overlay.active .modal-content {
            opacity: 1;
            transform: scale(1);
        }
        /* Estilo para el cuadro de alerta personalizado */
        #custom-alert {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            background-color: #10b981; /* Verde esmeralda */
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            z-index: 100;
            opacity: 0;
            transform: translateY(100%);
            transition: all 0.3s ease-in-out;
        }
        #custom-alert.active {
            opacity: 1;
            transform: translateY(0);
        }
        /* Estilo para contenido editable */
        [contenteditable="true"] {
            outline: 2px dashed #a78bfa; /* Borde punteado lila */
            padding: 4px;
            border-radius: 4px;
        }
        .fixed-save-btn {
            position: absolute; /* clave */
            bottom: 2rem;
            right: 2rem;
            box-shadow: 0 8px 24px rgba(16, 185, 129, 0.25);
        }
    </style>
@endpush

@section('contenido')
    <main class="flex-grow p-8 bg-gray-50">
        <section class="bg-white rounded-xl shadow-lg p-8 mb-8 border border-gray-200">
            <h2 class="text-4xl font-extrabold text-custom-dark-purple mb-8 text-center">Gestión de Cursos</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Columna Izquierda: Imagen del Curso -->
                <div class="md:col-span-1 flex flex-col items-center justify-center p-4 bg-gray-100 rounded-lg border border-gray-200 shadow-sm">
                    <div class="w-48 h-48 bg-gray-300 rounded-lg flex items-center justify-center overflow-hidden mb-4 border-2 border-gray-400">
                        <img id="courseImagePreview" src="https://placehold.co/192x192/CCCCCC/333333?text=Imagen%20del%20curso" alt="Preview de la imagen del curso" class="object-cover w-full h-full">
                    </div>
                    <input type="file" id="courseImage" class="hidden" accept="image/*" onchange="previewImage(event)">
                    <label for="courseImage" class="bg-custom-lilac text-custom-white px-6 py-2 rounded-full font-semibold cursor-pointer hover:bg-gradient-custom-lilac transform hover-scale-105 transition-all shadow-md">
                        Seleccionar archivo
                    </label>
                </div>

                <!-- Columna Central y Derecha: Campos del Formulario -->
                <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
                    <!-- Fila 1 -->
                    <div>
                        <label for="courseName" class="block text-gray-700 text-lg font-semibold mb-2">Nombre del curso:</label>
                        <input type="text" id="courseName" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-custom-lilac shadow-sm" placeholder="Ej: Desarrollo Web con React">
                    </div>
                    <div class="relative">
                        <label for="startDate" class="block text-gray-700 text-lg font-semibold mb-2">Fecha de inicio:</label>
                        <input type="date" id="startDate" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-custom-lilac shadow-sm pr-10">
                    </div>

                    <!-- Fila 2 -->
                    <div>
                        <label for="description" class="block text-gray-700 text-lg font-semibold mb-2">Descripción:</label>
                        <textarea id="description" rows="3" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-custom-lilac shadow-sm" placeholder="Breve descripción del curso..."></textarea>
                    </div>
                    <div class="relative">
                        <label for="endDate" class="block text-gray-700 text-lg font-semibold mb-2">Fecha de fin:</label>
                        <input type="date" id="endDate" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-custom-lilac shadow-sm pr-10">
                    </div>

                    <!-- Fila 3: Categoría/s con múltiples selecciones -->
                    <div>
                        <label for="categories" class="block text-gray-700 text-lg font-semibold mb-2">Categoría/s:</label>
                        <div class="flex items-center">
                            <select id="categorySelect" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-custom-lilac shadow-sm">
                                <option value="">Selecciona una categoría</option>
                                <option value="Programación">Programación</option>
                                <option value="Diseño Gráfico">Diseño Gráfico</option>
                                <option value="Marketing Digital">Marketing Digital</option>
                                <option value="Idiomas">Idiomas</option>
                                <option value="Negocios">Negocios</option>
                            </select>
                            <button onclick="addCategoryFromSelect()" class="ml-2 bg-purple-400 text-custom-white px-4 py-2 rounded-full font-semibold shadow-md hover:bg-gradient-custom-lilac transition-all transform hover-scale-105" title="Añadir categoría seleccionada">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                        <div class="flex mt-2">
                            <input type="text" id="customCategoryInput" placeholder="Añadir otra categoría" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-custom-lilac shadow-sm">
                            <button onclick="openAddCategoryModal()" class="ml-2 bg-purple-400 text-custom-white px-4 py-2 rounded-full font-semibold shadow-md hover:bg-gradient-custom-lilac transition-all transform hover-scale-105" title="Añadir nueva categoría">
                                Nueva categoría
                            </button>
                        </div>
                        <div id="selectedCategories" class="mt-3 flex flex-wrap gap-2 p-2 bg-gray-100 rounded-lg border border-gray-200 min-h-[40px]">
                            <!-- Aquí se cargarán las categorías seleccionadas -->
                        </div>
                    </div>
                    <div class="relative">
                        <label for="enrollmentDeadline" class="block text-gray-700 text-lg font-semibold mb-2">Fecha límite de inscripciones:</label>
                        <input type="date" id="enrollmentDeadline" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-custom-lilac shadow-sm pr-10">
                    </div>

                    <!-- Fila 4 -->
                    <div>
                        <label for="enrollmentCost" class="block text-gray-700 text-lg font-semibold mb-2">Costo inscripción:</label>
                        <input type="number" id="enrollmentCost" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-custom-lilac shadow-sm" placeholder="0.00">
                    </div>
                    <div>
                        <label for="capacity" class="block text-gray-700 text-lg font-semibold mb-2">Cantidad cupos:</label>
                        <input type="number" id="capacity" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-custom-lilac shadow-sm" placeholder="Ej: 50">
                    </div>

                    <!-- Fila 5 -->
                    <div>
                        <label for="monthlyCost" class="block text-gray-700 text-lg font-semibold mb-2">Costo mensual:</label>
                        <input type="number" id="monthlyCost" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-custom-lilac shadow-sm" placeholder="0.00">
                    </div>
                    <div>
                        <label for="modality" class="block text-gray-700 text-lg font-semibold mb-2">Modalidad:</label>
                        <select id="modality" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-custom-lilac shadow-sm">
                            <option value="">Selecciona una modalidad</option>
                            <option value="Online">Online</option>
                            <option value="Presencial">Presencial</option>
                            <option value="Híbrido">Híbrido</option>
                        </select>
                    </div>

                    <!-- Fila 6: Docente/s con múltiples selecciones -->
                    <div>
                        <label for="instructorSelect" class="block text-gray-700 text-lg font-semibold mb-2">Docente/s:</label>
                        <div class="flex items-center">
                            <select id="instructorSelect" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-custom-lilac shadow-sm">
                                <option value="">Selecciona un docente</option>
                                <option value="Juan Pérez">Juan Pérez</option>
                                <option value="María García">María García</option>
                                <option value="Carlos López">Carlos López</option>
                                <option value="Ana Martínez">Ana Martínez</option>
                            </select>
                            <button onclick="addInstructorFromSelect()" class="ml-2 bg-gradient-custom-lilac text-custom-white px-4 py-2 rounded-full font-semibold shadow-md hover:bg-gradient-custom-lilac transition-all transform hover-scale-105" title="Añadir docente seleccionado">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                        <div class="flex mt-2">
                            <input type="text" id="customInstructorInput" placeholder="Añadir otro docente" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-custom-lilac shadow-sm">
                            <button onclick="" class="ml-2 bg-gradient-custom-lilac text-custom-white px-4 py-2 rounded-full font-semibold shadow-md hover:bg-gradient-custom-lilac transition-all transform hover-scale-105" title="Añadir docente">
                                Registrar docente
                            </button>
                        </div>
                        <div id="selectedInstructors" class="mt-3 flex flex-wrap gap-2 p-2 bg-gray-100 rounded-lg border border-gray-200 min-h-[40px]">
                            <!-- Aquí se cargarán los docentes seleccionados -->
                        </div>
                    </div>
                    
                    <!-- Horarios con múltiples entradas en tabla -->
                    <div class="flex flex-col">
                        <label class="block text-gray-700 text-lg font-semibold mb-2">Horarios:</label>
                        <div class="flex space-x-2 mb-2">
                            <select id="scheduleDay" class="w-1/2 p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-custom-lilac shadow-sm">
                                <option value="">Día</option>
                                <option value="Lunes">Lunes</option>
                                <option value="Martes">Martes</option>
                                <option value="Miércoles">Miércoles</option>
                                <option value="Jueves">Jueves</option>
                                <option value="Viernes">Viernes</option>
                                <option value="Sábado">Sábado</option>
                                <option value="Domingo">Domingo</option>
                            </select>
                            <input type="time" id="scheduleTime" class="w-1/2 p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-custom-lilac shadow-sm">
                        </div>
                        <button onclick="addSchedule()" class="bg-custom-lilac text-custom-white px-4 py-2 rounded-full font-semibold shadow-md hover:bg-gradient-custom-lilac transition-all transform hover-scale-105 mt-2">
                            Añadir Horario <i class="fas fa-plus"></i>
                        </button>
                        <div class="mt-4 w-full overflow-x-auto p-2 bg-gray-100 rounded-lg border border-gray-200">
                            <table id="schedulesTable" class="min-w-full bg-white rounded-lg shadow-sm border border-gray-200">
                                <thead>
                                    <tr class="bg-gray-100 text-gray-700">
                                        <th class="py-2 px-3 text-left text-sm font-semibold">Día</th>
                                        <th class="py-2 px-3 text-left text-sm font-semibold">Hora</th>
                                        <th class="py-2 px-3 text-left text-sm font-semibold"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Aquí se cargarán los horarios -->
                                </tbody>
                            </table>
                        </div>
                    </div>

                     <!-- Fila 7 -->
                     <div>
                        <label for="paymentDeadlineDay" class="block text-gray-700 text-lg font-semibold mb-2">
                            Día límite de pago:
                        </label>
                        
                        <input type="number" id="paymentDeadlineDay" name="paymentDeadlineDay"
                            min="1" max="29"
                            list="recommendedDays"
                            class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-custom-lilac shadow-sm"
                            placeholder="Ej: 10" >
                        <datalist id="recommendedDays">
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="15">15</option>
                        </datalist>

                        <p class="text-sm text-gray-500 mt-1">* Ingresá un día entre 1 y 29. Recomendado: 5, 10 o 15.</p>
                    </div>
                    <!-- Combo de Estado -->
                    <div>
                        <label for="estadoSelect" class="block text-gray-700 text-lg font-semibold mb-2">Estado:</label>
                        <select id="estadoSelect" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-custom-lilac shadow-sm">
                            <option value="">Estado</option>
                            <option value="Alta">Alta</option>
                            <option value="Baja">Baja</option>
                        </select>
                </div>
            </div>
            
            <!-- Botones de Acción -->
            <div class="mt-8 flex justify-end space-x-4">
                <button onclick="deleteCourse()" class="bg-red-600 text-white px-8 py-3 rounded-full font-bold shadow-lg hover:bg-red-700 transition-all transform hover-scale-105">
                    Eliminar
                </button>
                <button onclick="saveCourse()" class="bg-emerald-500 text-white px-8 py-3 rounded-full font-bold shadow-lg hover:bg-emerald-600 transition-all transform hover-scale-105">
                    Guardar
                </button>
            </div>

            <!-- Add Category Modal -->
    <div id="add-category-modal" class="fixed inset-0 z-50 hidden modal-overlay">
        <div class="bg-white p-8 rounded-xl shadow-2xl max-w-lg w-full relative transform transition-all duration-300 scale-95 opacity-0 modal-content">
            <button onclick="closeModal('add-category-modal')" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 text-3xl font-semibold">&times;</button>
            <h3 class="text-2xl font-bold text-purple-800 mb-6 text-center">Gestionar Categorías</h3>

            <!-- Sección para añadir nueva categoría -->
            <div class="mb-8 p-4 border border-purple-200 rounded-lg">
                <h4 class="text-xl font-semibold text-purple-700 mb-4">Añadir Nueva Categoría</h4>
                <div class="mb-4">
                    <label for="new-category-name-input" class="block text-gray-700 text-sm font-bold mb-2">Nombre de la Categoría:</label>
                    <input type="text" id="new-category-name-input" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-purple-500" placeholder="Ej: Programación">
                </div>
                <div class="mb-6">
                    <label for="new-category-description-input" class="block text-gray-700 text-sm font-bold mb-2">Descripción:</label>
                    <textarea id="new-category-description-input" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-purple-500" placeholder="Breve descripción de la categoría"></textarea>
                </div>
                <button onclick="addCategory()" class="btn-primary w-full py-3 rounded-lg text-lg font-semibold shadow-lg hover:shadow-xl transition duration-300 ease-in-out">
                    Guardar Categoría
                </button>
            </div>

            <!-- Sección para lista de categorías existentes -->
            <div>
                <h4 class="text-xl font-semibold text-purple-700 mb-4">Categorías Existentes</h4>
                <div id="category-list" class="space-y-4">
                    <!-- Las categorías se cargarán aquí -->
                    <p class="text-gray-500 text-center" id="no-categories-message">No hay categorías registradas.</p>
                </div>
            </div>
        </div>
    </div>


            @if ($errors->any())
                <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show"
                    x-transition:leave="transition ease-in duration-500" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    class="fixed top-8 right-8 z-50 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded shadow-lg">
                    <ul class="text-sm list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif


            <section class="bg-white rounded-xl shadow-xl p-8 border border-gray-200 mt-10">
            <h2 class="text-3xl font-bold text-custom-dark-purple mb-6 flex items-center gap-2">
                <i class="fas fa-book-open text-custom-purple"></i> Cursos registrados
            </h2>

            <div class="w-full overflow-x-auto rounded-lg border border-gray-300">
                <table class="min-w-full bg-white rounded-lg shadow-sm divide-y divide-gray-200">
                    <thead class="bg-custom-lilac text-black">
                        <tr>
                            <th class="py-3 px-4 text-left text-sm font-semibold uppercase tracking-wide rounded-tl-lg">📘
                                Nombre</th>
                            <th class="py-3 px-4 text-left text-sm font-semibold uppercase tracking-wide">🎓 Modalidad</th>
                            <th class="py-3 px-4 text-left text-sm font-semibold uppercase tracking-wide">🕒 Horarios</th>
                            <th class="py-3 px-4 text-left text-sm font-semibold uppercase tracking-wide">📅 Fecha Inicio
                            </th>
                            <th class="py-3 px-4 text-left text-sm font-semibold uppercase tracking-wide rounded-tr-lg">📅
                                Fecha Final</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">
                        @forelse ($cursos as $curso)
                            <tr class="hover:bg-gray-50 transition-all">
                                <td class="py-4 px-4 text-gray-800 font-semibold">{{ $curso->nombre }}</td>
                                <td class="py-4 px-4 text-gray-700">{{ ucfirst($curso->modalidad) }}</td>

                                <td class="py-4 px-4 text-gray-700 leading-snug">
                                    @php
                                        $horarios = is_array($curso->horario) ? $curso->horario : json_decode($curso->horario, true);
                                    @endphp
                                    @foreach ($horarios as $h)
                                        <div class="flex items-center gap-2">
                                            <i class="far fa-clock text-indigo-500"></i>
                                            <span>{{ ucfirst($h['day']) }} - {{ $h['time'] }}</span>
                                        </div>
                                    @endforeach
                                </td>

                                <td class="py-4 px-4 text-gray-700">
                                    {{ \Carbon\Carbon::parse($curso->fecha_inicio)->format('d/m/Y') }}
                                </td>

                                <td class="py-4 px-4 text-gray-700">
                                    <span>{{ \Carbon\Carbon::parse($curso->fecha_fin)->format('d/m/Y') }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-6 px-4 text-center text-gray-500 italic">
                                    <i class="fas fa-info-circle"></i> No hay cursos registrados.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <script defer src="//unpkg.com/alpinejs"></script>

    </main>
@endsection

@push('scripts')
    <script src="{{asset('js/scripts.js')}}"></script>
    <!-- Script para el modal de  categoria-->
     <script>
        // Array de categorías de ejemplo (simula tus datos existentes)
        // Ahora incluye id, nombre y descripción
        let categories = [
            { id: 1, name: 'Programación', description: 'Cursos relacionados con el desarrollo de software y lenguajes de programación.' },
            { id: 2, name: 'Diseño Gráfico', description: 'Explora herramientas y principios de diseño visual, UX/UI.' },
            { id: 3, name: 'Marketing Digital', description: 'Estrategias y herramientas para el posicionamiento y crecimiento online.' }
        ];

        let nextCategoryId = categories.length > 0 ? Math.max(...categories.map(c => c.id)) + 1 : 1;

        /**
         * Abre un modal genérico.
         * @param {string} modalId - El ID del modal a abrir.
         */
        function openModal(modalId) {
            const modal = document.getElementById(modalId);
            // Disable body scrolling when modal is open
            document.body.style.overflow = 'hidden';

            const modalContent = modal.querySelector('.modal-content');

            if (modalId === 'add-category-modal') {
                document.getElementById('new-category-name-input').value = ''; // Limpia el input al abrir
                document.getElementById('new-category-description-input').value = ''; // Limpia el input al abrir
                renderCategoryList(); // Renderiza la lista de categorías existentes
            }

            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.add('active');
            }, 10);
        }

        /**
         * Cierra un modal genérico.
         * @param {string} modalId - El ID del modal a cerrar.
         */
        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.classList.remove('active');
            // Re-enable body scrolling when modal is closed
            document.body.style.overflow = ''; // or 'auto'

            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300); // Coincide con la duración de la transición CSS
        }

        /**
         * Abre específicamente el modal de gestionar categorías.
         */
        function openAddCategoryModal() {
            openModal('add-category-modal');
        }

        /**
         * Maneja la lógica para añadir una nueva categoría.
         */
        function addCategory() {
            const nameInput = document.getElementById('new-category-name-input');
            const descriptionInput = document.getElementById('new-category-description-input');
            const newCategoryName = nameInput.value.trim();
            const newCategoryDescription = descriptionInput.value.trim();

            if (newCategoryName && newCategoryDescription) {
                // Comprobar si la categoría ya existe por nombre
                if (categories.some(c => c.name.toLowerCase() === newCategoryName.toLowerCase())) {
                    showCustomAlert(`La categoría "${newCategoryName}" ya existe.`);
                    return;
                }

                const newCategory = {
                    id: nextCategoryId++,
                    name: newCategoryName,
                    description: newCategoryDescription
                };
                categories.push(newCategory);
                showCustomAlert(`Categoría "${newCategoryName}" añadida.`);
                console.log("Categorías actuales:", categories);
                nameInput.value = ''; // Limpiar campos
                descriptionInput.value = '';
                renderCategoryList(); // Actualizar la lista
                // En una aplicación real, aquí enviarías esta categoría a tu backend
            } else {
                showCustomAlert("Por favor, introduce el nombre y la descripción de la categoría.");
            }
        }

        /**
         * Renderiza la lista de categorías existentes en el modal.
         */
        function renderCategoryList() {
            const categoryListDiv = document.getElementById('category-list');
            categoryListDiv.innerHTML = ''; // Limpiar el contenido existente

            if (categories.length === 0) {
                categoryListDiv.innerHTML = '<p class="text-gray-500 text-center" id="no-categories-message">No hay categorías registradas.</p>';
                return;
            }

            categories.forEach(category => {
                const categoryCard = `
                    <div id="category-${category.id}-card" class="bg-purple-50 p-4 rounded-lg shadow-sm flex flex-col sm:flex-row justify-between items-start sm:items-center">
                        <div class="flex-grow mb-2 sm:mb-0">
                            <h5 id="category-${category.id}-name" class="text-lg font-bold text-purple-800" contenteditable="false">${category.name}</h5>
                            <p id="category-${category.id}-description" class="text-gray-700 text-sm" contenteditable="false">${category.description}</p>
                        </div>
                        <div class="flex space-x-2">
                            <!-- Botón de editar -->
                            <button id="edit-category-${category.id}-btn" class="p-2 bg-blue-200 rounded-full hover:bg-blue-300 focus:outline-none" onclick="toggleCategoryEdit(${category.id})">
                                <svg class="w-4 h-4 text-blue-700" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.38-2.828-2.829z"></path>
                                </svg>
                            </button>
                            <!-- Botón de guardar (inicialmente oculto) -->
                            <button id="save-category-${category.id}-btn" class="p-2 bg-green-200 rounded-full hover:bg-green-300 focus:outline-none hidden" onclick="saveCategory(${category.id})">
                                <svg class="w-4 h-4 text-green-700" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </button>
                            <!-- Botón de eliminar -->
                            <button id="delete-category-${category.id}-btn" class="p-2 bg-red-200 rounded-full hover:bg-red-300 focus:outline-none" onclick="deleteCategory(${category.id})">
                                <svg class="w-4 h-4 text-red-700" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 011-1h4a1 1 0 110 2H8a1 1 0 01-1-1zm6 3a1 1 0 100 2v3a1 1 0 102 0v-3a1 1 0 00-2 0z" clip-rule="evenodd"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                `;
                categoryListDiv.innerHTML += categoryCard;
            });
        }

        /**
         * Habilita o deshabilita el modo de edición para una categoría específica.
         * @param {number} categoryId - El ID de la categoría a editar.
         */
        function toggleCategoryEdit(categoryId) {
            const nameElement = document.getElementById(`category-${categoryId}-name`);
            const descriptionElement = document.getElementById(`category-${categoryId}-description`);
            const editButton = document.getElementById(`edit-category-${categoryId}-btn`);
            const saveButton = document.getElementById(`save-category-${categoryId}-btn`);
            const deleteButton = document.getElementById(`delete-category-${categoryId}-btn`);

            let isInEditMode = nameElement.contentEditable === 'true';

            if (isInEditMode) {
                // Si estaba en modo edición, deshabilitar (esto debería ser manejado por saveCategory)
                // Este caso se usa si se desea cancelar sin guardar (no implementado un botón de cancelar)
                nameElement.contentEditable = 'false';
                descriptionElement.contentEditable = 'false';
                nameElement.style.outline = '';
                descriptionElement.style.outline = '';
                editButton.classList.remove('hidden');
                saveButton.classList.add('hidden');
                deleteButton.classList.remove('hidden'); // Vuelve a mostrar el botón de eliminar
            } else {
                // Entrar en modo edición
                nameElement.contentEditable = 'true';
                descriptionElement.contentEditable = 'true';
                nameElement.focus(); // Pone el foco en el nombre para editar
                editButton.classList.add('hidden');
                saveButton.classList.remove('hidden');
                deleteButton.classList.add('hidden'); // Oculta el botón de eliminar mientras se edita
            }
        }

        /**
         * Guarda los cambios de una categoría editada.
         * @param {number} categoryId - El ID de la categoría a guardar.
         */
        function saveCategory(categoryId) {
            const nameElement = document.getElementById(`category-${categoryId}-name`);
            const descriptionElement = document.getElementById(`category-${categoryId}-description`);

            const updatedName = nameElement.textContent.trim();
            const updatedDescription = descriptionElement.textContent.trim();

            if (!updatedName || !updatedDescription) {
                showCustomAlert("El nombre y la descripción de la categoría no pueden estar vacíos.");
                return;
            }

            // Comprobar si el nombre de categoría actualizado ya existe en otra categoría
            const existingCategory = categories.find(c => c.name.toLowerCase() === updatedName.toLowerCase() && c.id !== categoryId);
            if (existingCategory) {
                showCustomAlert(`La categoría "${updatedName}" ya existe en otra entrada.`);
                // Revertir el nombre en la UI para evitar confusión
                const originalCategory = categories.find(c => c.id === categoryId);
                if (originalCategory) {
                    nameElement.textContent = originalCategory.name;
                }
                return;
            }

            const categoryIndex = categories.findIndex(c => c.id === categoryId);
            if (categoryIndex !== -1) {
                categories[categoryIndex].name = updatedName;
                categories[categoryIndex].description = updatedDescription;
                showCustomAlert(`Categoría "${updatedName}" actualizada.`);
                console.log("Categorías actualizadas:", categories);
                // En una aplicación real, aquí enviarías los datos actualizados a tu backend
            }
            toggleCategoryEdit(categoryId); // Sale del modo edición
        }

        /**
         * Elimina una categoría de la lista.
         * @param {number} categoryId - El ID de la categoría a eliminar.
         */
        function deleteCategory(categoryId) {
            const categoryToDelete = categories.find(c => c.id === categoryId);
            if (categoryToDelete && confirm(`¿Estás seguro de que quieres eliminar la categoría "${categoryToDelete.name}"?`)) { // Usar modal personalizado en vez de confirm en app real
                categories = categories.filter(c => c.id !== categoryId);
                showCustomAlert(`Categoría "${categoryToDelete.name}" eliminada.`);
                console.log("Categorías después de eliminar:", categories);
                renderCategoryList(); // Volver a renderizar la lista
                // En una aplicación real, aquí enviarías la solicitud de eliminación a tu backend
            }
        }

        /**
         * Muestra un cuadro de alerta personalizado.
         * @param {string} message - El mensaje a mostrar en la alerta.
         */
        function showCustomAlert(message) {
            const customAlert = document.getElementById('custom-alert');
            customAlert.textContent = message;
            customAlert.classList.remove('hidden');
            customAlert.classList.add('active'); // Activa la animación de entrada

            // Oculta la alerta después de 3 segundos
            setTimeout(() => {
                customAlert.classList.remove('active'); // Activa la animación de salida
                setTimeout(() => {
                    customAlert.classList.add('hidden'); // Oculta completamente después de la animación
                }, 300); // Coincide con la duración de la transición CSS
            }, 3000);
        }
    </script>
@endpush