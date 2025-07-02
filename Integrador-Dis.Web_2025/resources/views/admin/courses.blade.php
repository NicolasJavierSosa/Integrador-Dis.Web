@extends('layouts.app')
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

                    

                    
<!-- Formulario compacto oculto -->
<div id="category-form" class="hidden border border-purple-200 p-4 rounded-lg bg-white shadow-sm w-full max-w-md md:col-span-2 mx-auto">
  <h4 class="text-lg font-semibold text-purple-700 mb-3">Nueva Categoría</h4>
  <div class="mb-3">
    <label for="new-category-name-input" class="block text-sm text-gray-700 mb-1">Nombre:</label>
    <input type="text" id="new-category-name-input"
      class="w-full border rounded px-3 py-1 text-sm focus:outline-none focus:border-purple-500">
  </div>
  <div class="mb-3">
    <label for="new-category-description-input" class="block text-sm text-gray-700 mb-1">Descripción:</label>
    <textarea id="new-category-description-input" rows="2"
      class="w-full border rounded px-3 py-1 text-sm focus:outline-none focus:border-purple-500"></textarea>
  </div>
  <button 
    type="button"
    onclick="addCategory()"
    class="bg-purple-600 text-white px-4 py-2 rounded-md shadow hover:bg-purple-700 transition w-full"
  >
    Guardar Categoría
  </button>
</div>

                    <!-- Fila 3: Categoría/s con múltiples selecciones -->
                    <div>
                                        <div>
                        <label for="capacity" class="block text-gray-700 text-lg font-semibold mb-2">Cantidad cupos:</label>
                        <input type="number" id="capacity" name="cupo" value="{{ old('cupo', $curso->cupo ?? '') }}" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-custom-lilac shadow-sm" placeholder="Ej: 50">
                    </div>
                    </div>
                    <div class="relative">
                        <label for="enrollmentDeadline" class="block text-gray-700 text-lg font-semibold mb-2">Fecha límite de inscripciones:</label>
                        <input type="date" id="enrollmentDeadline" name="fecha_limite_inscripcion" value="{{ old('fecha_limite_inscripcion', $curso->fecha_limite_inscripcion ?? '') }}" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-custom-lilac shadow-sm pr-10">
                    </div>

                    <!-- Fila 4 -->



                    <!-- Fila 5 -->

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
                                <div id="added-schedules" class="mt-4">
                                        <input type="hidden" id="horario" name="horario" value="{{ isset($curso) ? json_encode($curso->horario_combinado) : '[]' }}">
                                        <input type="hidden" name="dias" id="diasInput" value="{{ isset($curso) ? json_encode($curso->dias) : '[]' }}">
                                </div>
                                <tbody id="schedulesTableBody">
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>

                     <!-- Fila 7 -->

                    <!-- Combo de Estado -->

            </div>
            
            <!-- Botones de Acción -->
           <div class="relative mt-8 flex justify-between items-center">
  <!-- Mensaje de error alineado a la IZQUIERDA -->

  <!-- Botón alineado a la DERECHA -->
  <button type="submit" class="bg-emerald-500 text-white px-8 py-3 rounded-full font-bold shadow-lg hover:bg-emerald-600 transition-all transform hover-scale-105 fixed-save-btn">
    {{ isset($curso) ? 'Actualizar' : 'Guardar' }}
  </button>
