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
    </style>
@endpush

@section('contenido')
    <!-- aca el contenido para agregar -->
     <main class="flex-grow p-8 bg-gray-50">
        <section class="bg-white rounded-xl shadow-lg p-8 mb-8 border border-gray-200">
            <h2 class="text-4xl font-extrabold text-custom-dark-purple mb-8 text-center">Gestión de Cursos</h2>
            
            <form id="courseForm" method="POST" 
      action="{{ isset($curso) ? route('admin.cursos.update', $curso->codigo) : route('admin.cursos.store') }}">
    @csrf
    @isset($curso)
        @method('PUT')
    @endisset
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                <!-- Columna Central y Derecha: Campos del Formulario -->
                <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
                    <!-- Fila 1 -->
                    <div>
                        <label for="courseName"  class="block text-gray-700 text-lg font-semibold mb-2">Nombre del curso:</label>
                        <input type="text" id="courseName" name="nombre" value="{{ old('nombre', $curso->nombre ?? '') }}" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-custom-lilac shadow-sm" placeholder="Ej: Desarrollo Web con React">
                    </div>
                    <div class="relative">
                        <label for="startDate" class="block text-gray-700 text-lg font-semibold mb-2">Fecha de inicio:</label>
                        <input type="date" id="startDate" name="fecha_inicio" value="{{ old('fecha_inicio', $curso->fecha_inicio ?? '') }}" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-custom-lilac shadow-sm pr-10">
                    </div>

                    <!-- Fila 2 -->
                    <div>
                        <label for="description" class="block text-gray-700 text-lg font-semibold mb-2">Descripción:</label>
                        <textarea id="description"  name="descripcion" rows="3" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-custom-lilac shadow-sm" placeholder="Breve descripción del curso...">{{ old('descripcion', $curso->descripcion ?? '') }}</textarea>
                    </div>
                    <div class="relative">
                        <label for="endDate" class="block text-gray-700 text-lg font-semibold mb-2">Fecha de fin:</label>
                        <input type="date" id="endDate" name="fecha_fin" value="{{ old('fecha_fin', $curso->fecha_fin ?? '') }}" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-custom-lilac shadow-sm pr-10">
                    </div>

                    <!-- Fila 3: Categoría/s con múltiples selecciones -->
                    <div>

                    </div>
                    <div class="relative">
                        <label for="enrollmentDeadline" class="block text-gray-700 text-lg font-semibold mb-2">Fecha límite de inscripciones:</label>
                        <input type="date" id="enrollmentDeadline" name="fecha_limite_inscripcion" value="{{ old('fecha_limite_inscripcion', $curso->fecha_limite_inscripcion ?? '') }}" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-custom-lilac shadow-sm pr-10">
                    </div>

                    <!-- Fila 4 -->
                    <div>
                        <label for="enrollmentCost" class="block text-gray-700 text-lg font-semibold mb-2">Costo inscripción:</label>
                        <input type="number" id="enrollmentCost" name="costo_inscripcion" value="{{ old('costo_inscripcion', $curso->costo_inscripcion ?? '') }}" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-custom-lilac shadow-sm" placeholder="0.00">
                    </div>
                    <div>
                        <label for="capacity" class="block text-gray-700 text-lg font-semibold mb-2">Cantidad cupos:</label>
                        <input type="number" id="capacity" name="cupo" value="{{ old('cupo', $curso->cupo ?? '') }}" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-custom-lilac shadow-sm" placeholder="Ej: 50">
                    </div>

                    <!-- Fila 5 -->
                    <div>
                        <label for="monthlyCost" class="block text-gray-700 text-lg font-semibold mb-2">Costo mensual:</label>
                        <input type="number" id="monthlyCost" name="costo_mensual" value="{{ old('costo_mensual', $curso->costo_mensual ?? '') }}" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-custom-lilac shadow-sm" placeholder="0.00">
                    </div>
                    <div>
                        <label for="modality" class="block text-gray-700 text-lg font-semibold mb-2">Modalidad:</label>
                        <select id="modality" name="modalidad" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-custom-lilac shadow-sm">
    @foreach ($modalidades as $modalidad)
    <option value="{{ $modalidad->value }}"
      {{ old('modalidad', $curso->modalidad ?? '') === $modalidad->value ? 'selected' : '' }}>
      {{ $modalidad->value }}
    </option>
  @endforeach
</select>

                    </div>

                    <!-- Fila 6: Docente/s con múltiples selecciones -->

                    
                    <!-- Horarios con múltiples entradas en tabla -->
                    <div class="flex flex-col">
                        <label class="block text-gray-700 text-lg font-semibold mb-2">Horarios:</label>
                        <div class="flex space-x-2 mb-2">
                            <select id="scheduleDay" class="w-1/2 p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-custom-lilac shadow-sm">
    <option value="">Día</option>
    @foreach($diasSemana as $dia)
    <option value="{{ $dia }}">{{ $dia }}</option>
  @endforeach
