<div class="modal fade" id="modal-estado-{{$reg->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog">
        <div class="modal-content bg-warning">
            <form action="{{route('pedidos.cambiar.estado', $reg->id)}}" method="post">
                @csrf
                @method('PATCH')
                <div class="modal-header">
                    <h4 class="modal-title">Cambiar estado del pedido # {{$reg->id}}</h4>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Seleccione el nuevo estado:</p>
                    <div class="form-group">
                        <select name="estado" class="form-control">
                            @can('pedido-anulate')
                            <option value="enviado">Enviado</option>
                            <option value="anulado">Anulado</option>
                            @endcan
                            @can('pedido-cancel')
                            <option value="cancelado">Cancelado</option>
                            @endcan
                        </select>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-outline-light">Cambiar estado</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>