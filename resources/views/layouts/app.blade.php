<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <title>@yield('title', 'ZenithTix')</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/zenith.css') }}">
    
    @stack('styles')

    <style>
        :root {
            --primary-gold: #ffd43b;
            --glass-bg: rgba(10, 10, 10, 0.75);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #0a0a0a;
            color: #ffffff;
            margin: 0;
            padding: 0;
        }

        /* Navbar Styling */
        .navbar-glass {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            background: var(--glass-bg);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            padding: 15px 0;
        }

        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
        }

        .logo {
            font-size: 24px;
            font-weight: 800;
            color: var(--primary-gold);
            text-decoration: none;
            letter-spacing: -1px;
        }

        .nav-center {
            display: flex;
            gap: 30px;
        }

        .nav-center a {
            color: #ccc;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            transition: 0.3s;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .nav-center a:hover {
            color: var(--primary-gold);
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .login-btn {
            background: var(--primary-gold);
            color: #000;
            padding: 8px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 700;
            font-size: 14px;
            transition: 0.3s;
        }

        .login-btn:hover {
            background: #fff;
            transform: translateY(-2px);
        }

        .logout-icon {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #ff4d4d;
            width: 38px;
            height: 38px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: 0.3s;
        }

        .logout-icon:hover {
            background: #ff4d4d;
            color: #fff;
        }

        /* Wrapper konten utama agar tidak tertutup Navbar */
        .page-wrapper {
            padding-top: 80px; /* Sesuai tinggi navbar */
            min-height: 100vh;
        }

        /* Mobile Sidebar (Hide by default) */
        .mobile-sidebar {
            display: none;
        }
    </style>
</head>
<body>

    <header class="navbar-glass">
        <div class="nav-container">
            <a href="/" class="logo">Zenith<span style="color:white">Tix</span></a>
            
            <nav class="nav-center d-none d-md-flex">
                <a href="/">Home</a>
                <a href="/movies">Movies</a>
                <a href="/history">Riwayat</a>
                <a href="/account">Akun</a>
            </nav>

            <div class="nav-actions">
                @guest
                    <a href="{{ route('login') }}" class="login-btn">Login</a>
                @else
                    <div class="d-flex align-items-center gap-3">
                        <span class="small d-none d-lg-inline text-secondary">Halo, {{ Auth::user()->name }}</span>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="logout-icon" title="Logout">
                                <i class="fas fa-power-off"></i>
                            </button>
                        </form>
                    </div>
                @endguest
            </div>
        </div>
    </header>

    <main class="page-wrapper">
        @yield('content')
    </main>

    <footer class="py-4 text-center border-top border-white border-opacity-10 mt-5">
        <p class="text-secondary small mb-0">&copy; 2026 ZenithTix Cinema. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/zenith.js') }}?v={{ time() }}"></script>
    @stack('scripts')

</body>
</html>