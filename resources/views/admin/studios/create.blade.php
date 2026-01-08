@extends('admin.layouts.app')

@section('content')
<div class="main-content-wrapper">
<div class="container-fluid">
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('admin.studios.index') }}" class="btn-back-circle me-3"><i class="fas fa-arrow-left"></i></a>
        <h2 class="admin-title m-0">Tambah Studio Baru</h2>
    </div>

    <div class="row">
        <div class="col-md-7">
            <form action="{{ route('admin.studios.store') }}" method="POST" class="form-glass p-4">
                @csrf
                <div class="mb-4">
                    <label class="small text-secondary mb-2 text-uppercase fw-bold">Nama Studio</label>
                    <input type="text" name="name" class="form-control custom-input" placeholder="Contoh: Teater 1" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label class="small text-secondary mb-2 text-uppercase fw-bold">Kapasitas Kursi</label>
                        <input type="number" name="capacity" class="form-control custom-input" placeholder="Contoh: 100" required>
                    </div>
                    <div class="col-md-6 mb-4">
                        <label class="small text-secondary mb-2 text-uppercase fw-bold">Tipe Studio</label>
                        <select name="type" class="form-select custom-input" required>
                            <option value="Reguler">Reguler</option>
                            <option value="VIP">VIP</option>
                            <option value="Premiere">Premiere</option>
                            <option value="IMAX">IMAX</option>
                        </select>
                    </div>
                </div>

                <div class="d-grid mt-2">
                    <button type="submit" class="btn-submit py-3">
                        <i class="fas fa-save me-2"></i> SIMPAN STUDIO
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .custom-input { background: rgba(0,0,0,0.3) !important; border: 1px solid rgba(255,255,255,0.1) !important; color: white !important; border-radius: 12px; padding: 12px; height: 50px; }
    .custom-input:focus { border-color: #ffd43b !important; box-shadow: none; }
    .form-select { background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23ffffff' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e"); }
</style>
@endsection