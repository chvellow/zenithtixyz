<nav class="navbar navbar-expand-lg glass mt-3 mx-3 px-3">
    <a class="navbar-brand" href="/">ZenithTix</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
        data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">

            <li class="nav-item"><a class="nav-link" href="/movies">Film</a></li>
            <li class="nav-item"><a class="nav-link" href="/history">Riwayat</a></li>
            <li class="nav-item"><a class="nav-link" href="/cart">Keranjang</a></li>
            <li class="nav-item"><a class="nav-link" href="/account">Akun</a></li>

            @guest
                <li class="nav-item"><a class="btn btn-zt ms-3" href="/login">Login</a></li>
            @endguest

            @auth
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="btn btn-zt ms-3">Logout</button>
                </form>
            @endauth

        </ul>
    </div>
</nav>
