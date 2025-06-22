<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\PedidoDetalle;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class PedidoController extends Controller
{
    public function index(Request $request){
        $texto = $request->input('texto');
        $query = Pedido::with('user', 'detalles.producto')->orderBy('id', 'desc');

        // Permisos
        if (auth()->user()->can('pedido-list')) {
            // Puede ver todos los pedidos
        } elseif (auth()->user()->can('pedido-view')) {
            // Solo puede ver sus propios pedidos
            $query->where('user_id', auth()->id());
        } else {
            abort(403, 'No tienes permisos para ver pedidos.');
        }

        // Búsqueda por nombre del usuario
        if (!empty($texto)) {
            $query->whereHas('user', function ($q) use ($texto) {
                $q->where('name', 'like', "%{$texto}%");
            });
        }
        $registros = $query->paginate(10);
        return view('pedido.index', compact('registros', 'texto'));
    }

    public function realizar(Request $request){
        $carrito = session()->get('carrito', []);

        if (empty($carrito)) {
            return redirect()->back()->with('mensaje', 'El carrito está vacío.');
        }
        DB::beginTransaction();
        try {
            // 1. Calcular el total
            $total = 0;
            foreach ($carrito as $item) {
                $total += $item['precio'] * $item['cantidad'];
            }
            // 2. Crear el pedido
            $pedido = Pedido::create([
                'user_id' => auth()->id(), 'total' => $total, 'estado' => 'pendiente'
            ]);
            // 3. Crear los detalles del pedido
            foreach ($carrito as $productoId => $item) {
                PedidoDetalle::create([
                    'pedido_id' => $pedido->id, 'producto_id' => $productoId,
                    'cantidad' => $item['cantidad'], 'precio' => $item['precio'],
                ]);
            }
            // 4. Vaciar el carrito de la sesión
            session()->forget('carrito');
            DB::commit();
            return redirect()->route('carrito.mostrar')->with('mensaje', 'Pedido realizado correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Hubo un error al procesar el pedido.');
        }
    }

    public function cambiarEstado(Request $request, $id){
        $pedido = Pedido::findOrFail($id);
        $estadoNuevo = $request->input('estado');

        // Validar que el estado nuevo sea uno permitido
        $estadosPermitidos = ['enviado', 'anulado', 'cancelado'];

        if (!in_array($estadoNuevo, $estadosPermitidos)) {
            abort(403, 'Estado no válido');
        }

        // Verificar permisos según el estado
        if (in_array($estadoNuevo, ['enviado', 'anulado'])) {
            if (!auth()->user()->can('pedido-anulate')) {
                abort(403, 'No tiene permiso para cambiar a "enviado" o "anulado"');
            }
        }

        if ($estadoNuevo === 'cancelado') {
            if (!auth()->user()->can('pedido-cancel')) {
                abort(403, 'No tiene permiso para cancelar pedidos');
            }
        }

        // Cambiar el estado
        $pedido->estado = $estadoNuevo;
        $pedido->save();

        return redirect()->back()->with('mensaje', 'El estado del pedido fue actualizado a "' . ucfirst($estadoNuevo) . '"');
    }
}