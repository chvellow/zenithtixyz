<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel')</title>

    <style>
        :root {
            --bg-dark: #0b0b0c;
            --glass: rgba(255,255,255,0.06);
            --glass-border: rgba(255,255,255,0.12);
            --yellow: #ffdd00;
            --red: #ff0000;
            --white: #ffffff;
        }

        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background: var(--bg-dark);
            color: var(--white);
            display: flex;
        }

        /* SIDEBAR */
        .sidebar {
            width: 250px;
            height: 100vh;
            background: var(--glass);
            border-right: 1px solid var(--glass-border);
            backdrop-filter: blur(12px);
            padding: 22px;
            position: fixed;
            top: 0;
            left: 0;
        }

        .sidebar h2 {
            font-size: 1.4rem;
            font-weight: 800;
            color: var(--yellow);
            margin-bottom: 30px;
        }

        .sidebar a {
            display: block;
            padding: 12px 16px;
            margin-bottom: 8px;
            text-decoration: none;
            color: var(--white);
            font-weight: 600;
            border-radius: 10px;
            transition: 0.25s;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: linear-gradient(90deg, var(--yellow), var(--red));
            color: #000;
        }

        .logout-btn {
            margin-top: 30px;
            background: rgba(255,0,0,0.2);
            border: 1px solid rgba(255,0,0,0.5);
            color: var(--red);
            text-align: center;
        }

        /* CONTENT */
        .content {
            margin-left: 270px;
            padding: 30px;
            width: calc(100% - 270px);
        }

        .card {
            background: var(--glass);
            padding: 20px;
            border-radius: 16px;
            border: 1px solid var(--glass-border);
            backdrop-filter: blur(10px);
            margin-bottom: 20px;
        }
    </style>

</head>

<body>

    <!-- SIDEBAR -->
    <div class="sidebar">
        <h2>Zenith Admin</h2>

        <a href="{{ route('admin.dashboard') }}" 
            class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            Dashboard
        </a>

        <a href="{{ route('admin.movies.index') }}" 
            class="{{ request()->routeIs('admin.movies.*') ? 'active' : '' }}">
            Kelola Film
        </a>

        <a href="{{ route('admin.schedules.index') }}" 
            class="{{ request()->routeIs('admin.schedules.*') ? 'active' : '' }}">
            Kelola Jadwal
        </a>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="logout-btn" style="width:100%; padding:12px; border-radius:10px; cursor:pointer;">
                Logout
            </button>
        </form>
    </div>

    <!-- CONTENT -->
    <div class="content">
        @yield('content')
    </div>

</body>
</html>
