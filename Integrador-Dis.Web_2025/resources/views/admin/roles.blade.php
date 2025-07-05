@extends('layouts.app')
@section('tittle', 'AureaCursos - Gestión de Roles')
@push('css')
@endpush

@section('contenido')
    <!-- aca el contenido para agregar -->
    <main class="max-w-6xl mx-auto bg-white p-8 rounded-xl shadow-2xl">
        <h1 class="text-3xl font-bold text-center text-purple-800 mb-8">Gestión de Roles y Permisos</h1>

        <!-- Formulario para agregar un rol -->
        <section class="bg-purple-50 p-6 rounded-lg shadow-inner mb-8 border border-purple-200">
            <h2 class="text-2xl font-semibold text-purple-700 mb-6">Crear Nuevo Rol</h2>
            
            <form id="roleForm">
                @csrf
                <div class="mb-4">
                    <label for="roleName" class="block text-purple-800 text-lg font-medium mb-2">Nombre del Rol</label>
                    <input
                        type="text"
                        id="roleName"
                        name="name"
                        class="w-full p-3 border border-purple-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent outline-none transition duration-200"
                        placeholder="Ej. Administrador, Editor, Lector"
                        required
                    />
                </div>

                <!-- Sección de Permisos Disponibles con tabla y filtro -->
                <div class="mb-6">
                    <label class="block text-purple-800 text-lg font-medium mb-2">Filtrar Permisos Disponibles</label>
                    <div class="flex justify-center mb-4">
                        <input
                            type="text"
                            id="permissionFilter"
                            class="w-1/2 p-3 border border-purple-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent outline-none transition duration-200"
                            placeholder="Buscar permiso..."
                        />
                    </div>
                    <div class="overflow-x-auto rounded-lg shadow-lg border border-purple-300">
                        <table class="min-w-full divide-y divide-purple-200">
                            <thead class="bg-purple-100">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-purple-600 uppercase tracking-wider">
                                        Seleccionar
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-purple-600 uppercase tracking-wider">
                                        Nombre del Permiso
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="permissionsTableBody" class="bg-white divide-y divide-purple-200">
                                <!-- Los permisos se cargarán aquí con JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-4">
                    <button
                        type="submit"
                        id="saveRoleButton"
                        class="flex-1 bg-purple-600 text-white py-3 rounded-lg font-semibold text-lg hover:bg-purple-700 transition duration-300 ease-in-out transform hover:scale-105 shadow-md hover:shadow-lg focus:outline-none focus:ring-4 focus:ring-purple-500 focus:ring-opacity-50"
                    >
                        Agregar Rol
                    </button>
                </div>
            </form>

            <div id="messageContainer" class="mt-4 p-3 rounded-lg text-center font-medium hidden"></div>
        </section>

        <!-- Tabla de roles existentes -->
        <section class="bg-white p-6 rounded-lg shadow-inner border border-purple-200">
            <h2 class="text-2xl font-semibold text-purple-700 mb-6">Roles Existentes</h2>
            <div id="rolesTableContainer" class="overflow-x-auto rounded-lg shadow-lg border border-purple-300">
                <table class="min-w-full divide-y divide-purple-200">
                    <thead class="bg-purple-100">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-purple-600 uppercase tracking-wider">
                                Nombre del Rol
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-purple-600 uppercase tracking-wider">
                                Permisos Asignados
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-purple-600 uppercase tracking-wider">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody id="rolesTableBody" class="bg-white divide-y divide-purple-200">
                        <!-- Los roles se cargarán aquí con JavaScript -->
                    </tbody>
                </table>
            </div>
            <p id="noRolesMessage" class="text-center text-gray-500 mt-4 hidden">No hay roles creados aún.</p>
        </section>
    </main>
@endsection

