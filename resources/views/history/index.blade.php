@extends('layouts.app')

@section('content')
<div class="container py-5" style="margin-top: 100px;">
    <h2 class="fw-bold mb-4 text-white text-center">Riwayat Tiket Saya</h2>

    <div class="row justify-content-center">
        @forelse($orders as $order)
        <div class="col-md-5 mb-4">
            <div class="card bg-dark text-white border-secondary h-100 shadow" style="border-radius: 20px;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            {{-- Cek apakah data schedule dan movie masih ada di DB --}}
                            @if($order->schedule && $order->schedule->movie)
                                <h4 class="fw-bold text-warning mb-1">{{ $order->schedule->movie->title }}</h4>
                                <span class="text-secondary small">{{ $order->schedule->studio->name }}</span>
                            @else
                                <h4 class="fw-bold text-danger mb-1">Film Tidak Tersedia</h4>
                                <span class="text-secondary small">Jadwal telah dihapus</span>
                            @endif
                        </div>
                        <span class="badge {{ $order->status == 'paid' ? 'bg-success' : ($order->status == 'cancelled' ? 'bg-danger' : 'bg-warning text-dark') }} px-3 py-2">
                            {{ strtoupper($order->status) }}
                        </span>
                    </div>

                    <div class="mb-3">
                        <p class="mb-1 text-secondary small">KURSI</p>
                        <h5 class="fw-bold">{{ $order->seats }}</h5>
                    </div>

                    <div class="d-flex justify-content-between border-top border-secondary pt-3">
                        <div>
                            <p class="mb-0 text-secondary small">TOTAL BAYAR</p>
                            <p class="fw-bold text-warning mb-0">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                        </div>
                        <div class="text-end">
                            @if($order->status == 'paid')
                                <a href="{{ route('ticket.show', $order->id) }}" class="btn btn-sm btn-outline-light px-4">LIHAT TIKET</a>
                            @elseif($order->status == 'pending')
                                <a href="{{ route('payment.index', $order->id) }}" class="btn btn-sm btn-warning px-4 text-dark fw-bold">BAYAR</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center text-secondary py-5">
            <i class="fas fa-ticket-alt fa-3x mb-3"></i>
            <h5>Belum ada transaksi. Ayo pesan tiket pertamamu!</h5>
            <a href="{{ route('landing') }}" class="btn btn-warning mt-3 px-4 fw-bold">Cari Film</a>
        </div>
        @endforelse
    </div>
</div>
@endsection