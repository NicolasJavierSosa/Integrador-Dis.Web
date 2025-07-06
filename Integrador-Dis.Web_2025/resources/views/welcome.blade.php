<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido - Instituto Aurea</title>

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/headerFooter.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>

<body class="min-h-screen bg-gradient-to-br from-purple-100 to-purple-300 flex flex-col">

    <!-- Encabezado -->
    <header class="bg-gradient-custom-purple shadow-xl p-5 flex flex-col md:flex-row justify-between items-center rounded-b-xl">
        <div class="flex items-center space-x-6 mb-4 md:mb-0">
            <div class="flex items-center">
                <i class="fas fa-graduation-cap text-custom-white text-3xl mr-3"></i>
                <span class="text-custom-white text-2xl font-extrabold tracking-wide">Instituto Aurea</span>
            </div>
        </div>
    </header>

    <!-- Contenido principal -->
    <main class="max-w-6xl mx-auto bg-white p-8 rounded-xl shadow-2xl text-center mt-8">

        <!-- Bienvenida -->
        <div class="mb-6">
            <h1 class="text-4xl font-bold text-purple-800 mb-2">
                ¡Bienvenido{{ Auth::check() ? ', ' . (Auth::user()->name ?? 'Usuario') : ' invitado' }}!
            </h1>

            @if (session('error'))
                <p class="bg-red-100 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </p>
            @endif

            @if(Auth::check())
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-full font-semibold shadow-md hover:bg-red-700 transition duration-200">
                        Cerrar Sesión
                    </button>
                </form>
            @else
                <form method="GET" action="{{ route('login') }}" class="inline">
                    <button type="submit" class="bg-purple-600 text-white px-4 py-2 rounded-full font-semibold shadow-md hover:bg-purple-700 transition duration-200">
                        Iniciar Sesión
                    </button>
                </form>
            @endif
        </div>
        <!-- Sección de bienvenida principal -->
        <section class="bg-purple-100 p-8 rounded-lg mb-8 shadow-inner border border-purple-200">
            <h1 class="text-4xl font-bold text-purple-800 mb-4">¡Bienvenido a Instituto XXX!</h1>
            <p class="text-lg text-purple-700">Explora nuestra amplia variedad de oportunidades de aprendizaje diseñadas para potenciar tu futuro.</p>
        </section>

        <!-- Sección de "Sobre Nuestro Instituto" con información e imágenes -->
        <section class="mb-8">
            <h2 class="text-3xl font-bold text-purple-800 mb-6">Sobre Nuestro Instituto</h2>
            <div class="text-left text-gray-700 mb-8 max-w-4xl mx-auto">
                <p class="mb-4">En el Instituto XXX, nos dedicamos a ofrecer una educación de calidad que te prepare para los desafíos del mañana. Creemos firmemente en el poder del conocimiento para transformar vidas y construir un futuro mejor.</p>
                <p class="mb-4">Nuestra misión es proporcionar un ambiente de aprendizaje innovador y accesible, donde cada estudiante pueda desarrollar al máximo su potencial. Contamos con un equipo de instructores altamente calificados y una metodología que prioriza la práctica y la aplicación real de lo aprendido.</p>
                <p>Únete a nuestra comunidad y descubre cómo podemos ayudarte a alcanzar tus metas profesionales y personales. ¡Tu éxito es nuestra prioridad!</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-center">
                <div class="bg-purple-500 rounded-lg shadow-md p-4">
                    <img src="https://placehold.co/600x400/a78bfa/ffffff?text=Aprendizaje+Colaborativo" alt="Imagen de Aprendizaje Colaborativo" class="w-full h-64 object-cover rounded-md mb-4 shadow-lg">
                    <p class="text-white text-lg font-semibold">Fomentamos el aprendizaje colaborativo y la innovación.</p>
                </div>
                <div class="bg-purple-500 rounded-lg shadow-md p-4">
                    <img src="https://placehold.co/600x400/8b5cf6/ffffff?text=Crecimiento+Profesional" alt="Imagen de Crecimiento Profesional" class="w-full h-64 object-cover rounded-md mb-4 shadow-lg">
                    <p class="text-white text-lg font-semibold">Impulsamos tu crecimiento personal y profesional.</p>
                </div>
            </div>
        </section>

        <!-- Sección de llamada a la acción o más información -->
        <section class="bg-purple-50 p-6 rounded-lg shadow-inner border border-purple-200 mt-8">
            <h2 class="text-2xl font-bold text-purple-800 mb-4">¡Comienza tu aprendizaje hoy!</h2>
            <p class="text-purple-700 mb-6">Inscríbete en nuestros programas y transforma tu futuro profesional.</p>
            <a 
                href="{{ route('curso.inicio') }}"
                class="inline-block bg-purple-600 text-white py-3 px-8 rounded-lg font-semibold text-lg hover:bg-purple-700 transition duration-300 ease-in-out transform hover:scale-105 shadow-md"
            >
                Ver Nuestros Cursos
            </a>

        </section>
    </main>
</body>

</html>