@extends('admin.layouts.app')

@section('content')
<div class="main-content-wrapper">
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="admin-title mb-1">Kelola Jadwal Tayang</h2>
            <p class="text-secondary small">Atur waktu tayang film di setiap studio</p>
        </div>
        <a href="{{ route('admin.schedules.create') }}" class="btn-add">
            <i class="fas fa-plus me-2"></i> Tambah Jadwal
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
                    <th class="ps-4">Film</th>
                    <th>Studio</th>
                    <th>Tanggal</th>
                    <th>Jam</th>
                    <th class="text-end">Harga</th>
                    <th class="text-center pe-4" style="width: 150px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($schedules as $schedule)
                <tr>
                    <td class="ps-4">
                        <div class="fw-bold text-white">{{ $schedule->movie->title }}</div>
                    </td>
                    <td>
                        <span class="badge bg-secondary bg-opacity-25 text-warning border border-warning border-opacity-25 px-2 py-1" style="font-size: 11px;">
                            {{ $schedule->studio->name ?? $schedule->studio_id }}
                        </span>
                    </td>
                    <td><div class="text-white small">{{ \Carbon\Carbon::parse($schedule->date)->format('d M Y') }}</div></td>
                    <td><div class="text-info fw-bold small">{{ $schedule->time }} WITA</div></td>
                    <td class="text-end">
                        <div class="fw-bold text-success">Rp{{ number_format($schedule->price, 0, ',', '.') }}</div>
                    </td>
                    <td class="text-center pe-4">
                        <div class="d-flex justify-content-center gap-2">
                            <a href="{{ route('admin.schedules.edit', $schedule->id) }}" class="btn-action-edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.schedules.destroy', $schedule->id) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-action-delete" onclick="return confirm('Hapus jadwal ini?')">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<style>
    .btn-action-edit, .btn-action-delete { 
        width: 34px; height: 34px; border-radius: 8px; display: flex; align-items: center; justify-content: center; border: none; transition: 0.3s; text-decoration: none;
    }
    .btn-action-edit { background: rgba(58, 138, 247, 0.1); color: #3a8af7; }
    .btn-action-edit:hover { background: #3a8af7; color: white; transform: translateY(-2px); }
    .btn-action-delete { background: rgba(231, 76, 60, 0.1); color: #e74c3c; }
    .btn-action-delete:hover { background: #e74c3c; color: white; transform: translateY(-2px); }
</style>
@endsection