</div>

  </div>
    </form>

      @if ($errors->any())
    <div
        x-data="{ show: true }"
        x-init="setTimeout(() => show = false, 5000)"
        x-show="show"
        x-transition:leave="transition ease-in duration-500"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed top-8 right-8 z-50 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded shadow-lg"
    >
        <ul class="text-sm list-disc pl-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


            <!-- Add Category Modal -->
    <!-- Botón que muestra/oculta la sección -->



            <!-- Lista de cursos -->

        <section class="bg-white rounded-xl shadow-xl p-8 border border-gray-200 mt-10">
    <h2 class="text-3xl font-bold text-custom-dark-purple mb-6 flex items-center gap-2">
        <i class="fas fa-book-open text-custom-purple"></i> Cursos registrados
    </h2>

    <div class="w-full overflow-x-auto rounded-lg border border-gray-300">
        <table class="min-w-full bg-white rounded-lg shadow-sm divide-y divide-gray-200">
            <thead class="bg-custom-lilac text-black">
                <tr>
                    <th class="py-3 px-4 text-left text-sm font-semibold uppercase tracking-wide rounded-tl-lg">📘 Nombre</th>
                    <th class="py-3 px-4 text-left text-sm font-semibold uppercase tracking-wide">🎓 Modalidad</th>
                    <th class="py-3 px-4 text-left text-sm font-semibold uppercase tracking-wide">🕒 Horarios</th>
                    <th class="py-3 px-4 text-left text-sm font-semibold uppercase tracking-wide">📅 Fecha Inicio</th>
                    <th class="py-3 px-4 text-left text-sm font-semibold uppercase tracking-wide rounded-tr-lg">📅 Fecha Final</th>
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

@push('scripts')
<script>

    function toggleCategoryForm() {
    const form = document.getElementById('category-form');
    form.classList.toggle('hidden');
  }

  function addCategory() {
    // Tu lógica para registrar la categoría
    alert('Categoría guardada!');
    // Ocultar de nuevo si querés:
    document.getElementById('category-form').classList.add('hidden');
  }

@if(isset($curso))
    document.addEventListener('DOMContentLoaded', function() {
        updateSchedulesTable(); // Esto mostrará los horarios existentes
    });
@endif


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
    const horarioInput = document.getElementById('horario');
    const schedules = horarioInput.value ? JSON.parse(horarioInput.value) : [];
    const tableBody = document.querySelector('#schedulesTable tbody');
    
    // Limpiar tabla
    tableBody.innerHTML = '';
    
    // Generar filas
    schedules.forEach((schedule, index) => {
        const row = document.createElement('tr');
        row.className = 'border-b border-gray-200 hover:bg-gray-50';
        
        row.innerHTML = `
            <td class="py-2 px-3">${schedule.day}</td>
            <td class="py-2 px-3">${schedule.time}</td>
            <td class="py-2 px-3">
                <button 
                    onclick="removeSchedule(${index})" 
                    class="text-red-500 hover:text-red-700"
                >
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        `;
        
        tableBody.appendChild(row);
    });
}

function addSchedule() {
    const day = document.getElementById('scheduleDay').value;
    const time = document.getElementById('scheduleTime').value;

    if (!day || !time) {
        alert("Por favor, selecciona día y hora");
        return;
    }

    const horarioInput = document.getElementById('horario');
    const diasInput = document.getElementById('diasInput');
    let schedules = horarioInput.value ? JSON.parse(horarioInput.value) : [];

    // Evitar duplicados
    const exists = schedules.some(s => s.day === day && s.time === time);
    if (exists) {
        alert("Este horario ya fue agregado");
        return;
    }

    schedules.push({day, time});
    horarioInput.value = JSON.stringify(schedules);

    // Actualiza los días únicos
    const dias = [...new Set(schedules.map(s => s.day))];
    diasInput.value = JSON.stringify(dias);

    updateSchedulesTable();

    // Limpiar campos
    document.getElementById('scheduleDay').value = '';
    document.getElementById('scheduleTime').value = '';
}

function removeSchedule(index) {
    const horarioInput = document.getElementById('horario');
    const diasInput = document.getElementById('diasInput');
    let schedules = JSON.parse(horarioInput.value);
    schedules.splice(index, 1);
    horarioInput.value = JSON.stringify(schedules);

    // Actualiza los días únicos
    const dias = [...new Set(schedules.map(s => s.day))];
    diasInput.value = JSON.stringify(dias);

    updateSchedulesTable();
}


</script>
@endpush
@endsection