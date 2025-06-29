@extends('estructuras.app')
@section('tittle', 'AureaCursos - Inicio')
@push('css')
    <link rel="stylesheet" href="{{ asset('css/inicios.css') }}">
@endpush

@section('contenido')
    <!-- aca el contenido para agregar -->
    <main class="flex-grow p-8 bg-gray-50">
        <!-- Sección de Presentación -->
        <section class="mb-10 p-6 bg-purple-100 rounded-lg shadow-inner">
            <h1 class="text-4xl font-extrabold text-purple-800 mb-4 text-center">¡Bienvenido a Instituto XXX!</h1>
            <p class="text-lg text-purple-700 leading-relaxed text-center max-w-3xl mx-auto">
                Explora nuestra amplia variedad de cursos diseñados para potenciar tu futuro.
            </p>
        </section>

        <!-- Sección de Cursos -->
        <section id="cursos-section">
            <h2 class="text-3xl font-bold text-purple-800 mb-6 text-center">Nuestros Cursos</h2>
            <div id="course-list" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- JS cargará los cursos aquí -->
            </div>
        </section>
    </main>

    <!-- Modal -->
    <div id="course-modal" class="fixed inset-0 flex items-center justify-center z-50 hidden modal-overlay">
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
            <button onclick="alert('¡Inscripción exitosa!')" class="btn-primary w-full py-3 rounded-lg text-lg font-semibold shadow-lg hover:shadow-xl transition duration-300 ease-in-out">
                Inscribirse ahora
            </button>
            <div id="auth-message-box" class="mt-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded-md hidden">
                Debes iniciar sesión para inscribirte.
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/scripts.js') }}"></script>
@endpush