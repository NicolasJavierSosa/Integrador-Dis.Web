@extends('autenticacion.app')
@section('titulo', 'Sistema - Cambiar Password')
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
    <p class="login-box-msg">Cambiar password</p>
    @if(session('error'))
      <div class="alert alert-danger">
        {{session('error')}}
      </div>
    @endif
    <form action="{{route('password.update')}}" method="post">
      @csrf
      <input type="hidden" name="token" value="{{ $token }}">
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
          <label for="loginPassword">Nuevo Password</label>
        </div>
        <div class="input-group-text"><span class="bi bi-lock-fill"></span></div>
        @error('password')
          <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
      </div>
      <div class="input-group mb-1">
        <div class="form-floating">
          <input id="password_confirmation" type="text" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="" />
          <label for="password_confirmation">Confirme su nuevo password</label>
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
            <button type="submit" class="btn btn-primary">Actualizar password</button>
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

      