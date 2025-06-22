<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('user-list'); 
        $texto=$request->input('texto');
        $registros=User::with('roles')
                    ->where('name', 'like',"%{$texto}%")
                    ->orWhere('email', 'like',"%{$texto}%")
                    ->orderBy('id', 'desc')
                    ->paginate(10);
        return view('usuario.index', compact('registros','texto'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('user-create'); 
        $roles=Role::all();
        return view('usuario.action', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $this->authorize('user-create'); 
        $registro=new User();
        $registro->name=$request->input('name');
        $registro->email=$request->input('email');
        $registro->password=Hash::make($request->input('password'));
        $registro->activo=$request->input('activo');
        $registro->save();

        $registro->assignRole($request->input('role'));
        return redirect()->route('usuarios.index')->with('mensaje', 'Registro '.$registro->name. '  agregado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $this->authorize('user-edit'); 
        $roles=Role::all();
        $registro=User::findOrFail($id);
        return view('usuario.action', compact('registro','roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, $id)
    {
        $this->authorize('user-edit'); 
        $registro=User::findOrFail($id);
        $registro->name=$request->input('name');
        $registro->email=$request->input('email');
        if ($request->filled('password')) {
            $registro->password=Hash::make($request->input('password'));
        }
        $registro->activo=$request->input('activo');
        $registro->save();

        $registro->syncRoles([$request->input('role')]);

        return redirect()->route('usuarios.index')->with('mensaje', 'Registro '.$registro->name. '  actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->authorize('user-delete');
        $registro=User::findOrFail($id);
        $registro->delete();

        return redirect()->route('usuarios.index')->with('mensaje', $registro->name. ' eliminado correctamente.');
    }

    public function toggleStatus(User $usuario){
        $this->authorize('user-activate'); 
        $usuario->activo=!$usuario->activo;
        $usuario->save();
        return redirect()->route('usuarios.index')->with('mensaje', 'Estado del usuario actualizado correctamente.');
    }
}
