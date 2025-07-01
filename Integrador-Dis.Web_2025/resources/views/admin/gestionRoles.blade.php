@extends('estructuras.app')
@section('tittle', 'AureaCursos - Gestion de Cursos')
@push('css')
@endpush

@section('contenido')
    <!-- aca el contenido para agregar -->
    <main class="max-w-6xl mx-auto bg-white p-8 rounded-xl shadow-2xl">
        <h1 class="text-3xl font-bold text-center text-purple-800 mb-8">Gestión de Roles y Permisos</h1>

        <!-- Formulario para agregar/editar un rol -->
        <section class="bg-purple-50 p-6 rounded-lg shadow-inner mb-8 border border-purple-200">
            <h2 id="formTitle" class="text-2xl font-semibold text-purple-700 mb-6">Crear Nuevo Rol</h2>
            <div class="mb-4">
                <label for="roleName" class="block text-purple-800 text-lg font-medium mb-2">Nombre del Rol</label>
                <input
                    type="text"
                    id="roleName"
                    class="w-full p-3 border border-purple-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent outline-none transition duration-200"
                    placeholder="Ej. Administrador, Editor, Lector"
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
                    id="saveRoleButton"
                    class="flex-1 bg-purple-600 text-white py-3 rounded-lg font-semibold text-lg hover:bg-purple-700 transition duration-300 ease-in-out transform hover:scale-105 shadow-md hover:shadow-lg focus:outline-none focus:ring-4 focus:ring-purple-500 focus:ring-opacity-50"
                >
                    Agregar Rol
                </button>
                <button
                    id="cancelEditButton"
                    class="flex-1 bg-gray-400 text-white py-3 rounded-lg font-semibold text-lg hover:bg-gray-500 transition duration-300 ease-in-out transform hover:scale-105 shadow-md hover:shadow-lg focus:outline-none focus:ring-4 focus:ring-gray-300 focus:ring-opacity-50 hidden"
                >
                    Cancelar Edición
                </button>
            </div>

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
        // Array de permisos disponibles (simulado)
        const availablePermissions = [
            { id: 'perm1', name: 'Gestionar Usuarios' },
            { id: 'perm2', name: 'Editar Contenido' },
            { id: 'perm3', name: 'Ver Reportes' },
            { id: 'perm4', name: 'Administrar Configuraciones' },
            { id: 'perm5', name: 'Publicar Artículos' },
            { id: 'perm6', name: 'Crear Tareas' },
            { id: 'perm7', name: 'Eliminar Registros' },
            { id: 'perm8', name: 'Ver Auditoría' },
            { id: 'perm9', name: 'Acceder a Datos Sensibles' },
            { id: 'perm10', name: 'Gestionar Productos' },
        ];

        // Array de roles existentes (precargados)
        let roles = [
            {
                id: 1,
                name: 'Administrador',
                permissions: ['perm1', 'perm2', 'perm3', 'perm4', 'perm7', 'perm8', 'perm9', 'perm10'],
            },
            {
                id: 2,
                name: 'Editor',
                permissions: ['perm2', 'perm5'],
            },
            {
                id: 3,
                name: 'Lector',
                permissions: ['perm3'],
            },
        ];

        // Estado de la aplicación
        let editingRoleId = null;

        // Referencias a elementos del DOM
        const roleNameInput = document.getElementById('roleName');
        const permissionFilterInput = document.getElementById('permissionFilter');
        const permissionsTableBody = document.getElementById('permissionsTableBody');
        const saveRoleButton = document.getElementById('saveRoleButton');
        const cancelEditButton = document.getElementById('cancelEditButton');
        const messageContainer = document.getElementById('messageContainer');
        const rolesTableBody = document.getElementById('rolesTableBody');
        const noRolesMessage = document.getElementById('noRolesMessage');
        const formTitle = document.getElementById('formTitle');
        const rolesTableContainer = document.getElementById('rolesTableContainer');

        // Función para mostrar mensajes (éxito o error)
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

        // Función para renderizar los permisos disponibles
        function renderPermissions() {
            permissionsTableBody.innerHTML = '';
            const filterText = permissionFilterInput.value.toLowerCase();
            const filteredPermissions = availablePermissions.filter(perm =>
                perm.name.toLowerCase().includes(filterText)
            );

            if (filteredPermissions.length === 0) {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <tr>
                        <td colSpan="2" class="px-6 py-4 text-center text-gray-500">No se encontraron permisos.</td>
                    </tr>
                `;
                permissionsTableBody.appendChild(row);
                return;
            }

            filteredPermissions.forEach(perm => {
                const row = document.createElement('tr');
                row.className = 'hover:bg-purple-50 transition duration-150';
                const isSelected = (editingRoleId !== null && roles.find(r => r.id === editingRoleId)?.permissions.includes(perm.id)) ||
                                   (editingRoleId === null && Array.from(document.querySelectorAll(`#permissionsTableBody input[type="checkbox"]:checked`)).map(cb => cb.id.replace('perm-', '')).includes(perm.id));

                row.innerHTML = `
                    <td class="px-6 py-4 whitespace-nowrap">
                        <input
                            type="checkbox"
                            id="perm-${perm.id}"
                            class="form-checkbox h-5 w-5 text-purple-600 rounded focus:ring-purple-500"
                            ${isSelected ? 'checked' : ''}
                        />
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-purple-700">
                        <label for="perm-${perm.id}" class="cursor-pointer">${perm.name}</label>
                    </td>
                `;
                permissionsTableBody.appendChild(row);

                // Añadir event listener al checkbox
                row.querySelector(`#perm-${perm.id}`).addEventListener('change', (e) => {
                    const selectedPermissions = Array.from(document.querySelectorAll(`#permissionsTableBody input[type="checkbox"]:checked`))
                        .map(cb => cb.id.replace('perm-', ''));

                    // En modo edición, actualiza los permisos del rol en edición
                    if (editingRoleId !== null) {
                        const currentRole = roles.find(r => r.id === editingRoleId);
                        if (currentRole) {
                            currentRole.permissions = selectedPermissions;
                        }
                    }
                });
            });
        }

        // Función para renderizar los roles existentes
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
                const assignedPermissionNames = role.permissions
                    .map(id => availablePermissions.find(p => p.id === id)?.name)
                    .filter(name => name) // Filtra nombres nulos/indefinidos si un ID no se encuentra
                    .join(', ');

                row.innerHTML = `
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-purple-900">
                        ${role.name}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                        ${assignedPermissionNames}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <button data-id="${role.id}" class="edit-role-btn text-blue-600 hover:text-blue-900 p-2 rounded-full hover:bg-blue-100 transition duration-150 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50" title="Modificar Rol">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zm-1.414 1.414L10 5.414V17a1 1 0 11-2 0V5.414l-2.172 2.172a1 1 0 01-1.414-1.414l3.586-3.586a1 1 0 011.414 0l3.586 3.586a1 1 0 01-1.414 1.414L12.172 6z"></path>
                            </svg>
                        </button>
                        <button data-id="${role.id}" class="delete-role-btn text-red-600 hover:text-red-900 ml-4 p-2 rounded-full hover:bg-red-100 transition duration-150 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50" title="Eliminar Rol">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm6 0a1 1 0 11-2 0v6a1 1 0 112 0V8z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </td>
                `;
                rolesTableBody.appendChild(row);
            });

            // Añadir event listeners a los botones de eliminar y editar después de renderizar
            document.querySelectorAll('.delete-role-btn').forEach(button => {
                button.addEventListener('click', (e) => {
                    const roleId = parseInt(e.currentTarget.dataset.id);
                    roles = roles.filter(role => role.id !== roleId);
                    showMessage('Rol eliminado exitosamente.', 'success');
                    renderRoles();
                });
            });

            document.querySelectorAll('.edit-role-btn').forEach(button => {
                button.addEventListener('click', (e) => {
                    const roleId = parseInt(e.currentTarget.dataset.id);
                    const roleToEdit = roles.find(role => role.id === roleId);
                    if (roleToEdit) {
                        editingRoleId = roleId;
                        roleNameInput.value = roleToEdit.name;
                        // Desmarcar todos los checkboxes primero
                        document.querySelectorAll('#permissionsTableBody input[type="checkbox"]').forEach(cb => {
                            cb.checked = false;
                        });
                        // Marcar los checkboxes de los permisos del rol
                        roleToEdit.permissions.forEach(permId => {
                            const checkbox = document.getElementById(`perm-${permId}`);
                            if (checkbox) {
                                checkbox.checked = true;
                            }
                        });
                        formTitle.textContent = 'Editar Rol Existente';
                        saveRoleButton.textContent = 'Guardar Cambios';
                        cancelEditButton.classList.remove('hidden');
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                        showMessage('', ''); // Limpiar mensajes
                    }
                });
            });
        }

        // Función para resetear el formulario
        function resetForm() {
            roleNameInput.value = '';
            // Desmarcar todos los checkboxes
            document.querySelectorAll('#permissionsTableBody input[type="checkbox"]').forEach(cb => {
                cb.checked = false;
            });
            editingRoleId = null;
            formTitle.textContent = 'Crear Nuevo Rol';
            saveRoleButton.textContent = 'Agregar Rol';
            cancelEditButton.classList.add('hidden');
            permissionFilterInput.value = ''; // Limpiar filtro de permisos
            renderPermissions(); // Re-renderizar permisos para que no estén filtrados
            showMessage('', ''); // Limpiar mensajes
        }

        // Event listener para el botón de guardar/agregar rol
        saveRoleButton.addEventListener('click', () => {
            const name = roleNameInput.value.trim();
            const selectedPermissions = Array.from(document.querySelectorAll('#permissionsTableBody input[type="checkbox"]:checked'))
                .map(cb => cb.id.replace('perm-', ''));

            if (!name) {
                showMessage('El nombre del rol no puede estar vacío.', 'error');
                return;
            }
            if (selectedPermissions.length === 0) {
                showMessage('Debe seleccionar al menos un permiso para el rol.', 'error');
                return;
            }

            if (editingRoleId !== null) {
                // Actualizar rol existente
                roles = roles.map(role =>
                    role.id === editingRoleId
                        ? { ...role, name: name, permissions: selectedPermissions }
                        : role
                );
                showMessage('Rol actualizado exitosamente.', 'success');
            } else {
                // Agregar nuevo rol
                const newRole = {
                    id: Date.now(), // ID único
                    name: name,
                    permissions: selectedPermissions,
                };
                roles.push(newRole);
                showMessage('Rol agregado exitosamente.', 'success');
            }

            resetForm();
            renderRoles();
        });

        // Event listener para el botón de cancelar edición
        cancelEditButton.addEventListener('click', resetForm);

        // Event listener para el filtro de permisos
        permissionFilterInput.addEventListener('input', renderPermissions);

        // Renderizar la tabla de permisos y roles al cargar la página
        document.addEventListener('DOMContentLoaded', () => {
            renderPermissions();
            renderRoles();
        });
    </script>
@endpush