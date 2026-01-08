@extends('layouts.app')

@section('title', 'Akun Saya - ZenithTix')

@section('content')
<div class="account-container">
    <div class="profile-card">
        <div class="profile-header">
            <div class="avatar-wrapper">
                <span class="material-symbols-outlined"></span>
            </div>
            <h2 class="profile-title">Akun Saya</h2>
            <p class="profile-subtitle">Kelola informasi profil ZenithTix Anda</p>
        </div>

        <div class="profile-body">
            <div class="info-group">
                <div class="info-item">
                    <span class="material-symbols-outlined icon">badge</span>
                    <div class="info-text">
                        <label>Nama Lengkap</label>
                        <p>{{ $user->name }}</p>
                    </div>
                </div>

                <div class="info-item">
                    <span class="material-symbols-outlined icon">mail</span>
                    <div class="info-text">
                        <label>Alamat Email</label>
                        <p>{{ $user->email }}</p>
                    </div>
                </div>
            </div>

            <div class="profile-footer">
                <form action="{{ route('logout') }}" method="POST" style="width: 100%;">
                    @csrf
                    <button class="logout-btn">
                        <span class="material-symbols-outlined"></span>
                        Logout dari Akun
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
/* Container Utama */
.account-container {
    min-height: 80vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
    margin-top: 50px;
}

/* Kartu Profil Glassmorphism */
.profile-card {
    width: 100%;
    max-width: 500px;
    background: rgba(255, 255, 255, 0.03);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 30px;
    overflow: hidden;
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.5);
    transition: transform 0.3s ease;
}

.profile-card:hover {
    transform: translateY(-5px);
    border-color: rgba(255, 215, 0, 0.3);
}

/* Bagian Atas (Header) */
.profile-header {
    background: linear-gradient(to bottom, rgba(255, 215, 0, 0.1), transparent);
    padding: 40px 20px 20px;
    text-align: center;
}

.avatar-wrapper {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, var(--gold), #b9982f);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 15px;
    box-shadow: 0 0 20px rgba(212, 175, 55, 0.4);
}

.avatar-wrapper .material-symbols-outlined {
    font-size: 40px;
    color: black;
}

.profile-title {
    color: var(--gold);
    font-size: 1.8rem;
    font-weight: 800;
    margin: 0;
    text-transform: uppercase;
    letter-spacing: 2px;
}

.profile-subtitle {
    color: #888;
    font-size: 0.9rem;
    margin-top: 5px;
}

/* Bagian Isi (Body) */
.profile-body {
    padding: 30px;
}

.info-group {
    display: flex;
    flex-direction: column;
    gap: 20px;
    margin-bottom: 30px;
}

.info-item {
    display: flex;
    align-items: center;
    gap: 15px;
    background: rgba(255, 255, 255, 0.05);
    padding: 15px;
    border-radius: 15px;
    border: 1px solid rgba(255, 255, 255, 0.05);
}

.info-item .icon {
    color: var(--gold);
    font-size: 24px;
}

.info-text label {
    display: block;
    color: #666;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.info-text p {
    color: white;
    font-weight: 600;
    margin: 0;
    font-size: 1rem;
}

/* Tombol Logout */
.logout-btn {
    width: 100%;
    padding: 14px;
    background: linear-gradient(90deg, #ff4b2b, #ff416c);
    color: white;
    font-weight: 700;
    border: none;
    border-radius: 15px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    transition: 0.3s;
    box-shadow: 0 10px 20px rgba(255, 75, 43, 0.2);
}

.logout-btn:hover {
    transform: scale(1.02);
    box-shadow: 0 15px 25px rgba(255, 75, 43, 0.4);
}
</style>