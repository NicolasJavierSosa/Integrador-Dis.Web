<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Gestión de Usuarios</title>
    <style>
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 4px;
        }
        .alert-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
        }
        .alert-danger {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }
        .error-field {
            border: 1px solid #dc3545 !important;
        }
        .error-message {
            color: #dc3545;
            font-size: 0.875em;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Gestión de Usuarios</h1>

        <!-- Mensajes de éxito y error -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <!-- Errores de validación generales -->
        @if($errors->any())
            <div class="alert alert-danger">
                <strong>¡Hay errores en el formulario!</strong>
                <ul style="margin: 10px 0 0 0; padding-left: 20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Botón para mostrar formulario de creación -->
        <button onclick="showCreateForm()" class="btn btn-primary">Crear Nuevo Usuario</button>

        <!-- Formulario de creación -->
        <div id="creation" style="display: none;">
            <h2>Crear Nuevo Usuario</h2>
            
            <form action="{{ route('admin.users.create') }}" method="POST">
                @csrf
                
                <div>
                    <label for="create_name">Nombre:</label>
                    <input type="text" name="name" id="create_name" required>
                </div>
                
                <div>
                    <label for="create_surname">Apellido:</label>
                    <input type="text" name="surname" id="create_surname" required>
                </div>
                
                <div>
                    <label for="create_dni">DNI:</label>
                    <input type="text" name="dni" id="create_dni" required>
                </div>
                
                <div>
                    <label for="create_email">Email:</label>
                    <input type="email" name="email" id="create_email" required>
                </div>
                
                <div>
                    <label for="create_password">Contraseña:</label>
                    <input type="password" name="password" id="create_password" required>
                </div>

                <div>
                    <label for="create_password_confirmation">Confirmar Contraseña:</label>
                    <input type="password" name="password_confirmation" id="create_password_confirmation" required>
                </div>
                
                <div>
                    <label for="create_gender">Género:</label>
                    <select name="gender" id="create_gender">
                        <option value="">Seleccione</option>
                        <option value="M">Masculino</option>
                        <option value="F">Femenino</option>
                        <option value="X">Otro</option>
                    </select>
                </div>
                
                <div>
                    <label for="create_birth_date">Fecha de Nacimiento:</label>
                    <input type="date" name="birth_date" id="create_birth_date">
                </div>
                
                <div>
                    <label for="create_address">Dirección:</label>
                    <input type="text" name="address" id="create_address">
                </div>
                
                <div>
                    <label for="create_phone">Teléfono:</label>
                    <input type="text" name="phone" id="create_phone">
                </div>
                
                <div>
                    <label for="create_role">Rol:</label>
                    <select name="role" id="create_role" required>
                        <option value="">Seleccione un rol</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <button type="submit" class="btn btn-success">Crear Usuario</button>
                    <button type="button" onclick="hideCreateForm()" class="btn btn-secondary">Cancelar</button>
                </div>
            </form>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Rol</th>
                    <th>DNI</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Genero</th>
                    <th>Fecha de Nacimiento</th>
                    <th>Email</th>
                    <th>Ciudad</th>
                    <th>Teléfono</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->role ?? 'Usuario'}}</td>
                        <td>{{ $user->dni }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->surname }}</td>
                        <td>{{ $user->gender }}</td>
                        <td>{{ $user->birth_date }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->address }}</td>
                        <td>{{ $user->phone }}</td>
                        <td>
                            <button onclick="editUser({{ $user->id }})" class="btn btn-primary">Editar</button>
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="11" class="text-center">No hay usuarios registrados</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div id="edition" style="display: none;">
        <h2>Edición de Usuarios</h2>
        
        <!-- Div para mostrar errores AJAX -->
        <div id="ajax-errors" class="alert alert-danger" style="display: none;">
            <ul id="ajax-error-list"></ul>
        </div>

        <form id="edition-form" action="{{ route('admin.users.update') }}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="user_id" id="user_id">
            
            <div>
                <label for="name">Nombre:</label>
                <input type="text" name="name" id="name" class="{{ $errors->has('name') ? 'error-field' : '' }}" value="{{ old('name') }}" required>
                @error('name')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
            
            <div>
                <label for="surname">Apellido:</label>
                <input type="text" name="surname" id="surname" class="{{ $errors->has('surname') ? 'error-field' : '' }}" value="{{ old('surname') }}" required>
                @error('surname')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
            
            <div>
                <label for="dni">DNI:</label>
                <input type="text" name="dni" id="dni" class="{{ $errors->has('dni') ? 'error-field' : '' }}" value="{{ old('dni') }}" required>
                @error('dni')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
            
            <div>
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" class="{{ $errors->has('email') ? 'error-field' : '' }}" value="{{ old('email') }}" required>
                @error('email')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
            
            <div>
                <label for="gender">Género:</label>
                <select name="gender" id="gender" class="{{ $errors->has('gender') ? 'error-field' : '' }}">
                    <option value="">Seleccione</option>
                    <option value="M" {{ old('gender') == 'M' ? 'selected' : '' }}>Masculino</option>
                    <option value="F" {{ old('gender') == 'F' ? 'selected' : '' }}>Femenino</option>
                    <option value="O" {{ old('gender') == 'X' ? 'selected' : '' }}>Otro</option>
                </select>
                @error('gender')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
            
            <div>
                <label for="birth_date">Fecha de Nacimiento:</label>
                <input type="date" name="birth_date" id="birth_date" class="{{ $errors->has('birth_date') ? 'error-field' : '' }}" value="{{ old('birth_date') }}">
                @error('birth_date')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
            
            <div>
                <label for="address">Dirección:</label>
                <input type="text" name="address" id="address" class="{{ $errors->has('address') ? 'error-field' : '' }}" value="{{ old('address') }}">
                @error('address')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
            
            <div>
                <label for="phone">Teléfono:</label>
                <input type="text" name="phone" id="phone" class="{{ $errors->has('phone') ? 'error-field' : '' }}" value="{{ old('phone') }}">
                @error('phone')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
            
            <div id="role_select">
                <label for="role">Rol:</label>
                <select name="role" id="role" class="{{ $errors->has('role') ? 'error-field' : '' }}">
                    <option value="">Seleccione un rol</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->name }}" {{ old('role') == $role->name ? 'selected' : '' }}>{{ $role->name }}</option>
                    @endforeach
                </select>
                @error('role')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>         
            <div>
                <button type="submit" class="btn btn-success">Actualizar Usuario</button>
                <button type="button" onclick="cancelEdit()" class="btn btn-secondary">Cancelar</button>
            </div>
        </form>
    </div>

    <script src="{{ asset('js/admin/scripts.js') }}"></script>
    
    <script>
        // Mostrar formulario de edición si hay errores de validación
        @if($errors->any())
            document.getElementById('edition').style.display = 'block';
        @endif
    </script>
</body>
</html>