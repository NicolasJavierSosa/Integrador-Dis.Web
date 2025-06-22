@extends('web.app')
@section('contenido')
<!-- Section-->
<section class="py-5">
    <div class="container px-4 px-lg-12 my-5">
        <h2 class="fw-bold mb-4">Detalle de su Pedido</h2>
        <div class="row">
            <!-- Cart Items -->
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <div class="row">
                            <div class="col-md-5"><strong>Producto</strong></div>
                            <div class="col-md-2 text-center"><strong>Precio</strong></div>
                            <div class="col-md-2 text-center"><strong>Cantidad</strong></div>
                            <div class="col-md-3 text-end"><strong>Subtotal</strong></div>
                        </div>
                    </div>
                    <div class="card-body" id="cartItems">
                        @forelse($carrito as $id => $item)
                        <!-- Product-->
                        <div class="row align-items-center mb-3 cart-item">
                            <!--Nombre y código-->
                            <div class="col-md-5 d-flex align-items-center">
                                <img src="{{ asset('uploads/productos/' . $item['imagen']) }}" 
                                style="width: 80px; height: 80px; object-fit: cover;" alt="{{ $item['nombre'] }}">
                                <div class="ms-3">
                                    <h6 class="mb-0">{{ $item['nombre'] }}</h6>
                                    <small class="text-muted">{{ $item['codigo'] }}</small>
                                </div>
                            </div>
                            <!--Precio-->
                            <div class="col-md-2 text-center">
                                <span class="fw-bold">${{ number_format($item['precio'], 2) }}</span>
                            </div>
                            <!--Cantidad-->
                            <div class="col-md-2 d-flex justify-content-center">
                                <div class="input-group input-group-sm" style="max-width: 100px;">
                                    <a class="btn btn-outline-secondary" href="{{ route('carrito.restar', ['producto_id' => $id]) }}"
                                        data-action="decrease">-</a>
                                    <input type="text" class="form-control text-center" value="{{ $item['cantidad'] }}"
                                        readonly>
                                        <a href="{{ route('carrito.sumar', ['producto_id' => $id]) }}" class="btn btn-outline-secondary btn-sm">
                                            +
                                        </a>
                                </div>
                            </div>

                            <!--Subtotal-->
                            <div class="col-md-3 d-flex align-items-center justify-content-end">
                                <div class="text-end me-3">
                                    <span
                                        class="fw-bold subtotal">${{ number_format($item['precio'] * $item['cantidad'], 2) }}</span>
                                </div>
                                <a class="btn btn-sm btn-outline-danger" href="{{ route('carrito.eliminar', $id) }}">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </div>

                        </div>
                        <hr>
                        @empty
                        <div class="text-center">
                            <p>Tu carrito esta vacío</p>
                        </div>
                        @endforelse
                    </div>
                    @if (session('mensaje'))
                        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                            {{ session('mensaje') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                        </div>
                    @endif
                    <div class="card-footer bg-light">
                        <div class="row">
                            <div class="col text-end">
                                <a class="btn btn-outline-danger me-2" href="{{route('carrito.vaciar')}}">
                                    <i class="bi bi-x-circle me-1"></i>Vaciar carrito
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Resumen del Pedido</h5>
                    </div>
                    <div class="card-body">
                        @php
                            $total = 0;
                            foreach ($carrito as $item) {
                                $total += $item['precio'] * $item['cantidad'];
                            }
                        @endphp
                        <div class="d-flex justify-content-between mb-4">
                            <strong>Total</strong>
                            <strong id="orderTotal">${{ number_format($total, 2) }}</strong>
                        </div>
                        <!-- Checkout Button -->
                         <form action="{{route('pedido.realizar')}}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary w-100" id="checkout">
                                <i class="bi bi-credit-card me-1"></i>Realizar pedido
                            </button>
                        </form>
                        <!-- Continue Shopping -->
                        <a href="/" class="btn btn-outline-secondary w-100 mt-3">
                            <i class="bi bi-arrow-left me-1"></i>Continuar comprando
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection