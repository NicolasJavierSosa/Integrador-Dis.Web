<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'AureaCursos')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/headerFooter.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    @stack('css')
</head>
<body class="flex flex-col min-h-screen">
    <!-- Encabezado -->
    <header class="bg-gradient-custom-purple shadow-xl p-5 flex flex-col md:flex-row justify-between items-center rounded-b-xl">
        <div class="flex items-center space-x-6 mb-4 md:mb-0">
            <!-- Logo o Nombre de la Institución -->
            <div class="flex items-center">
                <i class="fas fa-graduation-cap text-custom-white text-3xl mr-3"></i>
                <span class="text-custom-white text-2xl font-extrabold tracking-wide">Instituto XXX</span>
            </div>
            
            <!-- Menú de Navegación -->
            <nav class="hidden md:flex space-x-8">
                <a href="{{ route('curso.inicio') }}" class="text-custom-white text-lg font-semibold hover:text-custom-light-purple transition-all px-4 py-2 rounded-lg bg-gradient-custom-lilac transform hover-scale-105">Inicio</a>
                <a href="{{ route('alumno.misCursos') }}" class="text-custom-white text-lg font-semibold hover:text-custom-light-purple transition-all px-4 py-2 rounded-lg hover:bg-gradient-custom-lilac transform hover-scale-105">Mis Cursos</a>
            </nav>
        </div>

        <!-- Información de Usuario/Administrador o Botones de acceso -->
        <div class="flex items-center space-x-4">
            @auth
                <span class="text-custom-white text-lg font-medium hidden sm:block">
                    Usuario: {{ Auth::user()->name }}
                </span>
                <div class="relative group">
                    <button class="flex items-center focus:outline-none rounded-full border-2 border-custom-white p-1 transform transition-all hover-scale-105" onclick="toggleDropdown(event)">
                        <img class="h-10 w-10 rounded-full" src="" alt="User Avatar">
                    </button>
                    <!-- Dropdown -->
                    <div id="userDropdown" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-xl py-2 z-20 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all transform scale-95 group-hover:scale-100 origin-top-right">
                        <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-custom-lilac hover:text-custom-white rounded-md mx-2 my-1 transition-all">Perfil</a>
                        <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-custom-lilac hover:text-custom-white rounded-md mx-2 my-1 transition-all">Configuración</a>
                        <div class="border-t border-gray-200 my-1"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-red-600 hover:bg-red-100 rounded-md mx-2 my-1 transition-all">Cerrar Sesión</button>
                        </form>
                    </div>
                </div>
            @endauth

            @guest
                <button id="inicioSesion" onclick="window.location='{{ route('login') }}'" class="bg-custom-lilac text-custom-white px-5 py-2 rounded-full font-semibold shadow-md hover:bg-gradient-custom-lilac transition-all transform hover-scale-105">
                    Iniciar Sesión
                </button>
                <button id="registro" onclick="window.location='{{ route('registro') }}'" class="bg-custom-white text-custom-lilac px-5 py-2 rounded-full font-semibold shadow-md hover:bg-gray-200 transition-all transform hover-scale-105">
                    Registrarse
                </button>
            @endguest
        </div>
    </header>

    <main>
        @yield('contenido')
    </main>

    <footer class="bg-gradient-custom-purple text-custom-white p-8 mt-12 rounded-t-xl shadow-xl">
        <div class="container mx-auto flex flex-col md:flex-row justify-between items-start md:items-center">
            <!-- Información de Contacto -->
            <div class="text-center md:text-left mb-6 md:mb-0">
                <h3 class="text-2xl font-bold mb-3">Instituto XXX</h3>
                <p class="text-md mb-1"><i class="fas fa-map-marker-alt mr-2"></i>Dirección: Calle Falsa 123, Ciudad, País</p>
                <p class="text-md mb-1"><i class="fas fa-phone mr-2"></i>Teléfono: +123 456 7890</p>
                <p class="text-md"><i class="fas fa-envelope mr-2"></i>Email: info@instituto.com</p>
            </div>

            <!-- Enlaces Útiles -->
            <nav class="mb-6 md:mb-0">
                <h4 class="text-xl font-semibold mb-3">Enlaces Rápidos</h4>
                <ul class="space-y-2 text-md">
                    <li><a href="#" class="hover:text-custom-light-purple transition-all">Acerca de Nosotros</a></li>
                    <li><a href="#" class="hover:text-custom-light-purple transition-all">Nuestros Servicios</a></li>
                    <li><a href="#" class="hover:text-custom-light-purple transition-all">Preguntas Frecuentes</a></li>
                    <li><a href="#" class="hover:text-custom-light-purple transition-all">Política de Privacidad</a></li>
                </ul>
            </nav>

            <!-- Redes Sociales -->
            <div class="flex flex-col items-center md:items-end">
                <h4 class="text-xl font-semibold mb-3">Síguenos</h4>
                <div class="flex space-x-5 mb-5">
                    <a href="#" class="text-custom-white hover:text-custom-light-purple transition-all transform hover-scale-105 social-icon">
                        <i class="fab fa-facebook-f text-2xl"></i>
                    </a>
                    <a href="#" class="text-custom-white hover:text-custom-light-purple transition-all transform hover-scale-105 social-icon">
                        <i class="fab fa-twitter text-2xl"></i>
                    </a>
                    <a href="#" class="text-custom-white hover:text-custom-light-purple transition-all transform hover-scale-105 social-icon">
                        <i class="fab fa-instagram text-2xl"></i>
                    </a>
                    <a href="#" class="text-custom-white hover:text-custom-light-purple transition-all transform hover-scale-105 social-icon">
                        <i class="fab fa-linkedin-in text-2xl"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="text-center text-sm mt-6 border-t border-custom-light-purple pt-6">
            &copy; 2025 Instituto XXX. Todos los derechos reservados. Diseñado con <i class="fas fa-heart text-red-400"></i>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
