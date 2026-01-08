@extends('admin.layouts.app')

@section('content')
<div class="main-content-wrapper">
<div class="container-fluid">
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('admin.orders.index') }}" class="btn-back-circle me-3">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h2 class="admin-title m-0">Edit Detail Pemesanan</h2>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-glass p-4 mb-4">
                <h5 class="text-warning fw-bold mb-4 border-bottom border-secondary pb-2">DATA TRANSAKSI</h5>
                
                <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label>Customer</label>
                        <input type="text" class="form-control custom-input" value="{{ $order->user->name ?? 'User Terhapus' }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label>Film</label>
                        <input type="text" class="form-control custom-input" value="{{ $order->schedule->movie->title ?? 'N/A' }}" readonly>
                    </div>

                    <div class="mb-4">
                        <label>Status Pembayaran</label>
                        <select name="status" class="form-select custom-input">
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>PENDING</option>
                            <option value="paid" {{ $order->status == 'paid' ? 'selected' : '' }}>PAID</option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>CANCELLED</option>
                        </select>
                    </div>

                    <button type="submit" class="btn-submit w-100">SIMPAN PERUBAHAN</button>
                    <a href="{{ route('admin.orders.index') }}" class="btn-cancel w-100 d-block text-center mt-2">BATAL</a>
                </div>
            </div>

            <div class="col-md-8">
                <div class="form-glass p-4">
                    <h5 class="text-warning fw-bold mb-3 border-bottom border-secondary pb-2">PENGATURAN KURSI</h5>
                    <p class="text-secondary small mb-4 italic">*Centang kursi yang ingin ditambahkan atau hapus centang untuk membatalkan.</p>
                    
                    <div class="seat-grid-container">
                        @foreach($seats as $seat)
                            <label class="seat-item-edit">
                                <input type="checkbox" name="seats[]" value="{{ $seat->id }}" 
                                    {{ $order->seats->contains($seat->id) ? 'checked' : '' }}>
                                <div class="seat-custom-box">
                                    {{ $seat->code }}
                                </div>
                            </label>
                        @endforeach
                    </div>
                </form> </div>
        </div>
    </div>
</div>

<style>
    /* Info Styles */
    .custom-input { 
        background: rgba(0,0,0,0.3) !important; 
        border: 1px solid rgba(255,255,255,0.1) !important; 
        color: white !important; 
        padding: 12px; 
        border-radius: 12px; 
    }
    
    /* Seat Grid Layout */
    .seat-grid-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(60px, 1fr));
        gap: 10px;
        max-height: 400px;
        overflow-y: auto;
        padding-right: 10px;
    }

    /* Custom Checkbox Seat */
    .seat-item-edit { cursor: pointer; position: relative; }
    .seat-item-edit input { position: absolute; opacity: 0; }
    
    .seat-custom-box {
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.1);
        color: #888;
        padding: 10px 5px;
        text-align: center;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
        transition: 0.3s;
    }

    .seat-item-edit input:checked + .seat-custom-box {
        background: #2ecc71;
        color: #000;
        border-color: #fff;
        box-shadow: 0 0 15px rgba(46, 204, 113, 0.4);
    }

    .seat-item-edit:hover .seat-custom-box {
        border-color: #ffd43b;
        color: #fff;
    }

    /* Scrollbar untuk Grid Kursi */
    .seat-grid-container::-webkit-scrollbar { width: 5px; }
    .seat-grid-container::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 10px; }

    .btn-submit { 
        background: linear-gradient(90deg, #ffd43b, #d4af37); 
        border: none; color: black; padding: 12px; 
        border-radius: 12px; font-weight: 800; transition: 0.3s; 
    }
    .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(212, 175, 55, 0.3); }
    
    .btn-cancel { 
        background: rgba(255,255,255,0.05); color: #888; 
        padding: 10px; border-radius: 12px; text-decoration: none; 
        font-size: 14px; font-weight: 600; 
    }
</style>
@endsection