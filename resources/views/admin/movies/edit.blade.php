@extends('admin.layouts.app')

@section('content')
<div class="main-content-wrapper">
<div class="container-fluid">
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('admin.movies.index') }}" class="btn-back-circle me-3"><i class="fas fa-arrow-left"></i></a>
        <h2 class="admin-title m-0">Edit Film: {{ $movie->title }}</h2>
    </div>

    <form action="{{ route('admin.movies.update', $movie->id) }}" method="POST" enctype="multipart/form-data" class="form-glass p-4">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Judul</label>
                <input type="text" name="title" value="{{ $movie->title }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Genre</label>
                <input type="text" name="genre" value="{{ $movie->genre }}" required>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Durasi (menit)</label>
                <input type="number" name="duration" value="{{ $movie->duration }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Rating</label>
                <input type="number" step="0.1" name="rating" value="{{ $movie->rating }}" required>
            </div>
        </div>

        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="description" rows="5" required>{{ $movie->description }}</textarea>
        </div>

        <div class="row mb-4">
            <div class="col-md-4">
                <label>Poster Saat Ini</label>
                <img src="{{ asset('storage/' . $movie->poster) }}" class="img-fluid rounded border border-secondary shadow">
            </div>
            <div class="col-md-8">
                <label>Ganti Poster (Opsional)</label>
                <div class="upload-box">
                    <input type="file" name="poster" accept="image/*">
                </div>
            </div>
        </div>

        <button class="btn-submit">UPDATE PERUBAHAN</button>
    </form>
</div>
@endsection