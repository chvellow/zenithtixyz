@extends('admin.layouts.app')

@section('content')
<div class="main-content-wrapper">
<div class="container-fluid">
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('admin.studios.index') }}" class="btn-back-circle me-3"><i class="fas fa-arrow-left"></i></a>
        <h2 class="admin-title m-0">Edit Studio</h2>
    </div>

    <div class="row">
        <div class="col-md-7">
            <form action="{{ route('admin.studios.update', $studio->id) }}" method="POST" class="form-glass p-4">
                @csrf @method('PUT')
                
                <div class="mb-4">
                    <label class="small text-secondary mb-2 text-uppercase fw-bold">Nama Studio</label>
                    <input type="text" name="name" value="{{ $studio->name }}" class="form-control custom-input" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label class="small text-secondary mb-2 text-uppercase fw-bold">Kapasitas Kursi</label>
                        <input type="number" name="capacity" value="{{ $studio->capacity }}" class="form-control custom-input" required>
                    </div>
                    <div class="col-md-6 mb-4">
                        <label class="small text-secondary mb-2 text-uppercase fw-bold">Tipe Studio</label>
                        <select name="type" class="form-select custom-input" required>
                            <option value="Reguler" {{ $studio->type == 'Reguler' ? 'selected' : '' }}>Reguler</option>
                            <option value="VIP" {{ $studio->type == 'VIP' ? 'selected' : '' }}>VIP</option>
                            <option value="Premiere" {{ $studio->type == 'Premiere' ? 'selected' : '' }}>Premiere</option>
                            <option value="IMAX" {{ $studio->type == 'IMAX' ? 'selected' : '' }}>IMAX</option>
                        </select>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn-submit flex-grow-1 py-3">UPDATE STUDIO</button>
                    <a href="{{ route('admin.studios.index') }}" class="btn btn-secondary border-0 px-4" style="border-radius: 12px; background: rgba(255,255,255,0.05); display: flex; align-items: center;">BATAL</a>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .custom-input { background: rgba(0,0,0,0.3) !important; border: 1px solid rgba(255,255,255,0.1) !important; color: white !important; border-radius: 12px; padding: 12px; height: 50px; }
    .custom-input:focus { border-color: #ffd43b !important; box-shadow: none; }
</style>
@endsection