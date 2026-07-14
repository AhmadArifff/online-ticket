<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Online Ticket Booking') - Tiket Online</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .navbar {
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: white !important;
        }
        
        .nav-link {
            color: rgba(255, 255, 255, 0.85) !important;
            transition: color 0.3s;
        }
        
        .nav-link:hover {
            color: white !important;
        }
        
        footer {
            background-color: #343a40;
            color: #ecf0f1;
            margin-top: 4rem;
            padding: 2rem 0;
        }
        
        footer a {
            color: #ecf0f1;
            text-decoration: none;
        }
        
        footer a:hover {
            color: white;
        }
        
        .card {
            border: none;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, #5568d3 0%, #6a3d94 100%);
        }
        
        .badge-status {
            font-size: 0.85rem;
            padding: 0.35rem 0.65rem;
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">
                <i class="fas fa-ticket-alt"></i> Tiket Online
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/events">Event</a>
                    </li>
                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="/my-bookings">Booking Saya</a>
                        </li>
                        @if(auth()->user()->isAdmin())
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.dashboard') }}">Admin Panel</a>
                            </li>
                        @endif
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=667eea&color=fff&rounded=true&size=32' }}" alt="Avatar" class="rounded-circle" width="32" height="32">
                                <span class="ms-2">{{ auth()->user()->name }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                @if(Route::has('profile.edit'))
                                    <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Edit Profil</a></li>
                                @endif
                                @if(Route::has('bookings.index'))
                                    <li><a class="dropdown-item" href="{{ route('bookings.index') }}">Booking Saya</a></li>
                                @endif
                                @if(auth()->user()->isAdmin())
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}"><i class="fas fa-cog me-2"></i>Admin Panel</a></li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                @if(Route::has('logout'))
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="dropdown-item">Logout</button>
                                        </form>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="/login">Login</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="py-4">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4 mb-3 mb-md-0">
                    <h5>Tentang Kami</h5>
                    <p>Platform pemesanan tiket online untuk event, konser, dan seminar dengan mudah dan aman.</p>
                </div>
                <div class="col-md-4 mb-3 mb-md-0">
                    <h5>Link Cepat</h5>
                    <ul class="list-unstyled">
                        <li><a href="/events">Daftar Event</a></li>
                        <li><a href="/my-bookings">Booking Saya</a></li>
                        <li><a href="/">Beranda</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Kontak</h5>
                    <p>
                        <i class="fas fa-envelope"></i> <a href="mailto:info@tiketonline.com">info@tiketonline.com</a><br>
                        <i class="fas fa-phone"></i> +62 812 3456 7890
                    </p>
                </div>
            </div>
            <hr class="my-3">
            <div class="text-center">
                <p>&copy; 2026 Tiket Online. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Toast component (global) --}} 
    @include('components.toast')

    {{-- Server-side flash toast data for client script to auto-show --}}
    @if(session()->has('toast'))
        <script id="server-toast-data" type="application/json">{!! json_encode(session('toast')) !!}</script>
    @else
        <script id="server-toast-data" type="application/json">null</script>
    @endif

    @stack('scripts')
</body>
</html>
