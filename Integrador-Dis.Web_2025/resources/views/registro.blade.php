<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>AureaCursos</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{asset('css/style.css')}}" />
</head>
<body>
    <div id="pantalla" class="w-full max-w-md bg-white rounded-xl shadow-xl overflow-hidden border border-gray-200">
        <header class="bg-purple-700 p-4 flex items-center justify-start rounded-t-xl">
        <div id="icono-logo">
            <img src="/Integrador-Dis.Web_2025/resources/imagenes/logo.png" alt="Logo del Instituto" id="logo-img">
        </div>
        <h1 class="text-white text-lg font-semibold">Instituto XXX</h1>
        </header>
        <div class="p-8">
        <!-- Pestañas de Login y Sign Up -->
            <div class="flex bg-gray-100 rounded-full p-1 mb-6 border border-gray-300">
                <button id="loginTab" onclick="window.location='{{ route('login') }}'" class="flex-1 py-2 px-4 text-center text-gray-600 font-medium rounded-full">
                Iniciar Sesion</button>
                <button id="signupTab" class="flex-1 py-2 px-4 text-center text-purple-700 font-medium bg-white rounded-full shadow-sm">
                Registrarse</button>
            </div>
        <main id="loginFormContainer">
            <form class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Campo Nombre/s -->
                    <div>
                        <label for="nombre" class="block text-sm font-medium text-gray-700 mb-2">Nombre/s:</label>
                        <input type="text" id="nombre" name="nombre"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none transition duration-200"
                        placeholder="Tu nombre(s)">
                    </div>
                    <!-- Campo Apellido/s -->
                    <div>
                        <label for="apellido" class="block text-sm font-medium text-gray-700 mb-2">Apellido/s:</label>
                        <input type="text" id="apellido" name="apellido"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none transition duration-200"
                                placeholder="Tu apellido(s)">
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Campo DNI -->
                    <div>
                        <label for="dni" class="block text-sm font-medium text-gray-700 mb-2">DNI:</label>
                        <input type="text" id="dni" name="dni"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none transition duration-200"
                                placeholder="Tu número de DNI">
                    </div>
                    <!-- Campo Género -->
                    <div>
                        <label for="genero" class="block text-sm font-medium text-gray-700 mb-2">Género:</label>
                        <div class="relative">
                            <select id="genero" name="genero"
                                    class="appearance-none w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none transition duration-200 bg-white pr-10">
                                <option value="">Selecciona</option>
                                <option value="masculino">Masculino</option>
                                <option value="femenino">Femenino</option>
                                <option value="otro">Otro</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Campo Fecha de Nacimiento -->
                    <div>
                        <label for="fechaNacimiento" class="block text-sm font-medium text-gray-700 mb-2">Fecha de Nacimiento:</label>
                        <div class="relative">
                            <input type="date" id="fechaNacimiento" name="fechaNacimiento"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none transition duration-200 pr-10">
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <svg class="fill-current h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M1 4c0-1.1.9-2 2-2h14a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V4zm2 0v1a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H3zm14 3H3v9a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V7zM9 8h2v2H9V8zm0 3h2v2H9v-2zm0 3h2v2H9v-2zm-4-3h2v2H5V8zm0 3h2v2H5v-2zm0 3h2v2H5v-2zm8-3h2v2h-2V8zm0 3h2v2h-2v-2zm0 3h2v2h-2v-2z"/></svg>
                            </div>
                        </div>
                    </div>
                    <!-- Campo Ciudad -->
                    <div>
                        <label for="ciudad" class="block text-sm font-medium text-gray-700 mb-2">Ciudad:</label>
                        <input list="ciudades" id="ciudad" name="ciudad"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none transition duration-200"
                                placeholder="Escribí tu ciudad">

                        <datalist id="ciudades">
                            <option value="Buenos Aires">
                            <option value="Córdoba">
                            <option value="Rosario">
                            <option value="Mendoza">
                            <option value="La Plata">
                            <option value="Mar del Plata">
                            <option value="San Miguel de Tucumán">
                            <option value="Salta">
                            <option value="Santa Fe">
                            <option value="Neuquén">
                            <option value="Posadas">
                        </datalist>
                    </div>
                </div>
                <!-- Campo Correo electrónico -->
                <div>
                    <label for="signupEmail" class="block text-sm font-medium text-gray-700 mb-2">Correo electrónico:</label>
                    <input type="email" id="signupEmail" name="signupEmail"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none transition duration-200"
                            placeholder="tu.correo@example.com">
                </div>
                <!-- Campo Teléfono -->
                <div>
                    <label for="telefono" class="block text-sm font-medium text-gray-700 mb-2">Teléfono:</label>
                    <input type="tel" id="telefono" name="telefono"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none transition duration-200"
                            placeholder="Ej: +54 9 11 1234 5678">
                </div>
                <!-- Campo Contraseña -->
                <div>
                    <label for="signupPassword" class="block text-sm font-medium text-gray-700 mb-2">Contraseña:</label>
                    <input type="password" id="signupPassword" name="signupPassword"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none transition duration-200"
                            placeholder="••••••••">
                </div>
                <!-- Botón de Registrarse -->
                <button type="submit"
                    class="w-full bg-purple-600 hover:bg-purple-700 text-white font-semibold py-3 px-6 rounded-lg flex items-center justify-center transition duration-300 transform hover:scale-105 shadow-md">
                    Regístrate
                    <!-- Flecha hacia la derecha -->
                    <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                    </svg>
                </button>
            </form>
        </main>
    </div>
  </div>
</body>
</html>