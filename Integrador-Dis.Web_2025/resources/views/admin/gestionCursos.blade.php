@extends('app')
@section('tittle', 'AureaCursos - Gestion de Cursos')
@push('css')
    <link rel="stylesheet" href="{{asset('css/gestion.css')}}">
@endpush

@section('contenido')
    <!-- aca el contenido para agregar -->
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
                            <button onclick="addCustomCategory()" class="ml-2 bg-purple-400 text-custom-white px-4 py-2 rounded-full font-semibold shadow-md hover:bg-gradient-custom-lilac transition-all transform hover-scale-105" title="Añadir nueva categoría">
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
                            <button onclick="addInstructorFromSelect()" class="ml-2 bg-custom-lilac text-custom-white px-4 py-2 rounded-full font-semibold shadow-md hover:bg-gradient-custom-lilac transition-all transform hover-scale-105" title="Añadir docente seleccionado">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                        <div class="flex mt-2">
                            <input type="text" id="customInstructorInput" placeholder="Añadir otro docente" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-custom-lilac shadow-sm">
                            <button onclick="addCustomInstructor()" class="ml-2 bg-custom-lilac text-custom-white px-4 py-2 rounded-full font-semibold shadow-md hover:bg-gradient-custom-lilac transition-all transform hover-scale-105" title="Añadir docente personalizado">
                                <i class="fas fa-plus"></i>
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
        </section>

        <!-- Cursos Registrados -->
        <section class="bg-white rounded-xl shadow-lg p-8 border border-gray-200 mt-8">
            <h2 class="text-3xl font-extrabold text-custom-dark-purple mb-6">Cursos registrados:</h2>
            <div class="w-full overflow-x-auto">
                <table id="registeredCoursesTable" class="min-w-full bg-white rounded-lg shadow-md">
                    <thead>
                        <tr class="bg-custom-lilac text-custom-white">
                            <th class="py-3 px-4 text-left text-sm font-semibold uppercase tracking-wider rounded-tl-lg">Nombre del Curso</th>
                            <th class="py-3 px-4 text-left text-sm font-semibold uppercase tracking-wider">Categoría/s</th>
                            <th class="py-3 px-4 text-left text-sm font-semibold uppercase tracking-wider">Docente/s</th>
                            <th class="py-3 px-4 text-left text-sm font-semibold uppercase tracking-wider">Modalidad</th>
                            <th class="py-3 px-4 text-left text-sm font-semibold uppercase tracking-wider">Fecha Inicio</th>
                            <th class="py-3 px-4 text-left text-sm font-semibold uppercase tracking-wider rounded-tr-lg">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Ejemplo de fila de datos (se cargará desde Firestore) -->
                        <tr class="border-b border-gray-200 hover:bg-gray-50 transition-all">
                            <td class="py-3 px-4 text-gray-800">Introducción a Python</td>
                            <td class="py-3 px-4 text-gray-800">Programación</td>
                            <td class="py-3 px-4 text-gray-800">Juan Pérez</td>
                            <td class="py-3 px-4 text-gray-800">Online</td>
                            <td class="py-3 px-4 text-gray-800">2025-07-15</td>
                            <td class="py-3 px-4">
                                <button class="text-custom-purple hover:text-custom-dark-purple mr-3"><i class="fas fa-edit"></i> Editar</button>
                                <button class="text-red-600 hover:text-red-800"><i class="fas fa-trash-alt"></i> Eliminar</button>
                            </td>
                        </tr>
                        <tr class="border-b border-gray-200 hover:bg-gray-50 transition-all">
                            <td class="py-3 px-4 text-gray-800">Diseño UX/UI Avanzado</td>
                            <td class="py-3 px-4 text-gray-800">Diseño Gráfico</td>
                            <td class="py-3 px-4 text-gray-800">María García</td>
                            <td class="py-3 px-4 text-gray-800">Híbrido</td>
                            <td class="py-3 px-4 text-gray-800">2025-08-01</td>
                            <td class="py-3 px-4">
                                <button class="text-custom-purple hover:text-custom-dark-purple mr-3"><i class="fas fa-edit"></i> Editar</button>
                                <button class="text-red-600 hover:text-red-800"><i class="fas fa-trash-alt"></i> Eliminar</button>
                            </td>
                        </tr>
                        <!-- Las filas se cargarán dinámicamente -->
                    </tbody>
                </table>
            </div>
        </section>
    </main>
@endsection

@push('scripts')
    <script src="{{asset('js/scripts.js')}}"></script>
@endpush