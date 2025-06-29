<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>AureaCursos - Registro</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{asset('css/style.css')}}" />
</head>
<body class="min-h-screen bg-gradient-to-br from-purple-50 to-indigo-100 flex items-center justify-center p-4">
    <div id="pantalla" class="w-full max-w-4xl bg-white rounded-xl shadow-xl overflow-hidden border border-gray-200">
        <header class="bg-purple-700 p-4 flex items-center justify-start rounded-t-xl">
            <div id="icono-logo" class="mr-3">
                <img src="{{ asset('images/default/logo.png') }}" alt="Logo del Instituto" id="logo-img" class="w-8 h-8">
            </div>
            <h1 class="text-white text-lg font-semibold">Instituto XXX</h1>
        </header>
        
        <div class="p-8">
            <!-- Pestañas de Login y Sign Up -->
            <div class="flex bg-gray-100 rounded-full p-1 mb-6 border border-gray-300 max-w-md mx-auto">
                <button id="loginTab" onclick="window.location='{{ route('login') }}'" class="flex-1 py-2 px-4 text-center text-gray-600 font-medium rounded-full hover:bg-gray-200 transition duration-200">
                    Iniciar Sesión
                </button>
                <button id="signupTab" class="flex-1 py-2 px-4 text-center text-purple-700 font-medium bg-white rounded-full shadow-sm">
                    Registrarse
                </button>
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

            <main id="registerFormContainer">
                <form id="register-form" method="POST" action="{{ route('register.post') }}" class="space-y-6">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Fila 1 -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nombre/s:</label>
                            <input type="text" 
                                   id="name" 
                                   name="name"
                                   value="{{ old('name') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none transition duration-200 @error('name') border-red-500 @enderror"
                                   placeholder="Tu nombre(s)"
                                   required>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="surname" class="block text-sm font-medium text-gray-700 mb-2">Apellido/s:</label>
                            <input type="text" 
                                   id="surname" 
                                   name="surname"
                                   value="{{ old('surname') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none transition duration-200 @error('surname') border-red-500 @enderror"
                                   placeholder="Tu apellido(s)"
                                   required>
                            @error('surname')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="dni" class="block text-sm font-medium text-gray-700 mb-2">DNI:</label>
                            <input type="number" 
                                   id="dni" 
                                   name="dni"
                                   value="{{ old('dni') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none transition duration-200 @error('dni') border-red-500 @enderror"
                                   placeholder="12345678"
                                   min="10000000" 
                                   max="99999999"
                                   required>
                            @error('dni')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Fila 2 -->
                        <div>
                            <label for="gender" class="block text-sm font-medium text-gray-700 mb-2">Género:</label>
                            <select id="gender" 
                                    name="gender"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none transition duration-200 @error('gender') border-red-500 @enderror">
                                <option value="">Selecciona</option>
                                <option value="M" {{ old('gender') == 'M' ? 'selected' : '' }}>Masculino</option>
                                <option value="F" {{ old('gender') == 'F' ? 'selected' : '' }}>Femenino</option>
                                <option value="X" {{ old('gender') == 'X' ? 'selected' : '' }}>Otro</option>
                            </select>
                            @error('gender')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="birth_date" class="block text-sm font-medium text-gray-700 mb-2">Fecha de Nacimiento:</label>
                            <input type="date" 
                                   id="birth_date" 
                                   name="birth_date"
                                   value="{{ old('birth_date') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none transition duration-200 @error('birth_date') border-red-500 @enderror">
                            @error('birth_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Ciudad:</label>
                            <input list="ciudades" 
                                   id="address" 
                                   name="address"
                                   value="{{ old('address') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none transition duration-200 @error('address') border-red-500 @enderror"
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
                            @error('address')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Fila 3 -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Correo electrónico:</label>
                            <input type="email" 
                                   id="email" 
                                   name="email"
                                   value="{{ old('email') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none transition duration-200 @error('email') border-red-500 @enderror"
                                   placeholder="tu.correo@example.com"
                                   required>
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Teléfono:</label>
                            <input type="tel" 
                                   id="phone" 
                                   name="phone"
                                   value="{{ old('phone') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none transition duration-200 @error('phone') border-red-500 @enderror"
                                   placeholder="Ej: +54 9 11 1234 5678">
                            @error('phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="role" class="block text-sm font-medium text-gray-700 mb-2">Tipo de cuenta:</label>
                            <select id="role" 
                                    name="role"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none transition duration-200 @error('role') border-red-500 @enderror"
                                    required>
                                <option value="">Selecciona tu rol</option>
                                <option value="student" {{ old('role') == 'student' ? 'selected' : '' }}>Estudiante</option>
                                <option value="teacher" {{ old('role') == 'teacher' ? 'selected' : '' }}>Docente</option>
                            </select>
                            @error('role')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Fila 4 - Contraseñas -->
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
                        
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirmar Contraseña:</label>
                            <input type="password" 
                                   id="password_confirmation" 
                                   name="password_confirmation"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none transition duration-200"
                                   placeholder="••••••••"
                                   required>
                        </div>
                    </div>

                    <!-- Términos y condiciones -->
                    <div class="flex items-center">
                        <input id="terms" 
                               name="terms" 
                               type="checkbox" 
                               class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded"
                               required>
                        <label for="terms" class="ml-2 block text-sm text-gray-700">
                            Acepto los <a href="#" class="text-purple-600 hover:text-purple-500 underline">términos y condiciones</a>
                        </label>
                    </div>
                    
                    <!-- Botón de Registrarse -->
                    <button type="submit"
                            class="w-full bg-purple-600 hover:bg-purple-700 text-white font-semibold py-3 px-6 rounded-lg flex items-center justify-center transition duration-300 transform hover:scale-105 shadow-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
                        Regístrate
                        <!-- Flecha hacia la derecha -->
                        <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </button>
                </form>
                
                <!-- Enlaces adicionales -->
                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">
                        ¿Ya tienes cuenta? 
                        <a href="{{ route('login') }}" class="font-medium text-purple-600 hover:text-purple-500 hover:underline">
                            Inicia sesión
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
        document.getElementById('register-form').addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            
            submitBtn.disabled = true;
            submitBtn.innerHTML = `
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Registrando...
            `;
            
            // Restore button if form submission fails
            setTimeout(function() {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            }, 10000);
        });

        // Password confirmation validation
        document.getElementById('password_confirmation').addEventListener('input', function() {
            const password = document.getElementById('password').value;
            const confirmation = this.value;
            
            if (password !== confirmation && confirmation.length > 0) {
                this.setCustomValidity('Las contraseñas no coinciden');
            } else {
                this.setCustomValidity('');
            }
        });
    </script>
</body>
</html>