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
    <main class="flex-grow p-8 bg-gray-50">
        <section class="bg-white rounded-xl shadow-lg p-8 mb-8 border border-gray-200">
            <h2 class="text-4xl font-extrabold text-custom-dark-purple mb-8 text-center">Gestión de Cursos</h2>

            <form id="courseForm" method="POST"
            onsubmit="return validateForm()"
            action="{{ isset($curso) ? route('admin.cursos.update', $curso->codigo) : route('admin.cursos.store') }}">
                @csrf
                @isset($curso)
                    @method('PUT')
                @endisset
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    {{-- Left Column --}}
                    <div class="flex flex-col gap-4">
                        <div>
                            <label for="courseName" class="block text-gray-700 text-lg font-semibold mb-2">Nombre del
                                curso:</label>
                            <input type="text" id="courseName" name="nombre"
                                value="{{ old('nombre', $curso->nombre ?? '') }}"
                                class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-custom-lilac shadow-sm"
                                placeholder="Ej: Desarrollo Web con React">
                        </div>
                        <div>
                            <label for="description"
                                class="block text-gray-700 text-lg font-semibold mb-2">Descripción:</label>
                            <textarea id="description" name="descripcion" rows="3"
                                class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-custom-lilac shadow-sm"
                                placeholder="Breve descripción del curso...">{{ old('descripcion', $curso->descripcion ?? '') }}</textarea>
                        </div>
                        <button type="button" onclick="openAddCategoryModal()"
                            class="bg-purple-600 text-white px-4 py-2 rounded-md shadow hover:bg-purple-700 transition w-fit mt-2"
                            style="background-color: #9333ea; padding: 10px 20px; border-radius: 8px;">
                            Registrar Categoría
                        </button>
                    </div>

                     {{-- Middle Column --}}
                    <div class="flex flex-col gap-4">
                        <div class="relative">
                            <label for="startDate" class="block text-gray-700 text-lg font-semibold mb-2">Fecha de
                                inicio:</label>
                            <input type="date" id="startDate" name="fecha_inicio"
                                value="{{ old('fecha_inicio', $curso->fecha_inicio ?? '') }}"
                                class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-custom-lilac shadow-sm pr-10">
                        </div>
                        <div class="relative">
                            <label for="enrollmentDeadline" class="block text-gray-700 text-lg font-semibold mb-2">Fecha
                                límite de inscripciones:</label>
                            <input type="date"
                            id="enrollmentDeadline"
                            name="fecha_limite_inscripcion"
                            value="{{ old('fecha_limite_inscripcion', $curso->fecha_limite_inscripcion ?? '') }}"
                            min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                            class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-custom-lilac shadow-sm pr-10">
                        </div>
                        <div>
                            <label for="modality" class="block text-gray-700 text-lg font-semibold mb-2">Modalidad:</label>
                            <select id="modality" name="modalidad"
                                class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-custom-lilac shadow-sm">
                                @foreach ($modalidades as $modalidad)
                                    <option value="{{ $modalidad->value }}"
                                        {{ old('modalidad', $curso->modalidad ?? '') === $modalidad->value ? 'selected' : '' }}>
                                        {{ $modalidad->value }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div x-data="docentesComponent({{ $docentes->toJson() }})" class="w-full">
                            <label for="docents" class="block text-gray-700 text-lg font-semibold mb-2">Docente/s:</label>

                            <select id="docents"
                                    x-model="selectedDocent"
                                    @change="addDocent()"
                                    class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-custom-lilac shadow-sm">
                                <option value="" disabled selected>Selecciona un docente</option>
                                <template x-for="doc in docentes" :key="doc.id">
                                    <option :value="doc.id" x-text="doc.full_name"></option>
                                </template>
                            </select>

                            <!-- Lista seleccionados -->
                            <div class="mt-4 flex flex-wrap gap-2">
                                <template x-for="(doc, index) in selectedDocentes" :key="doc.id">
                                    <span class="flex items-center bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm">
                                        <span x-text="doc.name"></span>
                                        <button type="button" @click="removeDocent(index)" class="ml-2 text-purple-600 hover:text-purple-900">&times;</button>
                                    </span>
                                </template>
                            </div>

                            <!-- Inputs ocultos -->
                            <template x-for="doc in selectedDocentes" :key="doc.id">
                                <input type="hidden" name="docentes[]" :value="doc.id" disabled>
                            </template>
                        </div>
                    </div>

                    {{-- Right Column --}}
                    <div class="flex flex-col gap-4">
                        <div class="relative">
                            <label for="endDate" class="block text-gray-700 text-lg font-semibold mb-2">Fecha de fin:</label>
                            <input type="date" id="endDate" name="fecha_fin"
                                value="{{ old('fecha_fin', $curso->fecha_fin ?? '') }}"
                                class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-custom-lilac shadow-sm pr-10">
                        </div>
                        <div>
                            <label for="capacity" class="block text-gray-700 text-lg font-semibold mb-2">Cantidad
                                cupos:</label>
                            <input type="number" id="capacity" name="cupo"
                                value="{{ old('cupo', $curso->cupo ?? '') }}"
                                class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-custom-lilac shadow-sm"
                                placeholder="Ej: 50">
                        </div>
                        <div class="flex flex-col">
                            <label class="block text-gray-700 text-lg font-semibold mb-2">Horarios:</label>
                            <div class="flex space-x-2 mb-2">
                                <select id="scheduleDay"
                                    class="w-1/2 p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-custom-lilac shadow-sm">
                                    <option value="">Día</option>
                                    @foreach ($diasSemana as $dia)
                                        <option value="{{ $dia }}">{{ $dia }}</option>
                                    @endforeach
                                </select>

                                <input type="time" id="scheduleTime"
                                    class="w-1/2 p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-custom-lilac shadow-sm">
                            </div>
                            <button type="button" onclick="addSchedule()"
                                class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md shadow hover:bg-gray-300 transition w-fit mt-2">
                                Añadir Horario <i class="fas fa-plus"></i>
                            </button>

                            <div class="mt-4 w-full overflow-x-auto p-2 bg-gray-100 rounded-lg border border-gray-200">
                                <table id="schedulesTable"
                                    class="min-w-full bg-white rounded-lg shadow-sm border border-gray-200">
                                    <thead>
                                        <tr class="bg-gray-100 text-gray-700">
                                            <th class="py-2 px-3 text-left text-sm font-semibold">Día</th>
                                            <th class="py-2 px-3 text-left text-sm font-semibold">Hora</th>
                                            <th class="py-2 px-3 text-left text-sm font-semibold"></th>
                                        </tr>
                                    </thead>
                                    <div id="added-schedules" class="mt-4">
                                        <input type="hidden" id="horario" name="horario"
                                            value="{{ isset($curso) ? json_encode($curso->horario_combinado) : '[]' }}">
                                        <input type="hidden" name="dias" id="diasInput"
                                            value="{{ isset($curso) ? json_encode($curso->dias) : '[]' }}">
                                    </div>
                                    <tbody id="schedulesTableBody">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-8 flex justify-end">
                <button type="submit"
                    class="bg-emerald-500 text-white px-8 py-3 rounded-full font-bold shadow-lg hover:bg-emerald-600 transition hover:scale-105">
                    {{ isset($curso) ? 'Actualizar' : 'Guardar' }}
                </button>
                </div>




            </form>
            <!-- OVERLAY MODAL -->
            <div id="add-category-modal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black bg-opacity-50" onclick="closeModal('add-category-modal')">
                <!-- MODAL CONTENT -->
                <div class="bg-white p-8 rounded-xl shadow-2xl max-w-lg w-full relative transform transition-all duration-300 scale-100 opacity-100 modal-content"
                    onclick="event.stopPropagation()">
                    <!-- BOTÓN CERRAR -->
                    <button onclick="closeModal('add-category-modal')" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 text-3xl font-semibold">
                        &times;
                    </button>

                    <!-- TÍTULO -->
                    <h3 class="text-2xl font-bold text-purple-800 mb-6 text-center">Gestionar Categorías</h3>

                    <!-- FORM NUEVA CATEGORÍA -->
                    <form id="addCategoryForm" method="POST" action="{{ route('admin.categories.store') }}" class="mb-8 p-4 border border-purple-200 rounded-lg">
                        @csrf

                        <h4 class="text-xl font-semibold text-purple-700 mb-4">Añadir Nueva Categoría</h4>

                        <div class="mb-4">
                            <label for="new-category-name-input" class="block text-gray-700 text-sm font-bold mb-2">Nombre de la Categoría:</label>
                            <input type="text" name="name" id="new-category-name-input" placeholder="Ej: Programación"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-purple-500">
                        </div>

                        <div class="mb-6">
                            <label for="new-category-description-input" class="block text-gray-700 text-sm font-bold mb-2">Descripción:</label>
                            <textarea id="new-category-description-input" name="description" rows="3" placeholder="Breve descripción de la categoría"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-purple-500"></textarea>
                        </div>

                        <button type="submit"
                            class="bg-purple-600 text-white w-full py-3 rounded-lg text-lg font-semibold shadow-lg hover:shadow-xl transition duration-300 ease-in-out">
                            Guardar Categoría
                        </button>
                    </form>

                    <!-- LISTA CATEGORÍAS EXISTENTES -->
                    <div>
                        <h4 class="text-xl font-semibold text-purple-700 mb-4">Categorías Existentes</h4>
                        <div id="category-list" class="space-y-4">
                            @forelse ($categorias as $categoria)
                                <div class="p-2 bg-purple-100 rounded">
                                    {{ $categoria->name }} - {{ $categoria->description }}
                                </div>
                            @empty
                                <p class="text-gray-500 text-center" id="no-categories-message">
                                    No hay categorías registradas.
                                </p>
                            @endforelse
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

@push('scripts')
<script>

  function docentesComponent(docentes) {
    return {
        docentes: docentes, // Recibe los docentes desde la vista
        selectedDocent: '',
        selectedDocentes: [],
        addDocent() {
            const doc = this.docentes.find(d => d.id == this.selectedDocent);
            if (doc && !this.selectedDocentes.some(d => d.id === doc.id)) {
                this.selectedDocentes.push(doc);
            }
            this.selectedDocent = ''; // Reinicia el combo box
        },
        removeDocent(index) {
            this.selectedDocentes.splice(index, 1);
        },
        logDocentes() {
            console.log(this.docentes); // Verifica los datos en la consola
        }
    }
}

function addCategory() {
    const name = document.getElementById('new-category-name-input').value.trim();
    const description = document.getElementById('new-category-description-input').value.trim();

    if (!name) {
        alert('Por favor ingresa un nombre.');
        return;
    }

    fetch("{{ route('admin.categories.store') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({
            name: name,
            description: description
        })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('No se pudo guardar la categoría.');
        }
        return response.json();
    })
    .then(data => {
        console.log('Categoría creada:', data);
        closeModal('add-category-modal');
        document.getElementById('new-category-name-input').value = '';
        document.getElementById('new-category-description-input').value = '';
        updateCategoryList(data.category);
    })
    .catch(error => {
        console.error(error);
        alert('Error al guardar la categoría.');
    });
}

function updateCategoryList(category) {
    const list = document.getElementById('category-list');
    const emptyMsg = document.getElementById('no-categories-message');

    if (emptyMsg) {
        emptyMsg.remove();
    }

    const item = document.createElement('div');
    item.className = 'p-2 bg-purple-100 rounded';
    item.textContent = `${category.name} - ${category.description || ''}`;

    list.appendChild(item);
}

function openAddCategoryModal() {
    document.getElementById('add-category-modal').classList.remove('hidden');
}

function closeModal(modalId) {
    document.getElementById(modalId).classList.add('hidden');
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

  const dias = [...new Set(schedules.map(s => s.day))];
  diasInput.value = JSON.stringify(dias);

  updateSchedulesTable();
}


function validateForm() {
  const horarioInput = document.getElementById('horario');
  let schedules = horarioInput.value ? JSON.parse(horarioInput.value) : [];

  if (schedules.length === 0) {
    alert("Debes especificar al menos un horario para guardar el curso.");
    return false; // BLOQUEA el envío
  }

  return true; // Permite el envío
}



</script>
@endpush
@endsection