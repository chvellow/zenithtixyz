@extends('layouts.app')

@section('title', 'Login | ZenithTix')

@section('content')

<style>
.auth-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 60px 20px;
}

.auth-box {
    width: 420px;
    padding: 34px 40px;
    border-radius: 22px;

    background: rgba(255,255,255,0.06);
    border: 1px solid rgba(255,255,255,0.15);
    backdrop-filter: blur(18px);

    box-shadow: 0 0 24px rgba(255,221,0,0.12);
    color: var(--white);
    animation: fadeUp 1s ease-out;
}

.auth-title {
    font-size: 2rem;
    font-weight: 800;
    color: var(--yellow);
    text-align: center;
    margin-bottom: 20px;
    text-shadow: 0 0 12px rgba(255,221,0,0.4);
}

.auth-box label {
    font-weight: 600;
    color: var(--white);
    opacity: .85;
}

.auth-input {
    width: 100%;
    padding: 12px 14px;
    border-radius: 12px;
    margin-top: 6px;
    margin-bottom: 18px;
    background: rgba(255,255,255,0.08);
    border: 1px solid rgba(255,255,255,0.18);
    color: var(--white);
}

.auth-input:focus {
    border-color: var(--yellow);
    outline: none;
}

.auth-btn {
    width: 100%;
    padding: 12px 20px;
    font-weight: 700;
    border: none;
    border-radius: 12px;
    background: linear-gradient(90deg, var(--yellow), var(--red));
    color: #000;
    cursor: pointer;
    margin-top: 6px;
    transition: 0.25s;
}

.auth-btn:hover {
    transform: scale(1.05);
    box-shadow: 0 0 16px rgba(255,221,0,0.4);
}

.auth-extra {
    text-align: center;
    margin-top: 18px;
    opacity: .85;
}

.auth-extra a {
    color: var(--yellow);
    font-weight: 600;
}
</style>

<div class="auth-wrapper">

    <div class="auth-box">

        <h2 class="auth-title">Welcome Back</h2>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <label>Email</label>
            <input type="email" name="email" class="auth-input" placeholder="Masukkan email kamu" required>

            <label>Password</label>
            <input type="password" name="password" class="auth-input" placeholder="••••••••" required>

            <button class="auth-btn">Login</button>
        </form>

        <div class="auth-extra">
            Belum punya akun?  
            <a href="{{ route('register') }}">Daftar di sini</a>
        </div>

    </div>

</div>

@endsection
