@extends('admin.layouts.app')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="admin-title mb-1">Kelola Kursi</h2>
            <p class="text-secondary small">Daftar kursi di setiap studio</p>
        </div>
        <a href="{{ route('admin.seats.create') }}" class="btn-add">
            <i class="fas fa-plus me-2"></i> Tambah Kursi
        </a>
    </div>

    <div class="table-responsive form-glass">
        <table class="table align-middle m-0">
            <thead>
                <tr>
                    <th class="ps-4">Studio</th>
                    <th class="text-center">Kode Kursi</th>
                    <th class="text-center">Tipe</th>
                    <th class="text-center pe-4" style="width: 150px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($seats as $seat)
                <tr>
                    <td class="ps-4">
                        <div class="fw-bold text-white">{{ $seat->studio->name }}</div>
                    </td>
                    <td class="text-center">
                        <span class="badge-seat">{{ $seat->seat_code }}</span>
                    </td>
                    <td class="text-center">
                        <span class="status-badge {{ strtolower($seat->type) }}">
                            {{ strtoupper($seat->type) }}
                        </span>
                    </td>
                    <td class="text-center pe-4">
                        <div class="d-flex justify-content-center gap-2">
                            <a href="{{ route('admin.seats.edit', $seat->id) }}" class="btn-action-edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.seats.destroy', $seat->id) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-action-delete" onclick="return confirm('Hapus kursi?')">
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
    /* Styling agar sama persis dengan yang kamu suka */
    .badge-seat { background: rgba(52, 152, 219, 0.1); color: #3498db; padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 700; border: 1px solid rgba(52, 152, 219, 0.2); }
    .status-badge { padding: 5px 12px; border-radius: 20px; font-size: 10px; font-weight: 800; }
    .status-badge.regular { background: #2ecc71; color: #000; }
    .status-badge.vip { background: #f1c40f; color: #000; }
    .status-badge.sweetbox { background: #e74c3c; color: #fff; }
    
    .btn-action-edit { background: rgba(58, 138, 247, 0.1); color: #3a8af7; width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; text-decoration: none; transition: 0.3s; }
    .btn-action-edit:hover { background: #3a8af7; color: white; }
    .btn-action-delete { background: rgba(231, 76, 60, 0.1); color: #e74c3c; width: 32px; height: 32px; border-radius: 8px; border: none; transition: 0.3s; }
    .btn-action-delete:hover { background: #e74c3c; color: white; }
</style>
@endsection