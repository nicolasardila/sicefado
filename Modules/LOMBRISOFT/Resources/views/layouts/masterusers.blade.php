<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ asset('images/Favicon2.png') }}" type="image/x-icon">
    <title>Gestión de Lombricultivo - SENA</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('AdminLTE/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- AdminLTE style -->
    <link rel="stylesheet" href="{{ asset('AdminLTE/dist/css/adminlte.min.css') }}">

    <style>
        :root {
            --sena-green: #39B54A;
            --sena-dark-green: #2E8B3E;
            --sena-light-green: #E8F5E9;
            --sena-white: #FFFFFF;
            --sena-light-gray: #F5F5F5;
        }
        
        body {
            background-color: var(--sena-light-gray);
            font-family: 'Source Sans Pro', sans-serif;
        }
        
        .navbar-dark {
            background-color: var(--sena-dark-green) !important;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .brand-text {
            color: var(--sena-white) !important;
            font-weight: 600;
        }
        
        .main-footer {
            background-color: var(--sena-dark-green) !important;
            color: var(--sena-white) !important;
            padding: 1rem 0;
            font-size: 0.9rem;
        }
        
        .btn-sena {
            background-color: var(--sena-green);
            border-color: var(--sena-dark-green);
            color: white;
            transition: all 0.3s ease;
        }
        
        .btn-sena:hover {
            background-color: var(--sena-dark-green);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        
        .welcome-header {
            background: linear-gradient(135deg, var(--sena-green) 0%, var(--sena-dark-green) 100%);
            color: white;
            padding: 2.5rem 1rem;
            margin-bottom: 2rem;
            border-radius: 0;
        }
        
        .feature-card {
            transition: transform 0.3s ease;
            border: none;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            height: 100%;
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
        }
        
        .feature-icon {
            color: var(--sena-green);
            font-size: 2rem;
            margin-bottom: 1rem;
        }
        
        .nav-link.active {
            border-bottom: 3px solid var(--sena-green);
            font-weight: 600;
        }
        
        .content-wrapper {
            background-color: transparent;
        }
        
        .quick-access-item {
            transition: all 0.3s ease;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
        }
        
        .quick-access-item:hover {
            border-color: var(--sena-green);
            transform: translateY(-3px);
        }
        
        /* Simplificación de elementos */
        .navbar-search-block {
            display: none;
        }
        
        .dropdown-menu {
            min-width: 220px;
            border: none;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        
        .card-sena {
            border: none;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .preloader {
            background-color: var(--sena-white);
        }
    </style>

    <!-- Custom JS -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="layout-top-nav">
<div class="wrapper">

    <!-- Preloader simplificado -->
    <div class="preloader flex-column justify-content-center align-items-center">
        <img src="{{ asset('./adminLTE/dist/img/logoS.png') }}" alt="SENA Logo" height="80">
    </div>

    <!-- Navbar más limpio -->
    <nav class="main-header navbar navbar-expand-md navbar-dark">
        <div class="container">
            <a href="#" class="navbar-brand d-flex align-items-center">
              
                <span class="brand-text ml-2">Lombricultivo SENA</span>
            </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a href="#" class="nav-link active">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">Módulos</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">Documentación</a>
                    </li>
                    @if(Auth::check() && checkRol('lombrisoft.admin'))
                    <li class="nav-item">
                        <a href="{{ route('lombrisoft.admin.welcome') }}" class="nav-link @if (Route::is('lombrisoft.admin.*')) active @endif">Admin</a>
                    </li>
                    @endif
                    @if(Auth::check() && checkRol('lombrisoft.intern'))
                    <li class="nav-item">
                        <a href="{{ route('lombrisoft.intern.paneli') }}" class="nav-link @if (Route::is('lombrisoft.intern.*')) active @endif">Pasante</a>
                    </li>
                    @endif
                    
                    <!-- User Dropdown simplificado -->
                    <li class="nav-item dropdown ml-md-2">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                            <i class="fas fa-user-circle mr-1"></i>
                            <span class="d-none d-md-inline">{{ Auth::user()->name ?? 'Usuario' }}</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                        
                       
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt mr-2"></i> Cerrar Sesión
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <div class="content-wrapper">
        <div class="content">
            <div class="container">
                <!-- Sección de Bienvenida más limpia -->
                <section class="welcome-header text-center">
                    <h1 class="mb-3" style="font-weight: 600;">Sistema de Gestión de Lombricultivo</h1>
                    <p class="lead mb-4">Herramienta profesional para la producción de humus de lombriz</p>
                    <div class="mt-3">
                        <a href="#" class="btn btn-light btn-lg mr-2">
                            <i class="fas fa-play-circle mr-1"></i> Tutorial
                        </a>
                    </div>
                </section>

                <!-- Tarjetas de Características simplificadas -->
                <div class="row">
                    <div class="col-md-4 mb-4">
                        <div class="card feature-card">
                            <div class="card-body text-center">
                                <div class="feature-icon">
                                    <i class="fas fa-chart-line"></i>
                                </div>
                                <h5>Monitoreo</h5>
                                <p class="text-muted">Seguimiento de parámetros críticos para producción óptima.</p>
                                <a href="#" class="btn btn-sena btn-sm">Explorar</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4 mb-4">
                        <div class="card feature-card">
                            <div class="card-body text-center">
                                <div class="feature-icon">
                                    <i class="fas fa-tasks"></i>
                                </div>
                                <h5>Actividades</h5>
                                <p class="text-muted">Programación y control de tareas del lombricultivo.</p>
                                <a href="#" class="btn btn-sena btn-sm">Gestionar</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4 mb-4">
                        <div class="card feature-card">
                            <div class="card-body text-center">
                                <div class="feature-icon">
                                    <i class="fas fa-file-alt"></i>
                                </div>
                                <h5>Reportes</h5>
                                <p class="text-muted">Informes detallados para análisis y decisiones.</p>
                                <a href="#" class="btn btn-sena btn-sm">Ver</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contenido Principal -->
                @yield('content')
                
                <!-- Sección de Acceso Rápido más limpia -->
                <div class="card card-sena mt-4 mb-5">
                    <div class="card-header bg-white border-0">
                        <h5 class="mb-0"><i class="fas fa-bolt text-green mr-2"></i>Acceso Rápido</h5>
                    </div>
                    <div class="card-body pt-0">
                        <div class="row text-center">
                            <div class="col-md-3 col-6 mb-3">
                                <a href="#" class="text-decoration-none text-dark">
                                    <div class="p-3 quick-access-item">
                                        <i class="fas fa-tint fa-lg text-primary mb-2"></i>
                                        <div>Humedad</div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-3 col-6 mb-3">
                                <a href="#" class="text-decoration-none text-dark">
                                    <div class="p-3 quick-access-item">
                                        <i class="fas fa-utensils fa-lg text-success mb-2"></i>
                                        <div>Alimentación</div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-3 col-6 mb-3">
                                <a href="#" class="text-decoration-none text-dark">
                                    <div class="p-3 quick-access-item">
                                        <i class="fas fa-thermometer-half fa-lg text-warning mb-2"></i>
                                        <div>Temperatura</div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-3 col-6 mb-3">
                                <a href="#" class="text-decoration-none text-dark">
                                    <div class="p-3 quick-access-item">
                                        <i class="fas fa-box-open fa-lg text-info mb-2"></i>
                                        <div>Cosecha</div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer simplificado -->
    <footer class="main-footer">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <p class="mb-0">Sistema de Gestión de Lombricultivo &copy; {{ date('Y') }} SENA</p>
                    <small class="text-white-50">v1.0.0 | {{ now()->format('d/m/Y') }}</small>
                </div>
            </div>
        </div>
    </footer>
</div>

<!-- Scripts -->
<script src="{{ asset('AdminLTE/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('AdminLTE/dist/js/adminlte.js') }}"></script>

<script>
    $(document).ready(function() {
        // Mostrar SweetAlert de bienvenida solo si es necesario
        @if(session('welcome'))
        Swal.fire({
            title: 'Bienvenido {{ Auth::user()->name ?? "Usuario" }}',
            text: 'Al sistema de gestión de lombricultivo del SENA',
            icon: 'success',
            confirmButtonColor: '#39B54A',
            confirmButtonText: 'Continuar',
            timer: 3000,
            timerProgressBar: true
        });
        @endif
    });
</script>
</body>
</html>