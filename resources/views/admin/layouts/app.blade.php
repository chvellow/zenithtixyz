<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | @yield('title', 'Dashboard')</title>
    
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <style>
    /* Reset dasar agar tidak ada double scroll */
    body, html {
        margin: 0;
        padding: 0;
        height: 100vh;
        width: 100vw;
        overflow: hidden; 
        background: #0b0e11;
        font-family: 'Poppins', sans-serif;
    }

    .admin-wrapper {
        display: flex;
        width: 100%;
        height: 100%;
    }

    /* Sidebar - Tetap di tempat */
    .admin-sidebar {
        width: 280px;
        height: 100vh;
        background: rgba(20, 20, 22, 0.95);
        backdrop-filter: blur(20px);
        border-right: 1px solid rgba(255, 255, 255, 0.05);
        flex-shrink: 0; /* Penting: Sidebar tidak boleh mengecil */
        display: flex;
        flex-direction: column;
        padding: 30px 20px;
        z-index: 1000;
    }

    /* Main Content Area - Area yang bisa scroll */
    .content-area {
        flex-grow: 1; /* Mengambil sisa ruang layar */
        height: 100vh;
        overflow-y: auto; /* Scroll hanya di sini */
        padding: 40px;
        box-sizing: border-box;
        background: #0b0e11;
        position: relative;
    }

    /* Merapikan Table agar tidak berantakan di layar kecil */
    .table-responsive {
        width: 100%;
        overflow-x: auto;
        background: rgba(255, 255, 255, 0.03);
        border-radius: 15px;
        border: 1px solid rgba(255, 255, 255, 0.05);
    }

    table {
        width: 100%;
        border-collapse: collapse;
        color: rgba(255,255,255,0.8);
    }

    th {
        background: rgba(255, 255, 255, 0.05);
        color: var(--yellow);
        text-align: left;
        padding: 15px;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 1px;
    }

    td {
        padding: 15px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }
</style>
</head>
<body>

<div class="admin-wrapper">

    <aside class="admin-sidebar">
        <h2 style="color: #ffd43b;">Zenith<span style="color: #fff;">Tix</span></h2>

        <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fas fa-chart-pie"></i> Dashboard
        </a>

        <a href="{{ route('admin.movies.index') }}" class="nav-item {{ request()->routeIs('admin.movies.*') ? 'active' : '' }}">
            <i class="fas fa-film"></i> Kelola Film
        </a>

        <a href="{{ route('admin.schedules.index') }}" class="nav-item {{ request()->routeIs('admin.schedules.*') ? 'active' : '' }}">
            <i class="fas fa-calendar-alt"></i> Kelola Jadwal
        </a>

        <a href="{{ route('admin.studios.index') }}" class="nav-item {{ request()->routeIs('admin.studios.*') ? 'active' : '' }}">
            <i class="fas fa-door-open"></i> Kelola Studio
        </a>

        <a href="{{ route('admin.orders.index') }}" class="nav-item {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
            <i class="fas fa-ticket-alt"></i> Kelola Pemesanan
        </a>

        

        <form action="{{ route('logout') }}" method="POST" class="mt-auto">
            @csrf
            <button class="btn-logout">
                <i class="fas fa-sign-out-alt me-2"></i> Logout
            </button>
        </form>
    </aside>

    <main class="content-area">
        @yield('content')
        <div style="height: 50px;"></div>
    </main>

</div>

</body>
</html>