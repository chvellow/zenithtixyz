@extends('layouts.app')

@section('title', 'Keranjang')

@section('content')
<div class="container">
    <h2 class="fw-bold mb-4">Keranjang Tiket</h2>

    <form action="{{ route('payment.index') }}" method="GET">

        <div class="list-group">

            @foreach($cartItems as $item)
            <label class="list-group-item d-flex gap-3">

                <input class="form-check-input flex-shrink-0" type="checkbox"
                       name="selected[]" value="{{ $item->id }}">

                <img src="{{ $item->movie->poster }}" width="70">

                <div>
                    <strong>{{ $item->movie->title }}</strong><br>
                    Jadwal: {{ $item->schedule->date }} {{ $item->schedule->time }}<br>
                    Kursi: {{ implode(', ', $item->seats) }}<br>
                    <span class="text-success fw-bold">Rp {{ number_format($item->price) }}</span>
                </div>

            </label>
            @endforeach

        </div>

        <button class="btn btn-success mt-3 w-100">Bayar Sekarang</button>

    </form>
</div>
@endsection
