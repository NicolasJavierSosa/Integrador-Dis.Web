<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;

class WebController extends Controller
{
    public function index(Request $request){
        $query=Producto::query();
        // Búsqueda por nombre
        if ($request->has('search') && $request->search) {
            $query->where('nombre', 'like', '%' . $request->search . '%');
        }

        // Filtro de orden (Ordenar por precio)
        if ($request->has('sort') && $request->sort) {
            switch ($request->sort) {
                case 'priceAsc':
                    $query->orderBy('precio', 'asc');
                    break;
                case 'priceDesc':
                    $query->orderBy('precio', 'desc');
                    break;
                default:
                    $query->orderBy('nombre', 'asc');
                    break;
            }
        }
        // Obtener productos filtrados
        $productos = $query->paginate(10);    
        return view('web.index', compact('productos'));

    }

    public function show($id){
        // Obtener el producto por ID
        $producto = Producto::findOrFail($id);        
        // Pasar el producto a la vista
        return view('web.item', compact('producto'));
    }
}
