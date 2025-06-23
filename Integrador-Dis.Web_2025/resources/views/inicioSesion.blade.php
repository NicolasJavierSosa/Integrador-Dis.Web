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
        <button id="loginTab" class="flex-1 py-2 px-4 text-center text-purple-700 font-medium bg-white rounded-full shadow-sm">
        Iniciar Sesion</button>
        <button id="signupTab" class="flex-1 py-2 px-4 text-center text-gray-600 font-medium rounded-full">
        Registrarse</button>
      </div>
    <main id="loginFormContainer">
      <form id="login-form" method="POST" action="#" class="space-y-6">
        <div>
          <label for="loginEmail" class="block text-sm font-medium text-gray-700 mb-2">Correo:</label>
          <input type="email" id="loginEmail" name="loginEmail"
            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none transition duration-200"
            placeholder="tu.correo@example.com">
        </div>
        <div>
          <label for="loginPassword" class="block text-sm font-medium text-gray-700 mb-2">Contraseña:</label>
          <input type="password" id="loginPassword" name="loginPassword"
            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none transition duration-200"
            placeholder="••••••••">
        </div>
        <button type="submit"
          class="w-full bg-purple-600 hover:bg-purple-700 text-white font-semibold py-3 px-6 rounded-lg flex items-center justify-center transition duration-300 transform hover:scale-105 shadow-md">
          Iniciar sesión
        <!-- Flecha hacia la derecha -->
          <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
          </svg>
        </button>
      </form>
      <p class="mt-6 text-center text-sm text-gray-600">
        ¿No tienes cuenta? <a href="registro.php" id="switchToSignupLink" class="font-medium text-purple-600 hover:text-purple-500 hover:underline">Regístrate</a>
      </p>
    </main>
    </div>
  </div>
</body>
</html>