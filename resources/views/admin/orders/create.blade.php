@extends('admin.layouts.app')

@section('content')
<div class="main-content-wrapper">
    <div class="container-fluid p-0">
        <h2 style="color: #ffd43b; font-weight: 800; margin-bottom: 25px;">Tambah Pemesanan Baru</h2>

        <form action="{{ route('admin.orders.store') }}" method="POST" id="orderForm">
            @csrf
            <div class="glass-card p-4 mb-4">
                {{-- Pilih Jadwal --}}
                <div class="mb-4">
                    <label class="text-secondary small fw-bold mb-2 d-block">Pilih Jadwal & Studio</label>
                    <select name="schedule_id" id="schedule_select" class="form-control-custom" required>
                        <option value="" disabled selected>-- Pilih Jadwal Film --</option>
                        @foreach($schedules as $schedule)
                            <option value="{{ $schedule->id }}" data-price="{{ $schedule->price }}">
                                {{ $schedule->movie->title }} | {{ $schedule->studio->name }} | {{ $schedule->time }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Input Kursi (Hidden Array untuk Backend) --}}
                <div id="seats_input_container"></div>

                {{-- Kursi Terpilih (Display Saja) --}}
                <div class="mb-4">
                    <label class="text-secondary small fw-bold mb-2 d-block">Kursi Terpilih</label>
                    <input type="text" id="display_selected_seats" class="form-control-custom" readonly placeholder="Klik pada kursi di bawah..." required>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <label class="text-secondary small fw-bold mb-2 d-block">Total Bayar</label>
                        <div class="price-display">Rp <span id="total_price_display" style="color: #2ecc71;">0</span></div>
                    </div>
                    <div class="col-md-6">
                        <label class="text-secondary small fw-bold mb-2 d-block">Status</label>
                        <select name="status" class="form-control-custom">
                            <option value="paid">PAID (Lunas)</option>
                            <option value="pending">PENDING</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- AREA DENAH KURSI (Sesuai Foto 1 & 2) --}}
            <div class="glass-card p-5" style="background: #0f0f0f;">
                <div class="screen-container mb-5">
                    <div class="screen-glow"></div>
                    <div class="screen-text">L A Y A R</div>
                </div>

                <div id="seat_container" class="seat-layout-wrapper">
                    {{-- Kursi muncul di sini --}}
                </div>

                <div class="d-flex justify-content-center gap-4 mt-5 pt-4 border-top border-secondary border-opacity-10">
                    <div class="legend-item"><div class="seat-ref available"></div><span>Tersedia</span></div>
                    <div class="legend-item"><div class="seat-ref selected"></div><span>Pilihan</span></div>
                    <div class="legend-item"><div class="seat-ref occupied"></div><span>Terisi</span></div>
                </div>
            </div>

            <button type="submit" class="btn-submit-order mt-4 w-100">SIMPAN PEMESANAN</button>
        </form>
    </div>
</div>

<style>
    .form-control-custom {
        background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);
        border-radius: 12px; color: white; padding: 12px; width: 100%; outline: none;
    }
    .price-display { font-size: 24px; font-weight: 800; }

    /* Screen Modern */
    .screen-container { position: relative; text-align: center; }
    .screen-glow { height: 6px; width: 70%; background: #3498db; margin: 0 auto; border-radius: 50%; filter: blur(10px); }
    .screen-text { color: #3498db; font-size: 11px; font-weight: 900; letter-spacing: 15px; margin-top: 10px; opacity: 0.5; }

    /* Grid Kursi (20 Kolom) */
    .seat-layout-wrapper {
        display: grid; grid-template-columns: repeat(20, 1fr); gap: 8px; 
        max-width: 900px; margin: 0 auto;
    }
    .seat { 
        aspect-ratio: 1; background: #222; border-radius: 4px; border: 1px solid #333;
        cursor: pointer; transition: 0.2s; display: flex; align-items: center; justify-content: center; font-size: 9px; color: #555;
    }
    .seat:nth-child(20n+10) { margin-right: 25px; } /* Jarak lorong tengah */
    
    .seat:hover:not(.occupied) { border-color: #ffd43b; color: #fff; }
    .seat.selected { background: #ffd43b !important; color: #000 !important; border-color: #ffd43b; font-weight: bold; }
    .seat.occupied { background: #e74c3c !important; color: #fff !important; cursor: not-allowed; border: none; opacity: 0.6; }

    .legend-item { display: flex; align-items: center; gap: 8px; font-size: 12px; color: #888; }
    .seat-ref { width: 16px; height: 16px; border-radius: 3px; }
    .seat-ref.available { background: #222; border: 1px solid #333; }
    .seat-ref.selected { background: #ffd43b; }
    .seat-ref.occupied { background: #e74c3c; }

    .btn-submit-order {
        background: #ffd43b; color: #000; padding: 18px; border-radius: 12px;
        font-weight: 800; border: none; transition: 0.3s;
    }
</style>

<script>
    // Ambil data occupiedData dari PHP ke JavaScript
    const occupiedData = @json($occupiedData);

    document.getElementById('schedule_select').addEventListener('change', function() {
        const scheduleId = this.value;
        const pricePerSeat = this.options[this.selectedIndex].getAttribute('data-price');
        const container = document.getElementById('seat_container');
        
        // Ambil string kursi terisi untuk jadwal ini
        const occupiedString = occupiedData[scheduleId] || '';
        const occupiedArray = occupiedString.split(',');

        // Reset display
        container.innerHTML = '';
        document.getElementById('display_selected_seats').value = '';
        document.getElementById('total_price_display').innerText = '0';
        document.getElementById('seats_input_container').innerHTML = '';

        // Generate 5 Baris (A-E), tiap baris 20 Kursi
        const rows = ['A', 'B', 'C', 'D', 'E'];
        rows.forEach(row => {
            for (let i = 1; i <= 20; i++) {
                const seatId = row + i;
                const seatDiv = document.createElement('div');
                seatDiv.classList.add('seat');
                seatDiv.innerText = i;
                
                // Cek apakah terisi
                if (occupiedArray.includes(seatId)) {
                    seatDiv.classList.add('occupied');
                } else {
                    seatDiv.addEventListener('click', function() {
                        this.classList.toggle('selected');
                        updateSelection(pricePerSeat);
                    });
                }
                container.appendChild(seatDiv);
            }
        });
    });

    function updateSelection(price) {
        const container = document.getElementById('seat_container');
        const selectedSeats = [];
        const rows = ['A', 'B', 'C', 'D', 'E'];
        const inputContainer = document.getElementById('seats_input_container');
        
        inputContainer.innerHTML = ''; // Reset hidden inputs

        const allSeats = container.querySelectorAll('.seat');
        allSeats.forEach((seat, index) => {
            if (seat.classList.contains('selected')) {
                const rowIndex = Math.floor(index / 20);
                const seatNum = (index % 20) + 1;
                const seatId = rows[rowIndex] + seatNum;
                
                selectedSeats.push(seatId);
                
                // Tambahkan hidden input agar dikirim sebagai array ke controller
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'seats[]';
                input.value = seatId;
                inputContainer.appendChild(input);
            }
        });

        document.getElementById('display_selected_seats').value = selectedSeats.join(', ');
        const total = selectedSeats.length * price;
        document.getElementById('total_price_display').innerText = total.toLocaleString('id-ID');
    }
</script>
@endsection