</select>

                            <input type="time" id="scheduleTime" class="w-1/2 p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-custom-lilac shadow-sm">
                        </div>
                        <button type="button" onclick="addSchedule()" class="">
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
                                    <div id="added-schedules" class="mt-4">
                                        <input type="hidden" id="horario" name="horario" value="{{ isset($curso) ? json_encode($curso->horario) : '[]' }}">
                                    </div>
                                </tbody>
                            </table>
                        </div>
                    </div>

                     <!-- Fila 7 -->
                     <div>
                        <label for="paymentDeadlineDay" class="block text-gray-700 text-lg font-semibold mb-2">
                            Día límite de pago:
                        </label>

                        <input type="number" id="paymentDeadlineDay" name="paymentDeadlineDay" value="{{ old('paymentDeadlineDay', $curso->paymentDeadlineDay ?? '') }}"
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

            </div>
            @if($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
            <!-- Botones de Acción -->
            <div class="mt-8 flex justify-end space-x-4">
    @isset($curso)
    <form action="{{ route('admin.cursos.destroy', $curso->codigo) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este curso?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="bg-red-600 text-white px-8 py-3 rounded-full font-bold shadow-lg hover:bg-red-700 transition-all transform hover-scale-105">
            Eliminar
        </button>
    </form>
    @endisset

    <button type="submit" class="bg-emerald-500 text-white px-8 py-3 rounded-full font-bold shadow-lg hover:bg-emerald-600 transition-all transform hover-scale-105">
        {{ isset($curso) ? 'Actualizar' : 'Guardar' }}
    </button>
    </form>
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

            <!-- Lista de cursos -->
    <section class="bg-white rounded-xl shadow-lg p-8 border border-gray-200">
        <h2 class="text-3xl font-extrabold text-custom-dark-purple mb-6">Cursos registrados</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded-lg shadow-md">
                <thead>
                    <tr class="bg-custom-lilac text-white">
                        <th class="py-3 px-4 text-left">Nombre</th>
                        <th class="py-3 px-4 text-left">Fecha Inicio</th>
                        <th class="py-3 px-4 text-left">Modalidad</th>
                        <th class="py-3 px-4 text-left">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cursos as $c)
                    <tr class="border-b border-gray-200 hover:bg-gray-50">
                        <td class="py-3 px-4">{{ $c->nombre }}</td>
                        <td class="py-3 px-4">{{ $c->fecha_inicio->format('d/m/Y') }}</td>
                        <td class="py-3 px-4">{{ $c->modalidad }}</td>
                        <td class="py-3 px-4 flex space-x-2">
                            <a href="{{ route('admin.cursos.edit', $c->codigo) }}" 
                               class="text-blue-600 hover:text-blue-800">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                            <form id="delete-form-{{ $c->codigo }}" 
                                  action="{{ route('admin.cursos.destroy', $c->codigo) }}" 
                                  method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="confirmDelete('{{ $c->codigo }}')" 
                                        class="text-red-600 hover:text-red-800">
                                    <i class="fas fa-trash-alt"></i> Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>

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

    <!-- Custom Alert/Message Box -->
    <div id="custom-alert" class="hidden">
        <!-- El mensaje se insertará aquí -->
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

@push('scripts')
<script>

    function addSchedule() {
    const day = document.getElementById('scheduleDay').value;
    const time = document.getElementById('scheduleTime').value;
    
    if (!day || !time) {
        alert("Por favor, selecciona día y hora");
        return;
    }
    
    const horarioInput = document.getElementById('horario');
    let schedules = horarioInput.value ? JSON.parse(horarioInput.value) : [];
    
    // Evitar duplicados
    const exists = schedules.some(s => s.day === day && s.time === time);
    if (exists) {
        alert("Este horario ya fue agregado");
        return;
    }
    
    schedules.push({day, time});
    horarioInput.value = JSON.stringify(schedules);
    
    updateSchedulesTable();
    
    // Limpiar campos
    document.getElementById('scheduleDay').value = '';
    document.getElementById('scheduleTime').value = '';
}

function updateSchedulesTable() {
    const schedules = JSON.parse(document.getElementById('horario').value || '[]');
    const tableBody = document.querySelector('#schedulesTable tbody');
    tableBody.innerHTML = '';
    
    schedules.forEach((schedule, index) => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td class="py-2 px-3">${schedule.day}</td>
            <td class="py-2 px-3">${schedule.time}</td>
            <td class="py-2 px-3">
                <button type="button" onclick="removeSchedule(${index})" class="text-red-500">
                    <i class="fas fa-times"></i>
                </button>
            </td>
        `;
        tableBody.appendChild(row);
    });
}

function removeSchedule(index) {
    const horarioInput = document.getElementById('horario');
    let schedules = JSON.parse(horarioInput.value);
    schedules.splice(index, 1);
    horarioInput.value = JSON.stringify(schedules);
    updateSchedulesTable();
}

    function confirmDelete(codigo) {
        const modal = document.getElementById('confirmModal');
        const confirmBtn = document.getElementById('confirmDeleteBtn');
        
        confirmBtn.onclick = function() {
            document.getElementById(`delete-form-${codigo}`).submit();
        };
        
        modal.classList.remove('hidden');
    }

    // Para edición, cargar datos en el formulario
    @if(isset($curso))
        document.addEventListener('DOMContentLoaded', function() {
            // Cargar datos del curso en el formulario
            // Ejemplo: document.getElementById('nombre').value = '{{ $curso->nombre }}';
        });
    @endif
</script>
@endpush
@endsection