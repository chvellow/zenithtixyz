@extends('admin.layouts.app')

@section('content')
<div class="main-content-wrapper">
<div class="container-fluid">
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('admin.schedules.index') }}" class="btn-back-circle me-3"><i class="fas fa-arrow-left"></i></a>
        <h2 class="admin-title m-0">Tambah Jadwal Tayang</h2>
    </div>

    <div class="row">
        <div class="col-md-7">
            <form action="{{ route('admin.schedules.store') }}" method="POST" class="form-glass p-4">
                @csrf
                <div class="mb-3">
                    <label class="small text-secondary mb-2">Pilih Film</label>
                    <select name="movie_id" class="form-select custom-input" required>
                        <option value="" disabled selected>Pilih Film</option>
                        @foreach($movies as $movie)
                            <option value="{{ $movie->id }}">{{ $movie->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="small text-secondary mb-2">Pilih Studio</label>
                    <select name="studio_id" class="form-select custom-input" required>
                        <option value="" disabled selected>Pilih Studio</option>
                        @foreach($studios as $studio)
                            <option value="{{ $studio->id }}">{{ $studio->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="small text-secondary mb-2">Tanggal</label>
                        <input type="date" name="date" id="dateInput" class="form-control custom-input" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="small text-secondary mb-2">Jam Tayang</label>
                        <input type="time" name="time" class="form-control custom-input" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="small text-secondary mb-2">Harga Tiket (Rp)</label>
                    <div class="input-group">
                        <span class="input-group-text border-0 bg-dark text-secondary">Rp</span>
                        <input type="number" name="price" id="priceInput" class="form-control custom-input text-warning fw-bold" placeholder="0" required>
                    </div>
                    <div id="priceInfo" class="mt-2" style="display: none;">
                        <span id="dayStatus" class="badge px-3 py-2"></span>
                    </div>
                </div>

                <button type="submit" class="btn-submit w-100 py-3">SIMPAN JADWAL</button>
            </form>
        </div>

        <div class="col-md-5">
            <div class="form-glass p-4 border-info" style="border-left: 4px solid #3498db !important;">
                <h5 class="text-info fw-bold mb-3"><i class="fas fa-info-circle me-2"></i>Aturan Harga</h5>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-secondary">Senin - Jumat (Weekdays)</span>
                    <span class="text-white fw-bold">Rp 35.000</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span class="text-secondary">Sabtu - Minggu (Weekend)</span>
                    <span class="text-danger fw-bold">Rp 50.000</span>
                </div>
                <hr class="border-secondary opacity-25">
                <p class="small text-secondary mb-0">Harga akan terisi otomatis berdasarkan tanggal yang dipilih, namun Anda tetap bisa mengubahnya secara manual.</p>
            </div>
        </div>
    </div>
</div>

<style>
    .custom-input { background: rgba(0,0,0,0.3) !important; border: 1px solid rgba(255,255,255,0.1) !important; color: white !important; border-radius: 12px; padding: 12px; }
    .custom-input:focus { border-color: #ffd43b !important; box-shadow: none; }
    input[type="date"]::-webkit-calendar-picker-indicator, input[type="time"]::-webkit-calendar-picker-indicator { filter: invert(1); opacity: 0.5; }
</style>

<script>
document.getElementById('dateInput').addEventListener('change', function() {
    const date = new Date(this.value);
    const day = date.getDay(); // 0 = Minggu, 6 = Sabtu
    const priceInput = document.getElementById('priceInput');
    const priceInfo = document.getElementById('priceInfo');
    const dayStatus = document.getElementById('dayStatus');

    priceInfo.style.display = 'block';
    if (day === 6 || day === 0) {
        priceInput.value = 50000;
        dayStatus.innerText = "⚡ Weekend Rate (50k)";
        dayStatus.className = "badge bg-danger bg-opacity-25 text-danger border border-danger border-opacity-25";
    } else {
        priceInput.value = 35000;
        dayStatus.innerText = "✨ Weekday Rate (35k)";
        dayStatus.className = "badge bg-info bg-opacity-25 text-info border border-info border-opacity-25";
    }
});
</script>
@endsection