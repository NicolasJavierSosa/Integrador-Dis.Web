<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>AureaCursos - Iniciar Sesión</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{asset('css/style.css')}}" />
</head>
<body class="min-h-screen bg-gradient-to-br from-purple-50 to-indigo-100 flex items-center justify-center p-4">
  <div id="pantalla" class="w-full max-w-md bg-white rounded-xl shadow-xl overflow-hidden border border-gray-200">
    <header class="bg-purple-700 p-4 flex items-center justify-start rounded-t-xl">
      <div id="icono-logo" class="mr-3">
        <img src="{{ asset('images/default/logo.png') }}" alt="Logo del Instituto" id="logo-img" class="w-8 h-8">
      </div>
      <h1 class="text-white text-lg font-semibold">Instituto Aurea</h1>
    </header>
    
    <div class="p-8">
      <!-- Pestañas de Login y Sign Up -->
      <div class="flex bg-gray-100 rounded-full p-1 mb-6 border border-gray-300">
        <button id="loginTab" class="flex-1 py-2 px-4 text-center text-purple-700 font-medium bg-white rounded-full shadow-sm">
        Iniciar Sesion</button>
        <button id="signupTab" class="flex-1 py-2 px-4 text-center text-gray-600 font-medium rounded-full">
        Registrarse</button>
      </div>

      <!-- Mostrar errores de sesión -->
      @if(session('error'))
        <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded-lg">
          <span class="block sm:inline">{{ session('error') }}</span>
        </div>
      @endif

      @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded-lg">
          <span class="block sm:inline">{{ session('success') }}</span>
        </div>
      @endif

      <!-- Mostrar errores de validación -->
      @if($errors->any())
        <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded-lg">
          <ul class="list-disc list-inside text-sm">
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <main id="loginFormContainer">
        <form id="login-form" method="POST" action="{{ route('login.post') }}" class="space-y-6">
          @csrf
          
          <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Correo:</label>
            <input type="email" 
                   id="email" 
                   name="email" 
                   value="{{ old('email') }}"
                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none transition duration-200 @error('email') border-red-500 @enderror"
                   placeholder="tu.correo@example.com"
                   required
                   autofocus>
            @error('email')
              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>
          
          <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Contraseña:</label>
            <input type="password" 
                   id="password" 
                   name="password"
                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none transition duration-200 @error('password') border-red-500 @enderror"
                   placeholder="••••••••"
                   required>
            @error('password')
              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>

          <!-- Checkbox Remember Me -->
          <div class="flex items-center">
            <input id="remember" 
                   name="remember" 
                   type="checkbox" 
                   class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
            <label for="remember" class="ml-2 block text-sm text-gray-700">
              Recordarme
            </label>
          </div>
          
          <button type="submit"
                  class="w-full bg-purple-600 hover:bg-purple-700 text-white font-semibold py-3 px-6 rounded-lg flex items-center justify-center transition duration-300 transform hover:scale-105 shadow-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
            Iniciar sesión
            <!-- Flecha hacia la derecha -->
            <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
            </svg>
          </button>
        </form>
        
        <!-- Enlaces adicionales -->
        <div class="mt-6 space-y-2">
          <p class="text-center text-sm text-gray-600">
            ¿Olvidaste tu contraseña? 
            <a href="#" class="font-medium text-purple-600 hover:text-purple-500 hover:underline">
              Recuperar contraseña
            </a>
          </p>
          
        </div>
      </main>
    </div>
  </div>

  <!-- Script para mejorar la experiencia de usuario -->
  <script>
    // Auto-hide success/error messages after 5 seconds
    setTimeout(function() {
      const alerts = document.querySelectorAll('.bg-red-100, .bg-green-100');
      alerts.forEach(function(alert) {
        alert.style.transition = 'opacity 0.5s ease-out';
        alert.style.opacity = '0';
        setTimeout(function() {
          alert.remove();
        }, 500);
      });
    }, 5000);

    // Add loading state to submit button
    document.getElementById('login-form').addEventListener('submit', function(e) {
      const submitBtn = this.querySelector('button[type="submit"]');
      const originalText = submitBtn.innerHTML;
      
      submitBtn.disabled = true;
      submitBtn.innerHTML = `
        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
          <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
          <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        Iniciando sesión...
      `;
      
      // Restore button if form submission fails
      setTimeout(function() {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
      }, 10000);
    });
  </script>
</body>
</html>