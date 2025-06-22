@extends('web.app')
@section('header')
@endsection
@section('contenido')
<form method="GET" action="{{route('web.index')}}">
    <div class="container px-4 px-lg-5 mt-4">
        <div class="row">
            <div class="col-md-8 mb-3">
                <div class="input-group">
                    <input type="text" class="form-control" id="searchInput" placeholder="Buscar productos..."
                        aria-label="Buscar productos" name="search" value="{{request('search')}}">
                    <button class="btn btn-outline-dark" type="submit" id="searchButton">
                        <i class="bi bi-search"></i> Buscar
                    </button>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="input-group">
                    <label class="input-group-text" for="sortSelect">Ordenar por:</label>
                    <select class="form-select" id="sortSelect" name="sort">
                        <option value="priceAsc" {{ request('sort') == 'priceAsc' ? 'selected' : '' }}>Precio: menor a
                            mayor</option>
                        <option value="priceDesc" {{ request('sort') == 'priceDesc' ? 'selected' : '' }}>Precio: mayor a
                            menor</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- Section-->
<section class="py-5">
    <div class="container px-4 px-lg-5 mt-1">
        <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
            @foreach($productos as $producto)
            <div class="col mb-5">
                <div class="card h-100">
                    <!-- Product image-->
                    <img class="card-img-top" src="{{asset('uploads/productos/'. $producto->imagen) }}"
                        alt="{{$producto->nombre}}" />
                    <!-- Product details-->
                    <div class="card-body p-4">
                        <div class="text-center">
                            <!-- Product name-->
                            <h5 class="fw-bolder">{{$producto->nombre}}</h5>
                            <!-- Product price-->
                            $ {{number_format($producto->precio, 2)}}
                        </div>
                    </div>
                    <!-- Product actions-->
                    <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                        <div class="text-center"><a class="btn btn-outline-dark mt-auto"
                                href="{{route('web.show', $producto->id)}}">Ver
                                producto</a></div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="card-footer clearfix">
            {{ $productos->appends(['search' => request('search'), 'sort' => request('sort')])->links() }}
        </div>
    </div>
    </div>
</section>
@endsection