@extends('web.app')
@section('contenido')
<!-- Section-->
 <form action="{{route('carrito.agregar')}}" method="POST" class="d-flex">
    @csrf
    <section class="py-5">
        <div class="container px-4 px-lg-5 my-5">
            <div class="row gx-4 gx-lg-5 align-items-center">
                <div class="col-md-6">
                    <img class="card-img-top mb-5 mb-md-0"
                    src="{{asset('uploads/productos/'. $producto->imagen) }}" alt="{{$producto->nombre}}"/></div>
                <div class="col-md-6">
                    <div class="small mb-1">SKU: {{$producto->codigo}}</div>
                    <h1 class="display-5 fw-bolder">{{$producto->nombre}}</h1>
                    <div class="fs-5 mb-5">
                        <span>${{$producto->precio}}</span>
                    </div>
                    <p class="lead">{{$producto->descripcion}}</p>
                    @if (session('mensaje'))
                        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                            {{ session('mensaje') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                        </div>
                    @endif
                    <div class="d-flex">
                        <input type="hidden" name="producto_id" value="{{$producto->id}}">
                        <input class="form-control text-center me-3" id="inputQuantity" type="number" name="cantidad" min="1" value="1"
                            style="max-width: 3rem" />
                        <button class="btn btn-outline-dark flex-shrink-0" type="submit">
                            <i class="bi-cart-fill me-1"></i>
                            Agregar al carrito
                        </button>
                        <a class="btn btn-outline-secondary ms-2" href="javascript:history.back()">Regresar</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</form>
@endsection