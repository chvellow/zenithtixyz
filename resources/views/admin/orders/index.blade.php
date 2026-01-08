@extends('admin.layouts.app')

@section('content')
<div class="main-content-wrapper">
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="admin-title mb-1">Kelola Pemesanan</h2>
            <p class="text-secondary small">Pantau seluruh transaksi tiket ZenithTix</p>
        </div>
        <a href="{{ route('admin.orders.create') }}" class="btn-add">
            <i class="fas fa-plus me-2"></i> Tambah Pemesanan
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 bg-success bg-opacity-10 text-success small mb-4">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        </div>
    @endif

    <div class="row mb-4">
        <div class="col-md-5">
            <form action="{{ route('admin.orders.index') }}" method="GET">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" name="search" placeholder="Cari customer, film..." value="{{ request('search') }}">
                    <button type="submit">Cari</button>
                </div>
            </form>
        </div>
    </div>

    <div class="table-responsive form-glass">
        <table class="table align-middle m-0">
            <thead>
                <tr>
                    <th class="ps-4">No</th>
                    <th>Customer</th>
                    <th>Film & Studio</th>
                    <th>Jadwal</th>
                    <th class="text-center">Kursi</th>
                    <th class="text-end">Total</th>
                    <th class="text-center">Status</th>
                    <th class="text-center pe-4" style="width: 120px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $index => $order)
                <tr>
                    <td class="ps-4 text-secondary small">{{ $orders->firstItem() + $index }}</td>
                    <td>
                        <div class="fw-bold text-white">{{ $order->user->name ?? 'User Terhapus' }}</div>
                        <div class="text-secondary" style="font-size: 11px;">{{ $order->user->email ?? '-' }}</div>
                    </td>
                    <td>
                        <div class="text-white fw-bold small">{{ $order->schedule->movie->title ?? 'N/A' }}</div>
                        <div class="text-warning" style="font-size: 10px; font-weight: 700;">{{ $order->schedule->studio->name ?? 'Studio N/A' }}</div>
                    </td>
                    <td>
                        <div class="text-white small">{{ $order->schedule ? \Carbon\Carbon::parse($order->schedule->date)->format('d M Y') : '-' }}</div>
                        <div class="text-secondary extra-small">{{ $order->schedule->time ?? '--:--' }} WITA</div>
                    </td>
                    <td class="text-center">
                        <span class="badge-seat">{{ $order->seats }}</span>
                    </td>
                    <td class="text-end">
                        <div class="fw-bold text-success">Rp{{ number_format($order->total_price ?? 0, 0, ',', '.') }}</div>
                    </td>
                    <td class="text-center">
                        <span class="status-badge {{ $order->status }}">
                            {{ strtoupper($order->status) }}
                        </span>
                    </td>
                    <td class="text-center pe-4">
                        <div class="d-flex justify-content-center gap-2">
                            {{-- TOMBOL EDIT --}}
                            <a href="{{ route('admin.orders.edit', $order->id) }}" class="btn-action-edit">
                                <i class="fas fa-edit"></i>
                            </a>

                            {{-- TOMBOL DELETE --}}
                            <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" onsubmit="return confirm('Hapus data pemesanan ini?')">
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
                    <td colspan="8" class="text-center py-5 text-secondary">Belum ada data pemesanan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4 custom-pagination">
        {{ $orders->appends(['search' => request('search')])->links() }}
    </div>
</div>

<style>
    .search-box { position: relative; display: flex; align-items: center; }
    .search-box i { position: absolute; left: 15px; color: #888; }
    .search-box input { 
        width: 100%; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); 
        padding: 10px 10px 10px 40px; border-radius: 12px; color: white;
    }
    .search-box button { 
        position: absolute; right: 5px; background: #ffd43b; border: none; 
        padding: 6px 15px; border-radius: 8px; font-weight: 700; font-size: 12px;
    }
    .badge-seat { background: rgba(52, 152, 219, 0.1); color: #3498db; padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 700; border: 1px solid rgba(52, 152, 219, 0.2); }
    .status-badge { padding: 5px 12px; border-radius: 20px; font-size: 10px; font-weight: 800; }
    .status-badge.paid { background: #2ecc71; color: #000; }
    .status-badge.pending { background: #f1c40f; color: #000; }
    .status-badge.cancelled { background: #e74c3c; color: #fff; }

    /* ACTION BUTTONS STYLE */
    .btn-action-edit, .btn-action-delete { 
        width: 32px; height: 32px; border-radius: 8px; transition: 0.3s; 
        display: flex; align-items: center; justify-content: center; border: none; text-decoration: none;
    }
    .btn-action-edit { background: rgba(58, 138, 247, 0.1); color: #3a8af7; }
    .btn-action-edit:hover { background: #3a8af7; color: white; transform: translateY(-2px); }
    
    .btn-action-delete { background: rgba(231, 76, 60, 0.1); color: #e74c3c; }
    .btn-action-delete:hover { background: #e74c3c; color: white; transform: translateY(-2px); }

    .extra-small { font-size: 10px; text-transform: uppercase; }
    
    /* Pagination Fix */
    .custom-pagination nav { display: flex; justify-content: flex-end; }
    .pagination { gap: 5px; }
    .page-item .page-link { background: #1a1a1a; border: 1px solid #333; color: white; border-radius: 8px !important; }
    .page-item.active .page-link { background: #ffd43b; border-color: #ffd43b; color: #000; }
</style>
@endsection