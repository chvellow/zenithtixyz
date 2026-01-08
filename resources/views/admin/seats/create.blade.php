@extends('admin.layouts.app')

@section('title', 'Tambah Kursi')

@section('content')

<h2 class="admin-title">Tambah Kursi Baru</h2>

<form action="{{ route('admin.seats.store') }}" method="POST" class="form-glass">
    @csrf

    <label>Pilih Studio</label>
    <select name="studio_id" required>
        @foreach($studios as $studio)
            <option value="{{ $studio->id }}">{{ $studio->name }}</option>
        @endforeach
    </select>

    <label>Kode Kursi</label>
    <input type="text" name="seat_code" placeholder="Contoh: A1, B5" required>

    <label>Tipe Kursi</label>
    <select name="type" required>
        <option value="regular">Regular</option>
        <option value="vip">VIP</option>
        <option value="sweetbox">Sweetbox</option>
    </select>

    <button class="btn-submit">Simpan</button>
</form>

@endsection