@push('scripts')
<script>
    let availablePermissions = [];
    let roles = [];

    const roleForm = document.getElementById('roleForm');
    const roleNameInput = document.getElementById('roleName');
    const permissionFilterInput = document.getElementById('permissionFilter');
    const permissionsTableBody = document.getElementById('permissionsTableBody');
    const messageContainer = document.getElementById('messageContainer');
    const rolesTableBody = document.getElementById('rolesTableBody');
    const noRolesMessage = document.getElementById('noRolesMessage');
    const rolesTableContainer = document.getElementById('rolesTableContainer');

    function showMessage(msg, type) {
        messageContainer.textContent = msg;
        messageContainer.classList.remove('hidden', 'bg-green-100', 'text-green-700', 'bg-red-100', 'text-red-700');
        if (type === 'success') {
            messageContainer.classList.add('bg-green-100', 'text-green-700');
        } else if (type === 'error') {
            messageContainer.classList.add('bg-red-100', 'text-red-700');
        }
        setTimeout(() => {
            messageContainer.classList.add('hidden');
        }, 3000);
    }

    async function loadData() {
        try {
            const response = await fetch('/admin/roles/data', {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });
            
            const data = await response.json();
            
            if (data.success) {
                availablePermissions = data.permissions;
                roles = data.roles;
                renderPermissions();
                renderRoles();
            } else {
                showMessage(data.message, 'error');
            }
        } catch (error) {
            console.error('Error:', error);
            showMessage('Error al cargar los datos', 'error');
        }
    }

    function renderPermissions() {
        permissionsTableBody.innerHTML = '';
        const filterText = permissionFilterInput.value.toLowerCase();
        const filteredPermissions = availablePermissions.filter(perm =>
            perm.name.toLowerCase().includes(filterText)
        );

        if (filteredPermissions.length === 0) {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td colspan="2" class="px-6 py-4 text-center text-gray-500">No se encontraron permisos.</td>
            `;
            permissionsTableBody.appendChild(row);
            return;
        }

        filteredPermissions.forEach(perm => {
            const row = document.createElement('tr');
            row.className = 'hover:bg-purple-50 transition duration-150';

            row.innerHTML = `
                <td class="px-6 py-4 whitespace-nowrap">
                    <input
                        type="checkbox"
                        id="perm-${perm.id}"
                        name="permissions[]"
                        value="${perm.id}"
                        class="form-checkbox h-5 w-5 text-purple-600 rounded focus:ring-purple-500"
                    />
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-purple-700">
                    <label for="perm-${perm.id}" class="cursor-pointer">${perm.name}</label>
                </td>
            `;
            permissionsTableBody.appendChild(row);
        });
    }

    function renderRoles() {
        rolesTableBody.innerHTML = '';
        if (roles.length === 0) {
            noRolesMessage.classList.remove('hidden');
            rolesTableContainer.classList.add('hidden');
            return;
        } else {
            noRolesMessage.classList.add('hidden');
            rolesTableContainer.classList.remove('hidden');
        }

        roles.forEach(role => {
            const row = document.createElement('tr');
            row.className = 'hover:bg-purple-50 transition duration-150';
            const assignedPermissionNames = role.permissions.map(p => p.name).join(', ');

            row.innerHTML = `
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-purple-900">
                    ${role.name}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                    ${assignedPermissionNames || 'Sin permisos asignados'}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <button 
                        onclick="deleteRole(${role.id})" 
                        class="text-red-600 hover:text-red-900 p-2 rounded-full hover:bg-red-100 transition duration-150 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50" 
                        title="Eliminar Rol"
                    >
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm6 0a1 1 0 11-2 0v6a1 1 0 112 0V8z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </td>
            `;
            rolesTableBody.appendChild(row);
        });
    }

    async function deleteRole(roleId) {
        if (!confirm('¿Estás seguro de que deseas eliminar este rol?')) {
            return;
        }

        try {
            const response = await fetch(`/admin/roles/${roleId}`, {
                method: 'DELETE',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });

            const data = await response.json();

            if (data.success) {
                showMessage(data.message, 'success');
                loadData(); // Recargar datos
            } else {
                showMessage(data.message, 'error');
            }
        } catch (error) {
            console.error('Error:', error);
            showMessage('Error al eliminar el rol', 'error');
        }
    }

    roleForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        try {
            const response = await fetch('/admin/roles', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });

            const data = await response.json();

            if (data.success) {
                showMessage(data.message, 'success');
                this.reset(); // Limpiar formulario
                loadData(); // Recargar datos
            } else {
                showMessage(data.message || 'Error al crear el rol', 'error');
            }
        } catch (error) {
            console.error('Error:', error);
            showMessage('Error al crear el rol', 'error');
        }
    });

    permissionFilterInput.addEventListener('input', renderPermissions);

    window.deleteRole = deleteRole;

    document.addEventListener('DOMContentLoaded', loadData);
</script>
@endpush