@extends('estructuras.appAlumnos')

@section('tittle', 'AureaCursos - Inicio')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/inicios.css') }}">
@endpush

@section('contenido')
<main class="max-w-6xl mx-auto bg-white p-8 rounded-xl shadow-2xl">
    <h1 class="text-3xl font-bold text-center text-purple-800 mb-8">Mis Cursos</h1>

    @if (session('message'))
        <div class="bg-green-100 text-green-700 p-3 rounded-lg text-center font-medium mb-4">
            {{ session('message') }}
        </div>
    @endif

    @if ($cursos->isEmpty())
        <p class="text-center text-gray-500 mt-8">Actualmente no estás inscrito en ningún curso.</p>
    @else
        <!-- Tu grid de cursos -->
        <section 
            x-data="{ openModal: false, selectedCurso: null }"
            class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"
        >
            @foreach ($cursos as $curso)
                <div class="bg-purple-700 p-6 rounded-lg shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border border-purple-600 flex flex-col justify-between">
                <div class="flex-grow">
                    <h3 class="text-xl font-semibold text-white mb-2">{{ $curso->nombre }}</h3>
                    <p class="text-purple-100 text-sm mb-3">{{ $curso->descripcion }}</p>
                    <p class="text-white text-sm mb-2">Inicio: <span class="font-medium">{{ $curso->fecha_inicio }}</span></p>
                    <p class="text-white text-sm mb-2">Fin: <span class="font-medium">{{ $curso->fecha_fin }}</span></p>
                    <p class="text-white text-sm mb-2">Horario: <span class="font-medium">{{ is_array($curso->horario) 
                        ? collect($curso->horario)
                            ->map(fn($h) => ($h['day'] ?? $h['dia']) . ' - ' . ($h['time'] ?? $h['hora']))
                            ->implode(', ')
                        : collect(json_decode($curso->horario, true))
                            ->map(fn($h) => ($h['day'] ?? $h['dia']) . ' - ' . ($h['time'] ?? $h['hora']))
                            ->implode(', ')
                    }}</span></p>
                    <p class="text-white text-sm mb-2">Modalidad: <span class="font-medium">{{ $curso->modalidad }}</span></p>
                </div>
                    <!-- Botón para abrir modal -->
                    <button 
                        @click="openModal = true; selectedCurso = {{ $curso->codigo }}"
                        type="button"
                        class="w-full bg-red-600 text-white py-2 rounded-lg font-semibold hover:bg-red-700 transition duration-300 ease-in-out transform hover:scale-105 shadow-md"
                    >
                        Dar de Baja Curso
                    </button>
                </div>
            @endforeach

                    <!-- Modal -->
                    <div 
                        x-show="openModal"
                        x-cloak
                        x-transition
                        class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50"
                    >
                        <div class="bg-white p-8 rounded-lg max-w-md w-full text-center">
                            <h2 class="text-xl font-bold mb-4 text-gray-800">¿Estás seguro?</h2>
                            <p class="text-gray-600 mb-6">¿Realmente deseas darte de baja de este curso?</p>
                            
                            <div class="flex justify-center gap-4">
                                <form 
                                    :action="'/alumno/curso/' + selectedCurso" 
                                    method="POST"
                                >
                                    @csrf
                                    @method('DELETE')
                                    <button 
                                        type="submit"
                                        class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700"
                                    >
                                        Confirmar Baja
                                    </button>
                                </form>
                                <button 
                                    @click="openModal = false"
                                    class="bg-gray-300 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-400"
                                >
                                    Cancelar
                                </button>
                            </div>
                        </div>
                    </div>
                </section>

    @endif
</main>
@endsection

<script src="//unpkg.com/alpinejs" defer></script>
