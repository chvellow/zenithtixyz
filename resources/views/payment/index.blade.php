@extends('layouts.app')

@section('content')
<div class="container py-5" style="margin-top: 100px;">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card bg-dark text-white border-secondary p-4" style="border-radius: 20px;">
                <h4 class="fw-bold text-center mb-4">Ringkasan Pembayaran</h4>
                
                <div class="d-flex justify-content-between mb-2">
                    <span>Film</span>
                    <span class="text-warning fw-bold">{{ $order->schedule->movie->title }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Kursi</span>
                    <span class="text-info">{{ $order->seats }}</span>
                </div>
                <hr class="border-secondary">
                <div class="d-flex justify-content-between mb-4">
                    <span class="h5">Total Bayar</span>
                    <span class="h4 fw-bold text-warning">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                </div>

                <form action="{{ route('payment.process', $order->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-warning w-100 fw-bold py-3" style="border-radius: 12px;">
                        BAYAR SEKARANG
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="alert alert-warning text-center">
    <h5 class="m-0">Selesaikan pembayaran dalam: <span id="timer" class="fw-bold text-danger">--:--</span></h5>
</div>

<script>
    // Ambil sisa detik langsung dari server agar akurat
    @php
        $now = \Carbon\Carbon::now();
        $expires = $order->created_at->addMinutes(5);
        $remainingSeconds = $now->greaterThan($expires) ? 0 : $now->diffInSeconds($expires);
    @endphp

    let timeLeft = {{ $remainingSeconds }}; 

    function updateTimer() {
        if (timeLeft <= 0) {
            alert("Waktu habis! Kursi dilepas kembali.");
            window.location.href = "{{ route('landing') }}";
            return;
        }

        let minutes = Math.floor(timeLeft / 60);
        let seconds = timeLeft % 60;

        // Tambah angka 0 di depan jika di bawah 10
        seconds = seconds < 10 ? '0' + seconds : seconds;
        minutes = minutes < 10 ? '0' + minutes : minutes;

        document.getElementById("timer").innerHTML = minutes + ":" + seconds;
        timeLeft--;
    }

    // Jalankan setiap detik
    setInterval(updateTimer, 1000);
    updateTimer(); // Jalankan sekali di awal
</script>
@endsection