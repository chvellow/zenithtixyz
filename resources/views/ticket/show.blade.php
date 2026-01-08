@extends('layouts.app')

@section('title', 'Tiket')

@section('content')
<div class="container text-center">

    <h2 class="fw-bold mb-4">Tiket Kamu</h2>

    <img src="data:image/png;base64,{{ $barcode }}" class="mb-4">

    <h4>{{ $ticket->movie->title }}</h4>
    <p>{{ $ticket->schedule->date }} | {{ $ticket->schedule->time }}</p>
    <p>Kursi: {{ implode(', ', $ticket->seats) }}</p>

    <a href="{{ route('history.index') }}" class="btn btn-secondary mt-3">Kembali</a>

</div>
@endsection
