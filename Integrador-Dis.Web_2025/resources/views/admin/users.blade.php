@extends('layouts.app')
@section('tittle', 'AureaCursos - Gestion de Usuarios')
@push('css')
    <link rel="stylesheet" href="{{asset('css/gestion.css')}}">
@endpush

@section('contenido')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Mensajes de éxito/error -->
    @if(session('success'))
        <div id="success-message" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            <span class="block sm:inline">{{ session('success') }}</span>
            <button onclick="this.parentElement.style.display='none'" class="float-right text-green-700 hover:text-green-900">&times;</button>
        </div>
    @endif

    @if(session('error'))
        <div id="error-message" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <span class="block sm:inline">{{ session('error') }}</span>
            <button onclick="this.parentElement.style.display='none'" class="float-right text-red-700 hover:text-red-900">&times;</button>
        </div>
    @endif

    @if($errors->any())
        <div id="validation-errors" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button onclick="this.parentElement.style.display='none'" class="float-right text-red-700 hover:text-red-900">&times;</button>
        </div>
    @endif

    <!-- Errores AJAX -->
    <div id="ajax-errors" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4" style="display: none;">
        <ul id="ajax-error-list" class="list-disc list-inside"></ul>
        <button onclick="clearErrors()" class="float-right text-red-700 hover:text-red-900">&times;</button>
    </div>

    <!-- Éxito AJAX -->
    <div id="ajax-success" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4" style="display: none;">
        <span id="ajax-success-message"></span>
        <button onclick="clearSuccess()" class="float-right text-green-700 hover:text-green-900">&times;</button>
    </div>

    <main class="flex-grow p-8 bg-gray-50">
        <!-- Formulario de creación de usuarios -->
        <section id="creation" class="bg-white rounded-xl shadow-lg p-8 mb-8 border border-gray-200" style="display: none;">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-4xl font-extrabold text-custom-dark-purple">Crear Nuevo Usuario</h2>
                <button onclick="hideCreateForm()" class="text-red-600 hover:text-red-800 text-xl font-bold">✕</button>
            </div>
            
            <form action="{{ route('admin.users.create') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-3 gap-x-6 gap-y-4">
                    <!-- Fila 1 -->
                    <div>
                        <label for="name" class="block text-gray-700 text-lg font-semibold mb-2">Nombre/s:</label>
                        <input type="text" id="name" name="name" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-custom-lilac shadow-sm" placeholder="Ej: Juan" required>
                    </div>
                    <div>
                        <label for="surname" class="block text-gray-700 text-lg font-semibold mb-2">Apellido/s:</label>
                        <input type="text" id="surname" name="surname" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-custom-lilac shadow-sm" placeholder="Ej: Pérez" required>
                    </div>
                    <div>
                        <label for="dni" class="block text-gray-700 text-lg font-semibold mb-2">DNI:</label>
                        <input type="number" id="dni" name="dni" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-custom-lilac shadow-sm" placeholder="12345678" required min="10000000" max="99999999">
                    </div>

                    <!-- Fila 2 -->
                    <div>
                        <label for="gender" class="block text-gray-700 text-lg font-semibold mb-2">Género:</label>
                        <select id="gender" name="gender" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-custom-lilac shadow-sm">
                            <option value="">Selecciona</option>
                            <option value="M">Masculino</option>
                            <option value="F">Femenino</option>
                            <option value="X">Otro</option>
                        </select>
                    </div>
                    <div>
                        <label for="birth_date" class="block text-gray-700 text-lg font-semibold mb-2">Fecha de nacimiento:</label>
                        <input type="date" id="birth_date" name="birth_date" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-custom-lilac shadow-sm">
                    </div>
                    <div>
                        <label for="address" class="block text-gray-700 text-lg font-semibold mb-2">Ciudad:</label>
                        <input list="ciudades" id="address" name="address"
                                class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none transition duration-200"
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

                    <!-- Fila 3 -->
                    <div>
                        <label for="email" class="block text-gray-700 text-lg font-semibold mb-2">Correo:</label>
                        <input type="email" id="email" name="email" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-custom-lilac shadow-sm" placeholder="Ej: usuario@example.com" required>
                    </div>
                    <div>
                        <label for="phone" class="block text-gray-700 text-lg font-semibold mb-2">Teléfono:</label>
                        <input type="tel" id="phone" name="phone" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-custom-lilac shadow-sm" placeholder="Ej: +5491112345678">
                    </div>
                    <div>
                        <label for="role" class="block text-gray-700 text-lg font-semibold mb-2">Rol:</label>
                        <select id="role" name="role" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-custom-lilac shadow-sm" required>
                            <option value="">Selecciona un rol</option>
                            <option value="admin">Administrador</option>
                            <option value="teacher">Docente</option>
                            <option value="student">Estudiante</option>
                        </select>
                    </div>

                    <!-- Fila 4 - Campos de contraseña -->
                    <div>
                        <label for="password" class="block text-gray-700 text-lg font-semibold mb-2">Contraseña:</label>
                        <input type="password" id="password" name="password" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-custom-lilac shadow-sm" placeholder="********" required>
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-gray-700 text-lg font-semibold mb-2">Confirmar Contraseña:</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-custom-lilac shadow-sm" placeholder="********" required>
                    </div>
                </div>
                
                <!-- Botones de acción -->
                <div class="mt-8 flex justify-end space-x-4">
                    <button type="button" onclick="hideCreateForm()" class="bg-red-600 text-white px-8 py-3 rounded-full font-bold shadow-lg hover:bg-red-700 transition-all transform hover-scale-105">
                        Cancelar
                    </button>
                    <button type="submit" class="bg-emerald-500 text-white px-8 py-3 rounded-full font-bold shadow-lg hover:bg-emerald-600 transition-all transform hover-scale-105">
                        Guardar
                    </button>
                </div>
            </form>
        </section>

        <!-- Formulario de edición de usuarios -->
        <section id="edition" class="bg-white rounded-xl shadow-lg p-8 mb-8 border border-gray-200" style="display: none;">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-4xl font-extrabold text-custom-dark-purple">Editar Usuario</h2>
                <button onclick="cancelEdit()" class="text-red-600 hover:text-red-800 text-xl font-bold">✕</button>
            </div>
            
            <form id="edition-form" action="{{ route('admin.users.update') }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" id="user_id" name="user_id">
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-x-6 gap-y-4">
                    <!-- Fila 1 formulario de edición -->
                    <div>
                        <label for="edit_name" class="block text-gray-700 text-lg font-semibold mb-2">Nombre/s:</label>
                        <input type="text" id="edit_name" name="name" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-custom-lilac shadow-sm" placeholder="Ej: Juan" required>
                    </div>
                    <div>
                        <label for="edit_surname" class="block text-gray-700 text-lg font-semibold mb-2">Apellido/s:</label>
                        <input type="text" id="edit_surname" name="surname" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-custom-lilac shadow-sm" placeholder="Ej: Pérez" required>
                    </div>
                    <div>
                        <label for="edit_dni" class="block text-gray-700 text-lg font-semibold mb-2">DNI:</label>
                        <input type="number" id="edit_dni" name="dni" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-custom-lilac shadow-sm" placeholder="12345678" required min="10000000" max="99999999">
                    </div>

                    <!-- Fila 2 -->
                    <div>
                        <label for="edit_gender" class="block text-gray-700 text-lg font-semibold mb-2">Género:</label>
                        <select id="edit_gender" name="gender" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-custom-lilac shadow-sm">
                            <option value="">Selecciona</option>
                            <option value="M">Masculino</option>
                            <option value="F">Femenino</option>
                            <option value="X">Otro</option>
                        </select>
                    </div>
                    <div>
                        <label for="edit_birth_date" class="block text-gray-700 text-lg font-semibold mb-2">Fecha de nacimiento:</label>
                        <input type="date" id="edit_birth_date" name="birth_date" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-custom-lilac shadow-sm">
                    </div>
                    <div>
                        <label for="edit_address" class="block text-gray-700 text-lg font-semibold mb-2">Ciudad:</label>
                        <input list="edit_ciudades" id="edit_address" name="address"
                                class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none transition duration-200"
                                placeholder="Escribí tu ciudad">
                        <datalist id="edit_ciudades">
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

                    <!-- Fila 3 -->
                    <div>
                        <label for="edit_email" class="block text-gray-700 text-lg font-semibold mb-2">Correo:</label>
                        <input type="email" id="edit_email" name="email" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-custom-lilac shadow-sm" placeholder="Ej: usuario@example.com" required>
                    </div>
                    <div>
                        <label for="edit_phone" class="block text-gray-700 text-lg font-semibold mb-2">Teléfono:</label>
                        <input type="tel" id="edit_phone" name="phone" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-custom-lilac shadow-sm" placeholder="Ej: +5491112345678">
                    </div>
                    <div>
                        <label for="edit_role" class="block text-gray-700 text-lg font-semibold mb-2">Rol:</label>
                        <select id="edit_role" name="role" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-custom-lilac shadow-sm" required>
                            <option value="">Selecciona un rol</option>
                            <option value="admin">Administrador</option>
                            <option value="teacher">Docente</option>
                            <option value="student">Estudiante</option>
                        </select>
                    </div>

                    <!-- Fila 4 - Campos de contraseña -->
                    <div>
                        <label for="edit_password" class="block text-gray-700 text-lg font-semibold mb-2">Nueva Contraseña (opcional):</label>
                        <input type="password" id="edit_password" name="password" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-custom-lilac shadow-sm" placeholder="Dejar vacío para mantener actual">
                    </div>
                    <div>
                        <label for="edit_password_confirmation" class="block text-gray-700 text-lg font-semibold mb-2">Confirmar Nueva Contraseña:</label>
                        <input type="password" id="edit_password_confirmation" name="password_confirmation" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-custom-lilac shadow-sm" placeholder="Confirmar nueva contraseña">
                    </div>
                </div>
                
                <div class="mt-8 flex justify-end space-x-4">
                    <button type="button" onclick="cancelEdit()" class="bg-red-600 text-white px-8 py-3 rounded-full font-bold shadow-lg hover:bg-red-700 transition-all transform hover-scale-105">
                        Cancelar
                    </button>
                    <button type="submit" class="bg-emerald-500 text-white px-8 py-3 rounded-full font-bold shadow-lg hover:bg-emerald-600 transition-all transform hover-scale-105">
                        Actualizar Usuario
                    </button>
                </div>
            </form>
        </section>

        <!-- Botón agregar usuario -->
        <div class="mb-8 text-center">
            <button onclick="showCreateForm()" class="bg-purple-600 text-white px-8 py-3 rounded-full font-bold shadow-lg hover:bg-purple-700 transition-all transform hover:scale-105">
                Agregar Nuevo Usuario
            </button>
        </div>

        <!-- Usuarios registrados -->
        <section class="bg-white rounded-xl shadow-lg p-8 border border-gray-200 mt-8">
            <h2 class="text-3xl font-extrabold text-custom-dark-purple mb-6">Usuarios registrados:</h2>
            <div class="w-full overflow-x-auto">
                <table id="registeredUsersTable" class="min-w-full bg-white rounded-lg shadow-md">
                    <thead>
                        <tr class="bg-custom-lilac text-custom-white">
                            <th class="py-3 px-4 text-left text-sm font-semibold uppercase tracking-wider rounded-tl-lg">Nombre Completo</th>
                            <th class="py-3 px-4 text-left text-sm font-semibold uppercase tracking-wider">DNI</th>
                            <th class="py-3 px-4 text-left text-sm font-semibold uppercase tracking-wider">Correo</th>
                            <th class="py-3 px-4 text-left text-sm font-semibold uppercase tracking-wider">Rol/es</th>
                            <th class="py-3 px-4 text-left text-sm font-semibold uppercase tracking-wider rounded-tr-lg">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr class="border-b border-gray-200 hover:bg-gray-50 transition-all">
                            <td class="py-3 px-4 text-gray-800">{{ $user->name }} {{ $user->surname }}</td>
                            <td class="py-3 px-4 text-gray-800">{{ $user->dni }}</td>
                            <td class="py-3 px-4 text-gray-800">{{ $user->email }}</td>
                            <td class="py-3 px-4 text-gray-800">{{ ucfirst($user->role) }}</td>
                            <td class="py-3 px-4">
                                <button onclick="editUser('{{ $user->id }}')" class="text-custom-purple hover:text-custom-dark-purple mr-3">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}" class="inline" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este usuario?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800">
                                        <i class="fas fa-trash-alt"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    </main>
@endsection

@push('scripts')
    <script src="{{asset('js/admin/scripts.js')}}"></script>
@endpush