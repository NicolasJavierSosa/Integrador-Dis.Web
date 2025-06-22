@extends('autenticacion.app')
@section('titulo', 'Sistema - Registro')
@section('contenido')
<div class="card card-outline card-primary">
  <div class="card-header">
    <a
      href="/"
      class="link-dark text-center link-offset-2 link-opacity-100 link-opacity-50-hover"
    >
      <h1 class="mb-0"><b>Sistema</b>LTE</h1>
    </a>
  </div>
  <div class="card-body login-card-body">
    <p class="login-box-msg">Registro</p>
    @if(session('error'))
      <div class="alert alert-danger">
        {{session('error')}}
      </div>
    @endif
    <form action="{{route('registro.store')}}" method="post">
      @csrf
      <div class="input-group mb-1">
        <div class="form-floating">
          <input id="name" type="text" name="name" value="{{old('name')}}" class="form-control @error('name') is-invalid @enderror" placeholder="Ingrese nombre" />
          <label for="name">Nombre</label>
        </div>
        <div class="input-group-text"><span class="bi bi-envelope"></span></div>
        @error('name')
          <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
      </div>
      <div class="input-group mb-1">
        <div class="form-floating">
          <input id="loginEmail" type="email" name="email" value="{{old('email')}}" class="form-control @error('email') is-invalid @enderror" placeholder="" />
          <label for="loginEmail">Email</label>
        </div>
        <div class="input-group-text"><span class="bi bi-envelope"></span></div>
        @error('email')
          <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
      </div>
      <div class="input-group mb-1">
        <div class="form-floating">
          <input id="loginPassword" type="text" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="" />
          <label for="loginPassword">Password</label>
        </div>
        <div class="input-group-text"><span class="bi bi-lock-fill"></span></div>
        @error('password')
          <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
      </div>
      <div class="input-group mb-1">
        <div class="form-floating">
          <input id="password_confirmation" type="text" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="" />
          <label for="password_confirmation">Confirme su password</label>
        </div>
        <div class="input-group-text"><span class="bi bi-lock-fill"></span></div>
        @error('password_confirmation')
          <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
      </div>
      <!--begin::Row-->
      <div class="row">
        <!-- /.col -->
        <div class="col-4">
          <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary">Registrar</button>
          </div>
        </div>
        <!-- /.col -->
      </div>
      <!--end::Row-->
    </form>
    <!-- /.social-auth-links -->
  </div>
  <!-- /.login-card-body -->
</div>
@endsection

      