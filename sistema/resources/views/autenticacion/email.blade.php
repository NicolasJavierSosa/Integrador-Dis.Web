@extends('autenticacion.app')
@section('titulo', 'Sistema - Recuperar Password')
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
    <p class="login-box-msg">Ingrese su email para recuperar su password</p>
    @if(session('error'))
      <div class="alert alert-danger">
        {{session('error')}}
      </div>
    @endif
    <form action="{{route('password.send-link')}}" method="post">
      @csrf
        @if(Session::has('mensaje'))
            <div class="alert alert-info alert-dismissible fade show mt-2">
                {{Session::get('mensaje')}}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="close"></button>
            </div>
        @endif
      <div class="input-group mb-1">
        <div class="form-floating">
          <input id="loginEmail" type="email" name="email" value="{{old('email')}}" class="form-control" value="" placeholder="" />
          <label for="loginEmail">Email</label>
        </div>
        <div class="input-group-text"><span class="bi bi-envelope"></span></div>
        @error('email')
          <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
      </div>
      <!--begin::Row-->
      <div class="row">
        <!-- /.col -->
        <div class="col-4">
          <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary">Enviar enlace de recuperación</button>
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