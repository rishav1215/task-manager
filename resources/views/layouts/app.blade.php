<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Favicon -->
    <link rel="icon" href="https://laravel.com/img/favicon/favicon.ico">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 with Dark Mode -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-dark-5@1.1.3/dist/css/bootstrap-night.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary-color: #6366f1;
            --secondary-color: #8b5cf6;
            --gradient: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        body.dark {
            background-color: #0f172a;
            color: #e2e8f0;
        }
        
        .navbar {
            backdrop-filter: blur(10px);
            background-color: rgba(155, 128, 128, 0.8) !important;
        }
        
        .dark .navbar {
            background-color: rgba(146, 153, 170, 0.8) !important;
        }
        
      .navbar-brand {
        font-weight: 700;
        color: var(--primary-color) !important;
    }

    .dark .navbar-brand {
        color: #8b5cf6 !important;
    }

    .navbar-brand i {
        /* Make the rocket icon match the text color */
        background: var(--gradient);
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
    }
        
        .btn-primary {
            background: var(--gradient);
            border: none;
        }
        
        .btn-outline-primary {
            border-color: var(--primary-color);
            color: var(--primary-color);
        }
        
        .btn-outline-primary:hover {
            background: var(--gradient);
            color: white;
        }
        
        #app {
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        
        main {
            flex: 1;
        }
        
        .dropdown-menu {
            border: none;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        
        .dark .dropdown-menu {
            background-color: #1e293b;
        }
        
        .dark .dropdown-item {
            color: #e2e8f0;
        }
        
        .dark .dropdown-item:hover {
            background-color: #334155;
            color: white;
        }
        
        .theme-toggle {
            cursor: pointer;
            font-size: 1.25rem;
            margin-left: 1rem;
        }
    </style>
</head>
<body class="{{ Cookie::get('dark_mode') ? 'dark' : '' }}">
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light shadow-sm py-3">
            <div class="container">
                <a class="navbar-brand fs-3" href="{{ url('/') }}">
                    <i class="fas fa-rocket me-2"></i>{{ config('app.name', 'task-manager') }}
                </a>
                
                <div class="d-flex align-items-center">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    
                    <div class="theme-toggle ms-3" id="themeToggle">
                        <i class="fas {{ Cookie::get('dark_mode') ? 'fa-sun' : 'fa-moon' }}"></i>
                    </div>
                </div>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-center">
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item me-2">
                                    <a class="btn btn-outline-primary rounded-pill px-4" href="{{ route('login') }}">
                                        <i class="fas fa-sign-in-alt me-2"></i>{{ __('Login') }}
                                    </a>
                                </li>
                            @endif
                            
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="btn btn-primary rounded-pill px-4" href="{{ route('register') }}">
                                        <i class="fas fa-user-plus me-2"></i>{{ __('Register') }}
                                    </a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                                    <div class="avatar me-2">
                                        <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                            <span class="text-white">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                                        </div>
                                    </div>
                                    {{ Auth::user()->name }}
                                </a>
                                
                                <div class="dropdown-menu dropdown-menu-end shadow">
                                    <a class="dropdown-item" href="#">
                                        <i class="fas fa-user-circle me-2"></i> Profile
                                    </a>
                                    <a class="dropdown-item" href="#">
                                        <i class="fas fa-cog me-2"></i> Settings
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item text-danger" href="{{ route('login') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt me-2"></i>{{ __('logout') }}
                                    </a>
                                    
                                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            <div class="container">
                @yield('content')
            </div>
        </main>
        
        <footer class="bg-body-tertiary py-4 mt-auto">
            <div class="container text-center">
                <p class="mb-0">&copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. All rights reserved.</p>
            </div>
        </footer>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Dark Mode Toggle -->
    <script>
        document.getElementById('themeToggle').addEventListener('click', function() {
            document.body.classList.toggle('dark');
            const isDark = document.body.classList.contains('dark');
            this.innerHTML = `<i class="fas ${isDark ? 'fa-sun' : 'fa-moon'}"></i>`;
            
            // Set cookie to remember preference
            document.cookie = `dark_mode=${isDark ? '1' : '0'}; path=/; max-age=${60 * 60 * 24 * 365}`;
        });
    </script>
</body>
</html>