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
                        <h3 class="card-title">Perfil del usuario</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        @if (session('mensaje'))
                            <div class="alert alert-success">
                                {{ session('mensaje') }}
                            </div>
                        @endif
                        <form action="{{ route('perfil.update')}}" method="POST" id="formRegistroUsuario">
                            @csrf
                            @method('PUT')                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Nombre</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                     id="name" name="name" value="{{old('name', $registro->name ??'')}}" required>
                                     @error('name')
                                        <small class="text-danger">{{$message}}</small>
                                     @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="text" class="form-control @error('email') is-invalid @enderror"
                                     id="email" name="email" value="{{old('email',  $registro->email ??'')}}" required>
                                     @error('email')
                                        <small class="text-danger">{{$message}}</small>
                                     @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="text" class="form-control @error('password') is-invalid @enderror"
                                     id="password" name="password" value="{{old('password')}}">
                                     @error('password')
                                        <small class="text-danger">{{$message}}</small>
                                     @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="password_confirmation" class="form-label">Confirme el password</label>
                                    <input type="text" class="form-control @error('password_confirmation') is-invalid @enderror"
                                     id="password_confirmation" name="password_confirmation" value="{{old('password_confirmation')}}">
                                     @error('password_confirmation')
                                        <small class="text-danger">{{$message}}</small>
                                     @enderror
                                </div>
                            </div>
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="button" class="btn btn-secondary me-md-2"
                                    onclick="window.location.href='{{route('dashboard')}}'">Cancelar</button>
                                <button type="submit" class="btn btn-primary">Actualizar datos</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer clearfix">

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