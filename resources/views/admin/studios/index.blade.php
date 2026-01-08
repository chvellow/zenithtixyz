@extends('admin.layouts.app')

@section('content')
<div class="main-content-wrapper">
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="admin-title mb-1">Kelola Studio</h2>
            <p class="text-secondary small">Daftar teater dan kapasitas kursi ZenithTix</p>
        </div>
        <a href="{{ route('admin.studios.create') }}" class="btn-add">
            <i class="fas fa-plus me-2"></i> Tambah Studio
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 bg-success bg-opacity-10 text-success small mb-4">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        </div>
    @endif

    <div class="table-responsive form-glass">
        <table class="table align-middle m-0">
            <thead>
                <tr>
                    <th class="ps-4">Nama Studio</th>
                    <th>Kapasitas</th>
                    <th>Tipe</th>
                    <th class="text-center pe-4" style="width: 150px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($studios as $s)
                <tr>
                    <td class="ps-4">
                        <div class="fw-bold text-white">{{ $s->name }}</div>
                    </td>
                    <td>
                        <div class="text-white small"><span class="text-warning fw-bold">{{ $s->capacity }}</span> Kursi</div>
                    </td>
                    <td>
                        @php
                            $badgeStyle = match($s->type) {
                                'IMAX' => 'border-primary text-primary bg-primary',
                                'Premiere' => 'border-warning text-warning bg-warning',
                                'VIP' => 'border-info text-info bg-info',
                                default => 'border-secondary text-secondary bg-secondary'
                            };
                        @endphp
                        <span class="type-badge {{ $badgeStyle }}">
                            {{ strtoupper($s->type ?? 'REGULER') }}
                        </span>
                    </td>
                    <td class="text-center pe-4">
                        <div class="d-flex justify-content-center gap-2">
                            <a href="{{ route('admin.studios.edit', $s->id) }}" class="btn-action-edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.studios.destroy', $s->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus studio ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-action-delete">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-5 text-secondary small">Belum ada data studio.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<style>
    .type-badge { 
        font-size: 10px; font-weight: 800; padding: 4px 12px; border-radius: 20px; 
        background-color: rgba(255,255,255,0.05) !important; border: 1px solid;
    }
    .btn-action-edit, .btn-action-delete { 
        width: 34px; height: 34px; border-radius: 8px; display: flex; align-items: center; justify-content: center; border: none; transition: 0.3s; text-decoration: none;
    }
    .btn-action-edit { background: rgba(58, 138, 247, 0.1); color: #3a8af7; }
    .btn-action-edit:hover { background: #3a8af7; color: white; transform: translateY(-2px); }
    .btn-action-delete { background: rgba(231, 76, 60, 0.1); color: #e74c3c; }
    .btn-action-delete:hover { background: #e74c3c; color: white; transform: translateY(-2px); }
</style>
@endsection