@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="container">
    <div class="p-5 mb-4 bg-white rounded-3 shadow-sm">
        <div class="container-fluid py-5">
            <h1 class="display-5 fw-bold">Selamat Datang di ZenithTixYZ</h1>
            <p class="col-md-8 fs-5">Tempat pesan tiket film favoritmu dengan cepat dan nyaman.</p>
            <a href="{{ route('movies.index') }}" class="btn btn-primary btn-lg">Lihat Film</a>
        </div>
    </div>
</div>
@endsection
