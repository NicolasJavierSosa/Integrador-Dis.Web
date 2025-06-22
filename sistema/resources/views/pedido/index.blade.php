@extends('plantilla.app')
@section('contenido')
<div class="app-content">
    <!--begin::Container-->
    <div class="container-fluid">
        <!--begin::Row-->
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <h3 class="card-title">Pedidos</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div>
                            <form action="{{route('productos.index')}}" method="get">
                                <div class="input-group">
                                    <input name="texto" type="text" class="form-control" value="{{$texto}}"
                                        placeholder="Ingrese texto a buscar">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-secondary"><i class="fas fa-search"></i>
                                            Buscar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        @if(Session::has('mensaje'))
                        <div class="alert alert-info alert-dismissible fade show mt-2">
                            {{Session::get('mensaje')}}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="close"></button>
                        </div>
                        @endif
                        <div class="table-responsive mt-3">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 150px">Opciones</th>
                                        <th style="width: 20px">ID</th>
                                        <th>Fecha</th>
                                        <th>Usuario</th>
                                        <th>Total</th>
                                        <th>Estado</th>
                                        <th>Detalles</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count($registros)<=0) <tr>
                                        <td colspan="7">No hay registros que coincidan con la búsqueda</td>
                                        </tr>
                                        @else
                                        @foreach($registros as $reg)
                                        <tr class="align-middle">
                                            <td>
                                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#modal-estado-{{$reg->id}}"><i
                                                        class="bi bi bi-arrow-repeat"></i>
                                                </button>
                                            </td>
                                            <td>{{$reg->id}}</td>
                                            <td>{{$reg->created_at->format('d/m/Y')}}</td>
                                            <td>{{$reg->user->name}}</td>
                                            <td>${{ number_format($reg->total, 2) }}</td>
                                            <td>
                                                @php
                                                    $colores = [
                                                        'pendiente' => 'bg-warning',
                                                        'enviado' => 'bg-success',
                                                        'anulado' => 'bg-danger',
                                                        'cancelado' => 'bg-secondary',
                                                    ];
                                                @endphp
                                                <span class="badge {{ $colores[$reg->estado] ?? 'bg-dark' }}">
                                                    {{ ucfirst($reg->estado) }}
                                                </span>
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-primary" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#detalles-{{ $reg->id }}">
                                                    Ver detalles
                                                </button>
                                            </td>
                                        </tr>
                                        <tr class="collapse" id="detalles-{{ $reg->id }}">
                                            <td colspan="7">
                                                <table class="table table-sm table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>Producto</th>
                                                            <th>Imagen</th>
                                                            <th>Cantidad</th>
                                                            <th>Precio Unitario</th>
                                                            <th>Subtotal</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($reg->detalles as $detalle)
                                                        <tr>
                                                            <td>{{ $detalle->producto->nombre }}</td>
                                                            <td>
                                                                <img src="{{ asset('uploads/productos/' . $detalle->producto->imagen ) }}"
                                                                    class="img-fluid rounded"
                                                                    style="width: 80px; height: 80px; object-fit: cover;"
                                                                    alt="{{ $detalle->producto->nombre}}">
                                                            </td>
                                                            <td>{{ $detalle->cantidad}}</td>
                                                            <td>{{ number_format($detalle->precio, 2) }}</td>
                                                            <td>{{ number_format($detalle->cantidad * $detalle->precio, 2) }}
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        @include('pedido.state')
                                        @endforeach
                                        @endif
                                </tbody>
                            </table>
                        </div>

                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer clearfix">
                        {{$registros->appends(["texto"=>$texto])}}
                    </div>
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!--end::Row-->
    </div>
    <!--end::Container-->
</div>
@endsection
@push('scripts')
<script>
document.getElementById('mnuPedidos').classList.add('active');
</script>
@endpush