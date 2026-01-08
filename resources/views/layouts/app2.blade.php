<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>@yield('title', 'ZenithTix')</title>
  <meta name="description" content="ZenithTix — Sistem Pemesanan Tiket Bioskop" />

  <link rel="stylesheet" href="{{ asset('css/zenith.css') }}">
</head>

<body>

<header role="banner">
  <div class="container nav-row">
    <div class="logo">
      <div class="mark">ZT</div>
      ZenithTix
    </div>

    <nav class="primary">
      <a href="{{ url('/') }}">Home</a>
      <a href="{{ url('/#now') }}">Now Showing</a>
      <a href="{{ url('/comingsoon') }}">Coming Soon</a>
      <a href="{{ url('/about') }}">About</a>
    </nav>

    <div class="actions">
      <a href="{{ url('/akun') }}" class="icon-btn">👤</a>
      <button class="icon-btn" id="cartBtn">🛒</button>
      <button class="burger icon-btn" id="burger">☰</button>
    </div>
  </div>

  <!-- MOBILE NAV -->
  <div class="mobile-nav" id="mobileNav">
    <a href="{{ url('/') }}">Home</a>
    <a href="{{ url('/#now') }}">Now Showing</a>
    <a href="{{ url('/comingsoon') }}">Coming Soon</a>
    <a href="{{ url('/about') }}">About</a>
  </div>
</header>

<main>
  @yield('content')
</main>

<footer>
  <div class="container footer-grid">
    <div>
      <h4>Tentang</h4>
      <p>ZenithTix — demo UI sistem pemesanan tiket bioskop modern.</p>
    </div>
    <div>
      <h4>Link</h4>
      <ul>
        <li><a href="#now">Now Showing</a></li>
        <li><a href="/comingsoon">Coming Soon</a></li>
      </ul>
    </div>
    <div>
      <h4>Sosial</h4>
      <div style="display:flex;gap:10px">
        📸 🐦 📘
      </div>
    </div>
  </div>
</footer>

<script src="{{ asset('js/zenith.js') }}"></script>
<script>
document.getElementById('burger')?.addEventListener('click', () => {
  document.getElementById('mobileNav').classList.toggle('active');
});
</script>

</body>
</html>
