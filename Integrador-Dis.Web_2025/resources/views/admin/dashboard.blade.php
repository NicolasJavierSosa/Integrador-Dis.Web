{{-- Blade template for Teacher Dashboard --}}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center bg-success text-white">
                        <h4>Admin Dashboard</h4>
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-outline-light btn-sm">Logout</button>
                        </form>
                    </div>
                    <div class="card-body">
                        <h5>Welcome, {{ auth()->user()->name }}!</h5>
                        <p>Este es tu dashboard de Administrador</p>
                        
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <h6>Gestionar Usuarios</h6>
                                        <p>Administra los usuarios del sistema</p>
                                        <a href="{{ route('admin.users') }}" class="btn btn-primary">Gestionar Usuarios</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <h6>Gestionar Cursos</h6>
                                        <p>Administra los cursos disponibles</p>
                                        <a href="{{ route('admin.courses') }}" class="btn btn-secondary">Gestionar Cursos</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
