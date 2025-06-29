@extends('layouts.app')
@section('tittle', 'AureaCursos - Dashboard Administrador')
@push('css')
    <link rel="stylesheet" href="{{asset('css/inicios.css')}}">
@endpush

@section('contenido')
    <div class="min-h-screen bg-gradient-to-br from-purple-50 to-indigo-100">
        <div class="container mx-auto px-4 py-8">
            <!-- Header del Dashboard -->
            <div class="text-center mb-12">
                <h1 class="text-5xl font-extrabold text-gray-800 mb-4">
                    Panel de Administración
                </h1>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Bienvenido al centro de control de AureaCursos. Gestiona usuarios, cursos y permisos desde aquí.
                </p>
            </div>

            <!-- Estadísticas rápidas -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-12">
                <!-- Total Usuarios -->
                <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-purple-500">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                            <i class="fas fa-users text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total Usuarios</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $users->count() ?? 0 }}</p>
                        </div>
                    </div>
                </div>

                <!-- Total Cursos -->
                <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-500">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                            <i class="fas fa-book text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total Cursos</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $courses->count() ?? 0 }}</p>
                        </div>
                    </div>
                </div>

                <!-- Administradores -->
                <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-green-500">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100 text-green-600">
                            <i class="fas fa-user-shield text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Administradores</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $users->where('role', 'admin')->count() ?? 0 }}</p>
                        </div>
                    </div>
                </div>

                <!-- Docentes -->
                <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-yellow-500">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                            <i class="fas fa-chalkboard-teacher text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Docentes</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $users->where('role', 'teacher')->count() ?? 0 }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tarjetas de gestión principales -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
                <!-- Gestión de Usuarios -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden transform hover:scale-105 transition-all duration-300">
                    <div class="bg-gradient-to-r from-purple-600 to-purple-700 p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-2xl font-bold text-white">Gestión de Usuarios</h3>
                                <p class="text-purple-100 mt-2">Administra cuentas de usuarios</p>
                            </div>
                            <div class="bg-white bg-opacity-20 p-3 rounded-full">
                                <i class="fas fa-users text-3xl text-white"></i>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                <span>Crear nuevos usuarios</span>
                            </div>
                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                <span>Editar información de usuarios</span>
                            </div>
                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                <span>Asignar roles y permisos</span>
                            </div>
                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                <span>Gestionar estados de cuenta</span>
                            </div>
                        </div>
                        <div class="mt-8">
                            <a href="{{ route('admin.users') }}" class="w-full bg-gradient-to-r from-purple-600 to-purple-700 text-white py-3 px-6 rounded-xl font-semibold text-center block hover:from-purple-700 hover:to-purple-800 transition-all duration-300 shadow-lg hover:shadow-xl">
                                <i class="fas fa-arrow-right mr-2"></i>
                                Ir a Gestión de Usuarios
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Gestión de Cursos -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden transform hover:scale-105 transition-all duration-300">
                    <div class="bg-gradient-to-r from-blue-600 to-blue-700 p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-2xl font-bold text-white">Gestión de Cursos</h3>
                                <p class="text-blue-100 mt-2">Administra contenido educativo</p>
                            </div>
                            <div class="bg-white bg-opacity-20 p-3 rounded-full">
                                <i class="fas fa-graduation-cap text-3xl text-white"></i>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                <span>Crear y editar cursos</span>
                            </div>
                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                <span>Asignar docentes a cursos</span>
                            </div>
                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                <span>Gestionar inscripciones</span>
                            </div>
                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                <span>Monitorear progreso</span>
                            </div>
                        </div>
                        <div class="mt-8">
                            <a href="{{ route('admin.courses') }}" class="w-full bg-gradient-to-r from-blue-600 to-blue-700 text-white py-3 px-6 rounded-xl font-semibold text-center block hover:from-blue-700 hover:to-blue-800 transition-all duration-300 shadow-lg hover:shadow-xl">
                                <i class="fas fa-arrow-right mr-2"></i>
                                Ir a Gestión de Cursos
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Roles y Permisos -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden transform hover:scale-105 transition-all duration-300">
                    <div class="bg-gradient-to-r from-emerald-600 to-emerald-700 p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-2xl font-bold text-white">Roles y Permisos</h3>
                                <p class="text-emerald-100 mt-2">Controla accesos del sistema</p>
                            </div>
                            <div class="bg-white bg-opacity-20 p-3 rounded-full">
                                <i class="fas fa-key text-3xl text-white"></i>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                <span>Crear y editar roles</span>
                            </div>
                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                <span>Asignar permisos específicos</span>
                            </div>
                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                <span>Gestionar niveles de acceso</span>
                            </div>
                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                <span>Auditar permisos de usuario</span>
                            </div>
                        </div>
                        <div class="mt-8">
                            <a href="{{ route('admin.roles') }}" class="w-full bg-gradient-to-r from-emerald-600 to-emerald-700 text-white py-3 px-6 rounded-xl font-semibold text-center block hover:from-emerald-700 hover:to-emerald-800 transition-all duration-300 shadow-lg hover:shadow-xl">
                                <i class="fas fa-arrow-right mr-2"></i>
                                Ir a Roles y Permisos
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actividad reciente -->
            <div class="bg-white rounded-xl shadow-lg p-8">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Actividad Reciente</h2>
                    <button class="text-purple-600 hover:text-purple-800 font-medium">
                        Ver todo
                        <i class="fas fa-arrow-right ml-1"></i>
                    </button>
                </div>
                
                <div class="space-y-4">
                    <!-- Elementos de actividad reciente -->
                    <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                        <div class="w-2 h-2 bg-green-500 rounded-full mr-4"></div>
                        <div class="flex-1">
                            <p class="text-gray-800 font-medium">Usuario creado exitosamente</p>
                            <p class="text-gray-500 text-sm">Hace 2 minutos</p>
                        </div>
                        <i class="fas fa-user-plus text-green-500"></i>
                    </div>
                    
                    <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                        <div class="w-2 h-2 bg-blue-500 rounded-full mr-4"></div>
                        <div class="flex-1">
                            <p class="text-gray-800 font-medium">Curso actualizado</p>
                            <p class="text-gray-500 text-sm">Hace 15 minutos</p>
                        </div>
                        <i class="fas fa-edit text-blue-500"></i>
                    </div>
                    
                    <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                        <div class="w-2 h-2 bg-purple-500 rounded-full mr-4"></div>
                        <div class="flex-1">
                            <p class="text-gray-800 font-medium">Permisos modificados</p>
                            <p class="text-gray-500 text-sm">Hace 1 hora</p>
                        </div>
                        <i class="fas fa-key text-purple-500"></i>
                    </div>
                </div>
            </div>

            <!-- Accesos rápidos -->
            <div class="mt-12 bg-gradient-to-r from-purple-600 to-blue-600 rounded-xl p-8 text-white">
                <h2 class="text-2xl font-bold mb-6">Accesos Rápidos</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <button class="bg-white bg-opacity-20 p-4 rounded-lg hover:bg-opacity-30 transition-all duration-300" onclick="window.location.href='{{ route('admin.users') }}'">
                        <i class="fas fa-user-plus text-2xl mb-2"></i>
                        <p class="text-sm font-medium">Nuevo Usuario</p>
                    </button>
                    <button class="bg-white bg-opacity-20 p-4 rounded-lg hover:bg-opacity-30 transition-all duration-300">
                        <i class="fas fa-plus-circle text-2xl mb-2"></i>
                        <p class="text-sm font-medium">Nuevo Curso</p>
                    </button>
                    <button class="bg-white bg-opacity-20 p-4 rounded-lg hover:bg-opacity-30 transition-all duration-300">
                        <i class="fas fa-chart-bar text-2xl mb-2"></i>
                        <p class="text-sm font-medium">Reportes</p>
                    </button>
                    <button class="bg-white bg-opacity-20 p-4 rounded-lg hover:bg-opacity-30 transition-all duration-300">
                        <i class="fas fa-cog text-2xl mb-2"></i>
                        <p class="text-sm font-medium">Configuración</p>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{asset('js/scripts.js')}}"></script>
@endpush