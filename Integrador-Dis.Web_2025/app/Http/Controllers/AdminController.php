<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Exception;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use App\Enums\ModalidadEnum;
use App\Enums\DiaSemanaEnum;
use App\Models\Category;


class AdminController extends Controller
{
    public function index() {
        // Verifico si el usuario autenticado es un administrador
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('login')->with('error', 'Acceso no autorizado');
        }

        $users = User::all();
        $courses = Course::all();

        return view('admin.dashboard', compact('users', 'courses'));
    }

    public function users() {
        // Verifico si el usuario autenticado es un administrador
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Acesso no autorizado');
            return view('/dashboard');
        }

        // Obtengo todos los usuarios del sistema
        $users = User::all();
        $permissions = Permission::all();
        $roles = Role::all();

        // Retorno la vista con los usuarios
        return view('admin.users', compact('users', 'permissions', 'roles'));
    }

    // METODOS ABM (La lógica de creación, edición y eliminación de usuarios)
    public function createUser(Request $request) {
        // Verifico si el usuario autenticado es un administrador
        if (Auth::user()->role !== 'admin') {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Acceso no autorizado'], 403);
            }
            return redirect()->back()->with('error', 'Acceso no autorizado');
        }

        try{
            // Valido los datos
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'surname' => 'required|string|max:255',
                'dni' => 'required|numeric|digits:8|unique:users,dni',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8|confirmed',
                'gender' => 'nullable|in:M,F,X',
                'birth_date' => 'nullable|date',
                'address' => 'nullable|string|max:255',
                'phone' => 'nullable|string|max:20',
                'role' => 'required|string'
            ]);

            $newUser = new User();
            $newUser->name = $validatedData['name'];
            $newUser->surname = $validatedData['surname'];
            $newUser->dni = $validatedData['dni'];
            $newUser->email = $validatedData['email'];
            $newUser->password = Hash::make($validatedData['password']);
            $newUser->gender = $validatedData['gender'] ?? 'X';
            $newUser->birth_date = $validatedData['birth_date'];
            $newUser->address = $validatedData['address'] ?? null;
            $newUser->phone = $validatedData['phone'] ?? null;

            // Verificar si el rol existe
            $role = Role::findByName($validatedData['role']);
            if (!$role) {
                throw new Exception('El rol especificado no existe');
            }
            $newUser->role = $validatedData['role'];

            $newUser->save();

            if ($request->expectsJson()) {
                return response()->json(['success' => true, 'message' => 'Usuario creado correctamente']);
            }
            
            return redirect()->route('admin.users')->with('success', 'Usuario creado correctamente');

        } catch (ValidationException $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Errores de validación',
                    'errors' => $e->errors()
                ], 422);
            }
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Error interno del servidor: ' . $e->getMessage()
                ], 500);
            }
            return redirect()->back()->with('error', 'Error al crear el usuario: ' . $e->getMessage())->withInput();
        }
    }

    public function editUser($id) {
        // Siempre verifico si el usuario autenticado es un administrador. SIEMPRE
        if (Auth::user()->role !== 'admin') {
            return response()->json(['success' => false, 'message' => 'Acceso no autorizado'], 403);
        }

        try {
            // Busco el elemento por ID (En este caso, el ID del usuario)
            $user = User::findOrFail($id);
            
            // Retorno los datos en formato JSON para la petición AJAX
            return response()->json([
                'success' => true,
                'user' => $user,
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false, 
                'message' => 'Usuario no encontrado'
            ], 404);
        }
    }

    public function updateUser(Request $request) {
        // Verifico si el usuario autenticado es un administrador
        if (Auth::user()->role !== 'admin') {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Acceso no autorizado'], 403);
            }
            return redirect()->back()->with('error', 'Acceso no autorizado');
        }

        try {
            $user = User::findOrFail($request->user_id);
            
            // Valido los datos
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'surname' => 'required|string|max:255',
                'dni' => 'required|numeric|digits:8|unique:users,dni,' . $user->id,
                'email' => 'required|email|unique:users,email,' . $user->id,
                'password' => 'nullable|string|min:8|confirmed',
                'gender' => 'nullable|in:M,F,X',
                'birth_date' => 'nullable|date',
                'address' => 'nullable|string|max:255',
                'phone' => 'nullable|string|max:20',
                'role' => 'required|string'
            ]);

            // No permitir cambiar el rol del usuario autenticado
            if ($user->id === Auth::id() && $validatedData['role'] !== Auth::user()->role) {
                if ($request->expectsJson()) {
                    return response()->json(['success' => false, 'message' => 'No puedes cambiar tu propio rol'], 403);
                }
                return redirect()->back()->with('error', 'No puedes cambiar tu propio rol');
            }

            // Verificar si el rol existe
            $role = Role::findByName($validatedData['role']);
            if (!$role) {
                if ($request->expectsJson()) {
                    return response()->json(['success' => false, 'message' => 'El rol especificado no existe'], 400);
                }
                return redirect()->back()->with('error', 'El rol especificado no existe');
            }

            // Si se proporciona una nueva contraseña, encriptarla
            if (!empty($validatedData['password'])) {
                $validatedData['password'] = Hash::make($validatedData['password']);
            } else {
                // Si no se proporciona contraseña, no actualizar este campo
                unset($validatedData['password']);
            }

            // Actualizo los datos del usuario
            $user->update($validatedData);

            if ($request->expectsJson()) {
                return response()->json(['success' => true, 'message' => 'Usuario actualizado correctamente']);
            }
            
            return redirect()->route('admin.users')->with('success', 'Usuario actualizado correctamente');
            
        } catch (ValidationException $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Errores de validación',
                    'errors' => $e->errors()
                ], 422);
            }
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Error al actualizar el usuario: ' . $e->getMessage()
                ], 500);
            }
            return redirect()->back()->with('error', 'Error al actualizar el usuario: ' . $e->getMessage());
        }
    }

    public function destroyUser($id) {
        // Verifico si el usuario autenticado es un administrador
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Acceso no autorizado');
        }

        try {
            $user = User::findOrFail($id);
            
            // No permitir eliminar al usuario autenticado
            if ($user->id === Auth::id()) {
                return redirect()->back()->with('error', 'No puedes eliminarte a ti mismo');
            }

            $user->delete();
            return redirect()->route('admin.users')->with('success', 'Usuario eliminado correctamente');
            
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error al eliminar el usuario');
        }
    }

    // METODOS ABM de CURSOS
    public function courses()
{
    $cursos = Course::all(); 
    $categorias = Category::all();
    $docentes = User::role('Docente')->get();
    $modalidades = ModalidadEnum::cases();
    $diasSemana = DiaSemanaEnum::cases();

    return view('admin.courses', compact('cursos', 'docentes', 'categorias', 'modalidades', 'diasSemana'));
}

    
    public function destroyCourse($codigo)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Acceso no autorizado');
        }

        $curso = Course::findOrFail($codigo);
        $curso->delete();

        return redirect()->route('admin.courses')->with('success', 'Course eliminado correctamente.');
    }

    public function editCourse($codigo)
{
    if (Auth::user()->role !== 'admin') {
        abort(403, 'Acceso no autorizado');
    }

    $curso = Course::findOrFail($codigo);
    
    $cursos = Course::all();
    $modalidades = ModalidadEnum::cases();
    $diasSemana = DiaSemanaEnum::cases();

    return view('admin.courses', compact('curso', 'cursos', 'modalidades', 'diasSemana'));
}

        
public function storeCategory(Request $request) {

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
    ]);

    Category::create($validated);

    return redirect()->route('admin.courses')
                     ->with('success', 'Categoría creada correctamente.');
}




    public function edit($codigo)
    {
        $curso = Course::findOrFail($codigo);

        return view('admin.cursos.edit', [
            'curso' => $curso,
            'modalidades' => ModalidadEnum::cases(),
            'diasSemana' => DiaSemanaEnum::cases(),
        ]);
    }

    //METODOS ABM de ROLES
    public function roles() {
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('login')->with('error', 'Acceso no autorizado');
        }

        $roles = Role::all();

        return view('admin.roles', compact('roles'));
    }

    public function createRole(Request $request) {
        if (Auth::user()->role !== 'admin') {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Acceso no autorizado'], 403);
            }
            return redirect()->back()->with('error', 'Acceso no autorizado');
        }

        try {
            $validatedData = $request->validate(['name' => 'required|max:255|string']);
            $validatedData['name'] = strtolower($validatedData['name']);
            if (Role::where('name', $validatedData['name'])->exists()) {
                if ($request->expectsJson()) {
                    return response()->json(['success' => false, 'message' => 'El rol ya existe'], 400);
                }
                return redirect()->back()->with('error', 'El rol ya existe');
            }

            //valido la lista de permisos y verifico que existan
            if ($request->has('permissions')) {
                $permissions = $request->input('permissions');
                $validPermissions = Permission::whereIn('name', $permissions)->pluck('name')->toArray();
                if (count($validPermissions) !== count($permissions)) {
                    if ($request->expectsJson()) {
                        return response()->json(['success' => false, 'message' => 'Algunos permisos no existen'], 400);
                    }
                    return redirect()->back()->with('error', 'Algunos permisos no existen');
                }
                $validatedData['permissions'] = $validPermissions;
            } else {
                $validatedData['permissions'] = [];
            }

            // Crear el nuevo rol
            $role = Role::create(['name' => $validatedData['name']]);
            if ($request->expectsJson()) {
                return response()->json(['success' => true, 'message' => 'Rol creado correctamente']);
            }
            return redirect()->back()->with('success', 'Rol creado correctamente');

            //le asigno los permisos al rol
            if (isset($validatedData['permissions']) && count($validatedData['permissions']) > 0) {
                $role = Role::findByName($validatedData['name']);
                $role->syncPermissions($validatedData['permissions']);
            }

        } catch (ValidationException $e){

        }

    }

 public function storeCourse(Request $request)
{
    if (Auth::user()->role !== 'admin') {
        abort(403, 'Acceso no autorizado');
    }

    $validated = $request->validate([
        'nombre' => 'required|string|max:255',
        'descripcion' => 'nullable|string',
        'fecha_inicio' => 'required|date',
        'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        'fecha_limite_inscripcion' => 'required|date|before_or_equal:fecha_inicio',
        'cupo' => 'required|integer|min:1',
        'modalidad' => 'required|string',
        'horario' => 'required|json', 
        'dias' => 'required|json',     
    ]);

    $courses = new Course();
    $courses->nombre = $validated['nombre'];
    $courses->descripcion = $validated['descripcion'] ?? null;
    $courses->fecha_inicio = $validated['fecha_inicio'];
    $courses->fecha_fin = $validated['fecha_fin'];
    $courses->fecha_limite_inscripcion = $validated['fecha_limite_inscripcion'];
    $courses->cupo = $validated['cupo'];
    $courses->modalidad = $validated['modalidad'];
    $courses->horario = json_decode($validated['horario'], true); 
    $courses->dias = $validated['dias'];        

    $courses->save();

    return redirect()->route('admin.courses')->with('success', 'Curso creado correctamente.');
}

}