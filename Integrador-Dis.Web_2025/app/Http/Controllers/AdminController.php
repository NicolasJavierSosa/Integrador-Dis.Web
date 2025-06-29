<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Exception;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index() {
        // Verifico si el usuario autenticado es un administrador
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('login')->with('error', 'Acceso no autorizado');
        }

        $users = User::all();

        return view('admin.dashboard', compact('users'));
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

    public function courses() {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Acceso no autorizado');
            return view('/dashboard');
        }

        //Lógica para obtener los cursos
        
        return view('admin.courses');
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
}