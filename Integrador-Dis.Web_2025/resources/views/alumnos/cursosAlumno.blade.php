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
        <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($cursos as $curso)
                <div class="bg-purple-700 p-6 rounded-lg shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border border-purple-600">
                    <h3 class="text-xl font-semibold text-white mb-2">{{ $curso->nombre }}</h3>
                    <p class="text-purple-100 text-sm mb-3">{{ $curso->descripcion }}</p>
                    <p class="text-white text-sm mb-2">Inicio: <span class="font-medium">{{ $curso->fecha_inicio }}</span></p>
                    <p class="text-white text-sm mb-2">Fin: <span class="font-medium">{{ $curso->fecha_fin }}</span></p>
                    <p class="text-white text-sm mb-2">Horario: <span class="font-medium">{{ $curso->horario }}</span></p>
                    <p class="text-white text-sm mb-2">Modalidad: <span class="font-medium">--</span></p>
                    <form action="{{ route('alumno.bajaCurso', $curso->codigo) }}" method="POST" class="mt-4">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full bg-red-600 text-white py-2 rounded-lg font-semibold hover:bg-red-700 transition duration-300 ease-in-out transform hover:scale-105 shadow-md">
                            Dar de Baja Curso
                        </button>
                    </form>
                </div>
            @endforeach
        </section>
    @endif
</main>
@endsection
