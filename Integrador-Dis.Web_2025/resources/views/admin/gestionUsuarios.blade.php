@extends('app')
@section('tittle', 'AureaCursos - Gestion de Usuarios')
@push('css')
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
@endpush

@section('contenido')
    <!-- aca el contenido para agregar -->
     <main class="flex-grow p-8 bg-gray-50">
        <section class="bg-white rounded-xl shadow-lg p-8 mb-8 border border-gray-200">
            <h2 class="text-4xl font-extrabold text-custom-dark-purple mb-8 text-center">Gestión de Usuarios</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Left Column: User Image -->
                <div class="md:col-span-1 flex flex-col items-center justify-center p-4 bg-gray-100 rounded-lg border border-gray-200 shadow-sm">
                    <div class="w-48 h-48 bg-gray-300 rounded-lg flex items-center justify-center overflow-hidden mb-4 border-2 border-gray-400">
                        <img id="userImagePreview" src="https://placehold.co/192x192/CCCCCC/333333?text=Imagen%20de%20usuario" alt="User image preview" class="object-cover w-full h-full">
                    </div>
                    <input type="file" id="userImage" class="hidden" accept="image/*" onchange="previewUserImage(event)">
                    <label for="userImage" class="bg-custom-lilac text-custom-white px-6 py-2 rounded-full font-semibold cursor-pointer hover:bg-gradient-custom-lilac transform hover-scale-105 transition-all shadow-md">
                        Añadir foto
                    </label>
                </div>

                <!-- Central and Right Columns: Form Fields -->
                <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-3 gap-x-6 gap-y-4">
                    <!-- Row 1 -->
                    <div>
                        <label for="names" class="block text-gray-700 text-lg font-semibold mb-2">Nombre/s:</label>
                        <input type="text" id="names" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-custom-lilac shadow-sm" placeholder="Ej: Juan">
                    </div>
                    <div>
                        <label for="surnames" class="block text-gray-700 text-lg font-semibold mb-2">Apellido/s:</label>
                        <input type="text" id="surnames" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-custom-lilac shadow-sm" placeholder="Ej: Pérez">
                    </div>
                    <div>
                        <label for="dni" class="block text-gray-700 text-lg font-semibold mb-2">DNI:</label>
                        <input type="text" id="dni" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-custom-lilac shadow-sm" placeholder="Ej: 12345678">
                    </div>

                    <!-- Row 2 -->
                    <div>
                        <label for="gender" class="block text-gray-700 text-lg font-semibold mb-2">Género:</label>
                        <select id="gender" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-custom-lilac shadow-sm">
                            <option value="">Selecciona</option>
                            <option value="Masculino">Masculino</option>
                            <option value="Femenino">Femenino</option>
                            <option value="Otro">Otro</option>
                        </select>
                    </div>
                    <div class="relative">
                        <label for="birthDate" class="block text-gray-700 text-lg font-semibold mb-2">Fecha de nacimiento:</label>
                        <input type="date" id="birthDate" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-custom-lilac shadow-sm pr-10">
                    </div>
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

                    <!-- Row 3 -->
                    <div>
                        <label for="email" class="block text-gray-700 text-lg font-semibold mb-2">Correo:</label>
                        <input type="email" id="email" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-custom-lilac shadow-sm" placeholder="Ej: usuario@example.com">
                    </div>
                    <div>
                        <label for="phone" class="block text-gray-700 text-lg font-semibold mb-2">Teléfono:</label>
                        <input type="tel" id="phone" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-custom-lilac shadow-sm" placeholder="Ej: +5491112345678">
                    </div>
                    <div>
                        <label for="password" class="block text-gray-700 text-lg font-semibold mb-2">Contraseña:</label>
                        <input type="password" id="password" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-custom-lilac shadow-sm" placeholder="********">
                    </div>

                    <!-- Row 4: Role selection -->
                    <div class="col-span-3">
                        <label for="role" class="block text-gray-700 text-lg font-semibold mb-2">Rol:</label>
                        <div class="flex items-center">
                            <select id="roleSelect" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-custom-lilac shadow-sm">
                                <option value="">Selecciona un rol</option>
                                <option value="Administrador">Administrador</option>
                                <option value="Docente">Docente</option>
                                <option value="Estudiante">Estudiante</option>
                                <option value="Invitado">Invitado</option>
                            </select>
                            <button onclick="addNewRole()" class="ml-2 bg-custom-lilac text-custom-white px-4 py-2 rounded-full font-semibold shadow-md hover:bg-gradient-custom-lilac transition-all transform hover-scale-105" title="Añadir nuevo rol">
                                Nuevo Rol
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="mt-8 flex justify-end space-x-4">
                <button onclick="deleteUser()" class="bg-red-600 text-white px-8 py-3 rounded-full font-bold shadow-lg hover:bg-red-700 transition-all transform hover-scale-105">
                    Eliminar
                </button>
                <button onclick="saveUser()" class="bg-emerald-500 text-white px-8 py-3 rounded-full font-bold shadow-lg hover:bg-emerald-600 transition-all transform hover-scale-105">
                    Guardar
                </button>
            </div>
        </section>

        <!-- Registered Users -->
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
                        <!-- Example data row (will be loaded from Firestore) -->
                        <tr class="border-b border-gray-200 hover:bg-gray-50 transition-all">
                            <td class="py-3 px-4 text-gray-800">Juan Pérez</td>
                            <td class="py-3 px-4 text-gray-800">12345678</td>
                            <td class="py-3 px-4 text-gray-800">juan.perez@example.com</td>
                            <td class="py-3 px-4 text-gray-800">Estudiante</td>
                            <td class="py-3 px-4">
                                <button onclick="editUser('${userId}')" class="text-custom-purple hover:text-custom-dark-purple mr-3"><i class="fas fa-edit"></i> Edit</button>
                                <button onclick="deleteRegisteredUser('${userId}')" class="text-red-600 hover:text-red-800"><i class="fas fa-trash-alt"></i> Delete</button>
                            </td>
                        </tr>
                        <tr class="border-b border-gray-200 hover:bg-gray-50 transition-all">
                            <td class="py-3 px-4 text-gray-800">María García</td>
                            <td class="py-3 px-4 text-gray-800">87654321</td>
                            <td class="py-3 px-4 text-gray-800">maria.garcia@example.com</td>
                            <td class="py-3 px-4 text-gray-800">Docente, Invitado</td>
                            <td class="py-3 px-4">
                                <button class="text-custom-purple hover:text-custom-dark-purple mr-3"><i class="fas fa-edit"></i> Edit</button>
                                <button class="text-red-600 hover:text-red-800"><i class="fas fa-trash-alt"></i> Delete</button>
                            </td>
                        </tr>
                        <!-- Rows will be loaded dynamically -->
                    </tbody>
                </table>
            </div>
        </section>
    </main>
@endsection

@push('scripts')
    <script src="{{asset('js/scripts.js')}}"></script>
@endpush