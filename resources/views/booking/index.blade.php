@extends('layouts.app')

@section('content')
<style>
    /* ISOLASI AREA BOOKING AGAR TIDAK TERTABRAK CSS GLOBAL */
    #booking-page-clean {
        background-color: #0b0c10 !important;
        color: white !important;
        /* padding-top: 100px; */
        padding-bottom: 150px;
        /* min-height: 100vh; */
        font-family: 'Poppins', sans-serif;
    }

    #booking-page-clean .screen-glow {
        width: 60%;
        height: 8px;
        background: #58a6ff;
        margin: 0 auto 50px;
        border-radius: 50% / 100% 100% 0 0;
        box-shadow: 0 -10px 30px rgba(88, 166, 255, 0.7);
    }

    /* PAKSA MENDATAR (HORIZONTAL) */
    #booking-page-clean .seat-row {
        display: flex !important;
        flex-direction: row !important;
        align-items: center !important;
        justify-content: center !important;
        margin-bottom: 15px !important;
        gap: 0 !important;
    }

    #booking-page-clean .seat-block {
        display: flex !important;
        flex-direction: row !important;
        gap: 8px !important;
    }

    /* KURSINYA */
    #booking-page-clean .seat-box { 
        width: 32px !important; 
        height: 32px !important; 
        background: #1a1c23 !important; 
        border: 1px solid #30363d !important; 
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        border-radius: 4px !important;
        cursor: pointer !important;
        color: #8b949e !important; 
        font-size: 10px !important;
        font-weight: bold !important;
        transition: 0.2s !important;
    }

    /* SEMBUNYIKAN CHECKBOX ASLI */
    #booking-page-clean .seat-checkbox {
        position: absolute !important;
        opacity: 0 !important;
        pointer-events: none !important;
    }

    /* WARNA STATUS KURSI */
    #booking-page-clean .seat-checkbox:checked + .seat-box { 
        background: #2ea043 !important; /* Hijau Terpilih */
        color: white !important; 
        border-color: #3fb950 !important;
    }

    #booking-page-clean .seat-box.taken { 
        background: #da3633 !important; /* Merah Terisi */
        color: white !important; 
        cursor: not-allowed !important;
        border: none !important;
        opacity: 0.8;
    }

    /* AISLE & LABEL */
    #booking-page-clean .aisle-gap { 
        width: 60px !important; 
        text-align: center !important;
        font-weight: 800 !important;
        color: #30363d !important;
        font-size: 12px;
    }

    #booking-page-clean .row-label {
        width: 40px !important;
        color: #58a6ff !important;
        font-weight: bold !important;
        font-size: 14px;
    }

    /* BAR INFO DI BAWAH */
    .fixed-summary {
        /* position: fixed; */
        bottom: 0; left: 0; right: 0;
        background: #0d1117;
        border-top: 1px solid #30363d;
        padding: 20px 0;
        z-index: 1001;
    }
</style>

<div id="booking-page-clean">
    <div class="container text-center">
        <h3 class="text-warning fw-bold m-0">{{ $selectedSchedule->movie->title }}</h3>
        <p class="text-secondary small mb-5">{{ $selectedSchedule->studio->name }} — {{ date('H:i', strtotime($selectedSchedule->time)) }}</p>

        <div class="screen-glow"></div>
        <p class="text-secondary small" style="letter-spacing: 10px; margin-bottom: 40px;">L A Y A R</p>

        <div class="d-inline-block p-4" style="background: rgba(255,255,255,0.02); border-radius: 20px;">
            @php
                $rowLabels = ['A', 'B', 'C', 'D', 'E']; // 5 Baris ke belakang
            @endphp

            @foreach($rowLabels as $row)
            <div class="seat-row">
                <div class="row-label text-start">{{ $row }}</div>

                <div class="seat-block">
                    @for($i=1; $i <= 10; $i++)
                        @php $id = $row.$i; $isTaken = in_array($id, $takenSeats ?? []); @endphp
                        <label class="m-0">
                            <input type="checkbox" name="seats[]" form="formBooking" value="{{$id}}" class="seat-checkbox" {{$isTaken ? 'disabled' : ''}}>
                            <div class="seat-box {{$isTaken ? 'taken' : ''}}">{{$i}}</div>
                        </label>
                    @endfor
                </div>

                <div class="aisle-gap">{{ $row }}</div>

                <div class="seat-block">
                    @for($i = 11; $i <= 20; $i++)
                        @php $id = $row.$i; $isTaken = in_array($id, $takenSeats ?? []); @endphp
                        <label class="m-0">
                            <input type="checkbox" name="seats[]" form="formBooking" value="{{$id}}" class="seat-checkbox" {{$isTaken ? 'disabled' : ''}}>
                            <div class="seat-box {{$isTaken ? 'taken' : ''}}">{{$i}}</div>
                        </label>
                    @endfor
                </div>

                <div class="row-label text-end">{{ $row }}</div>
            </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center gap-4 mt-5 mb-5 text-secondary small">
            <div class="d-flex align-items-center gap-2"><div style="width:15px; height:15px; background:#1a1c23; border:1px solid #30363d; border-radius:3px;"></div> Tersedia</div>
            <div class="d-flex align-items-center gap-2"><div style="width:15px; height:15px; background:#2ea043; border-radius:3px;"></div> Terpilih</div>
            <div class="d-flex align-items-center gap-2"><div style="width:15px; height:15px; background:#da3633; border-radius:3px;"></div> Terisi</div>
        </div>
    </div>
</div>

<div class="fixed-summary">
    <div class="container d-flex justify-content-between align-items-center">
        <div class="text-start">
            <span class="text-secondary small d-block">Kursi yang dipilih:</span>
            <h5 class="m-0 fw-bold text-white" id="selected-seats-text">-</h5>
        </div>
        <div class="d-flex align-items-center gap-4">
            <div class="text-end me-3">
                <span class="text-secondary small d-block">Total Bayar:</span>
                <h4 class="m-0 fw-bold text-warning" id="total-price-text">Rp 0</h4>
            </div>
            <form action="{{ route('booking.store') }}" method="POST" id="formBooking">
                @csrf
                <input type="hidden" name="schedule_id" value="{{ $selectedSchedule->id }}">
                <button type="submit" id="confirm-btn" class="btn btn-success px-5 py-2 fw-bold" style="background: #2ea043; border: none; border-radius: 10px;" disabled>
                    KONFIRMASI
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    const seats = document.querySelectorAll('.seat-checkbox');
    const seatText = document.getElementById('selected-seats-text');
    const priceText = document.getElementById('total-price-text');
    const btn = document.getElementById('confirm-btn');
    const pricePerSeat = {{ $selectedSchedule->price }};

    seats.forEach(s => {
        s.addEventListener('change', () => {
            const selected = Array.from(seats).filter(c => c.checked).map(c => c.value);
            seatText.innerText = selected.length > 0 ? selected.join(', ') : '-';
            priceText.innerText = 'Rp ' + (selected.length * pricePerSeat).toLocaleString('id-ID');
            btn.disabled = selected.length === 0;
        });
    });
</script>
@endsection