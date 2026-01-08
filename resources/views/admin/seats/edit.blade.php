@extends('admin.layouts.app')

@section('title', 'Seat Editor')

@section('content')

<h2 class="admin-title">Editor Kursi: {{ $studio->name }}</h2>

<style>
    .seat-grid {
        display: grid;
        grid-template-columns: repeat({{ $studio->columns }}, 40px);
        gap: 8px;
        padding: 20px;
        background: rgba(255,255,255,0.05);
        border-radius: 15px;
        width: fit-content;
    }

    .seat {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        cursor: pointer;
        display:flex;
        justify-content:center;
        align-items:center;
        font-size:12px;
        user-select:none;
    }

    .available { background:#3498db; }
    .broken { background:#7f8c8d; }
    .disabled { background:#555; }
    .premium { background:#f1c40f; color:black; }

    .aisle { background: transparent !important; cursor: default; }
</style>

<form action="{{ route('admin.seats.editor.save', $studio->id) }}" method="POST">
    @csrf

    <div class="seat-grid">
        @foreach($grid as $row => $cols)
            @foreach($cols as $col => $status)

                @if($status === 'aisle')
                    <div class="seat aisle"></div>
                @else
                    <div class="seat {{ $status }}"
                        data-code="{{ $row.$col }}"
                        data-status="{{ $status }}">
                        {{ $row.$col }}
                    </div>

                    <input type="hidden" name="seats[{{ $row.$col }}]"
                           value="{{ $status }}">
                @endif

            @endforeach
        @endforeach
    </div>

    <button class="btn-add" style="margin-top:20px;">
        Simpan Layout Kursi
    </button>

</form>

<script>
    document.querySelectorAll('.seat').forEach(seat => {
        seat.addEventListener('click', function() {

            if (this.classList.contains('aisle')) return;

            let next = {
                'available': 'premium',
                'premium': 'broken',
                'broken': 'disabled',
                'disabled': 'available'
            };

            let current = this.dataset.status;
            let newStatus = next[current];

            this.dataset.status = newStatus;

            this.className = 'seat ' + newStatus;

            document.querySelector('input[name="seats['+this.dataset.code+']"]')
                .value = newStatus;
        });
    });
</script>

@endsection
