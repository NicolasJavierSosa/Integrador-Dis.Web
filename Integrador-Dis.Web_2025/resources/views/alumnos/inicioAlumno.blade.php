

@extends('estructuras.appAlumnos')

@section('tittle', 'AureaCursos - Inicio')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/inicios.css') }}">
@endpush

@section('contenido')
    <main class="flex-grow p-8 bg-gray-50">
        <!-- Sección de Presentación -->
         @if (session('success'))
            <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg text-center">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg text-center">
                {{ session('error') }}
            </div>
        @endif

        @if (session('info'))
            <div class="mb-6 p-4 bg-blue-100 border border-blue-400 text-blue-700 rounded-lg text-center">
                {{ session('info') }}
            </div>
        @endif
        <section class="mb-10 p-6 bg-purple-100 rounded-lg shadow-inner">
            <h1 class="text-4xl font-extrabold text-purple-800 mb-4 text-center">¡Bienvenido a los cursos de Aurea!</h1>
            <p class="text-lg text-purple-700 leading-relaxed text-center max-w-3xl mx-auto">
                Explora nuestra amplia variedad de cursos diseñados para potenciar tu futuro.
            </p>
        </section>

        <!-- Sección de Cursos -->
        <section id="cursos-section" class="py-16 bg-purple-200">
    <h2 class="text-4xl font-extrabold text-purple-800 mb-12 text-center tracking-wide">Nuestros Cursos</h2>
    <div id="course-list" class="container mx-auto px-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
        @foreach ($cursos as $curso)
            @php
                $fechaLimiteInscripcion = \Carbon\Carbon::parse($curso->fecha_limite_inscripcion);
                $inscripcionCaducada = $fechaLimiteInscripcion->isPast();
            @endphp
            <div
                class="relative p-8 rounded-xl shadow-lg transition-all duration-300 transform border border-transparent
                {{ $inscripcionCaducada ? 'bg-gray-700 hover:shadow-xl hover:scale-100 cursor-not-allowed' : 'bg-purple-800 hover:shadow-2xl hover:scale-105 cursor-pointer' }}"
                onclick="{{ $inscripcionCaducada ? '' : 'openModal(this)' }}"
                data-codigo="{{ $curso->codigo }}"
                data-nombre="{{ $curso->nombre }}"
                data-descripcion="{{ $curso->descripcion }}"
                data-horario="{{
                    is_array($curso->horario)
                        ? collect($curso->horario)->map(fn($h) => ($h['day'] ?? $h['dia']) . ' - ' . ($h['time'] ?? $h['hora']))->implode(', ')
                        : collect(json_decode($curso->horario, true))->map(fn($h) => ($h['day'] ?? $h['dia']) . ' - ' . ($h['time'] ?? $h['hora']))->implode(', ')
                }}"
                data-modalidad="{{ $curso->modalidad }}"
            >
                @if ($inscripcionCaducada)
                    <div class="absolute inset-0 bg-black bg-opacity-50 rounded-xl flex items-center justify-center">
                        <span class="text-white text-xl font-bold uppercase tracking-wider">Inscripción Cerrada</span>
                    </div>
                @endif
                <h3 class="text-2xl font-bold text-white mb-3">{{ $curso->nombre }}</h3>
                <p class="text-purple-200 text-base mb-4 leading-relaxed">{{ $curso->descripcion }}</p>

                <div class="text-white text-sm space-y-1">
                    <p><strong class="text-purple-100">Modalidad:</strong> <span class="font-medium">{{ $curso->modalidad }}</span></p>
                    <p><strong class="text-purple-100">Horario:</strong> <span class="font-medium">
                        {{
                            is_array($curso->horario)
                                ? collect($curso->horario)->map(fn($h) => ($h['day'] ?? $h['dia']) . ' - ' . ($h['time'] ?? $h['hora']))->implode(', ')
                                : collect(json_decode($curso->horario, true))->map(fn($h) => ($h['day'] ?? $h['dia']) . ' - ' . ($h['time'] ?? $h['hora']))->implode(', ')
                        }}
                    </span></p>
                    <p><strong class="text-purple-100">Fecha de Inicio:</strong> <span class="font-medium">{{ \Carbon\Carbon::parse($curso->fecha_inicio)->format('d/m/Y') }}</span></p>
                    <p><strong class="text-purple-100">Fecha de Fin:</strong> <span class="font-medium">{{ \Carbon\Carbon::parse($curso->fecha_fin)->format('d/m/Y') }}</span></p>
                    <p class="pt-2">
                        <strong class="text-purple-100">Inscripción hasta:</strong>
                        <span class="font-medium {{ $inscripcionCaducada ? 'text-red-400 line-through' : 'text-yellow-300' }}">
                            {{ \Carbon\Carbon::parse($curso->fecha_limite_inscripcion)->format('d/m/Y') }}
                        </span>
                    </p>
                </div>
            </div>
        @endforeach
    </div>
</section>

    </main>

    <!-- Modal -->
<div id="course-modal" class="fixed inset-0 flex items-center justify-center hidden">
  <div id="modal-content" class="bg-white p-8 rounded shadow-lg relative">
    <button onclick="closeModal()" class="absolute top-2 right-2">&times;</button>
    <h3 id="modal-title" class="text-2xl font-bold mb-2"></h3>
    <p id="modal-description" class="mb-4"></p>

    <div class="mb-4">
      <strong>Días y Horarios:</strong>
      <span id="modal-schedule"></span>
    </div>
    <div class="mb-4">
      <strong>Modalidad:</strong>
      <span id="modal-modality"></span>
    </div>
  
    @auth
      <form id="inscripcion-form" method="POST" action="{{ route('curso.inscribirse', ['codigo' => '__CODIGO__']) }}">
      @csrf
      <button type="submit" class="btn-primary w-full py-2 rounded">
          Inscribirse ahora
      </button>
  </form>
    @else
      <a href="{{ route('login') }}"
         class="btn-primary block text-center py-2 rounded">
        Inicia sesión o regístrate para inscribirte
      </a>
    @endauth
  </div>
</div>
@endsection



@push('scripts')
<script>
    // scripts.js

function openModal(card) {
  // Rellenar título y descripción
  document.getElementById('modal-title').textContent = card.dataset.nombre;
  document.getElementById('modal-description').textContent = card.dataset.descripcion;

  // Rellenar horario y modalidad
  document.getElementById('modal-schedule').textContent = card.dataset.horario;
  document.getElementById('modal-modality').textContent = card.dataset.modalidad;

  // Ajustar la URL del formulario de inscripción
  @auth
    const form = document.getElementById('inscripcion-form');
    form.action = form.action.replace('__CODIGO__', card.dataset.codigo);
  @endauth

  // Mostrar el modal
  document.getElementById('course-modal').classList.remove('hidden');
}

function closeModal() {
  document.getElementById('course-modal').classList.add('hidden');
}

</script>
     <!-- <script src="{{ asset('js/scripts.js') }}"></script> -->
@endpush
