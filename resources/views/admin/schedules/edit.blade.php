@extends('admin.layouts.app')

@section('content')
<div class="main-content-wrapper">
<div class="container-fluid">
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('admin.schedules.index') }}" class="btn-back-circle me-3"><i class="fas fa-arrow-left"></i></a>
        <h2 class="admin-title m-0">Edit Jadwal Tayang</h2>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <form action="{{ route('admin.schedules.update', $schedule->id) }}" method="POST" class="form-glass p-4">
                @csrf @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="small text-secondary mb-2">Film</label>
                        <select name="movie_id" class="form-select custom-input" required>
                            @foreach($movies as $movie)
                                <option value="{{ $movie->id }}" {{ $schedule->movie_id == $movie->id ? 'selected' : '' }}>{{ $movie->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="small text-secondary mb-2">Studio</label>
                        <select name="studio_id" class="form-select custom-input" required>
                            @foreach($studios as $studio)
                                <option value="{{ $studio->id }}" {{ $schedule->studio_id == $studio->id ? 'selected' : '' }}>{{ $studio->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="small text-secondary mb-2">Tanggal</label>
                        <input type="date" name="date" value="{{ $schedule->date }}" class="form-control custom-input" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="small text-secondary mb-2">Jam Tayang</label>
                        <input type="time" name="time" value="{{ $schedule->time }}" class="form-control custom-input" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="small text-secondary mb-2">Harga Tiket</label>
                    <input type="number" name="price" value="{{ $schedule->price }}" class="form-control custom-input text-warning fw-bold" required>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn-submit flex-grow-1">UPDATE JADWAL</button>
                    <a href="{{ route('admin.schedules.index') }}" class="btn btn-secondary py-3 px-4 border-0" style="border-radius: 12px; background: rgba(255,255,255,0.05);">BATAL</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection