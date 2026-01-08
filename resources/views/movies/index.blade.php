@extends('layouts.app')

@section('title', 'Katalog Film - ZenithTix')

@section('content')
<div class="page-wrapper" style="margin-top: 100px; padding: 0 5%; margin-bottom: 50px;">
    
    <div class="filter-container" style="background: rgba(255, 255, 255, 0.05); backdrop-filter: blur(15px); border: 1px solid rgba(255, 255, 255, 0.1); padding: 10px 20px; border-radius: 50px; display: flex; gap: 15px; margin-bottom: 40px; width: fit-content; margin-left: auto; margin-right: auto;">
        <a href="{{ route('movies.index', ['status' => 'now']) }}" 
           style="padding: 8px 20px; border-radius: 40px; text-decoration: none; color: {{ $status == 'now' ? 'black' : 'white' }}; background: {{ $status == 'now' ? 'var(--gold)' : 'transparent' }}; font-weight: 600; transition: 0.3s;">Now Showing</a>
        <a href="{{ route('movies.index', ['status' => 'next']) }}" 
           style="padding: 8px 20px; border-radius: 40px; text-decoration: none; color: {{ $status == 'next' ? 'black' : 'white' }}; background: {{ $status == 'next' ? 'var(--gold)' : 'transparent' }}; font-weight: 600; transition: 0.3s;">Next Showing</a>
        <a href="{{ route('movies.index', ['status' => 'all']) }}" 
           style="padding: 8px 20px; border-radius: 40px; text-decoration: none; color: {{ $status == 'all' ? 'black' : 'white' }}; background: {{ $status == 'all' ? 'var(--gold)' : 'transparent' }}; font-weight: 600; transition: 0.3s;">All Movies</a>
    </div>

    <div class="grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 30px;">
        @forelse($movies as $movie)
            @php
                // Cari jadwal hari ini yang paling dekat
                $todaySchedules = $movie->schedules
                    ->where('date', date('Y-m-d'))
                    ->where('time', '>=', date('H:i:s'))
                    ->sortBy('time');
                
                $firstSchedule = $todaySchedules->first();
            @endphp

            <div class="movie-card" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08); border-radius: 24px; overflow: hidden; transition: 0.4s; display: flex; flex-direction: column;">
                
                <div style="position: relative; width: 100%; aspect-ratio: 2/3;">
                    <img src="{{ asset('storage/' . $movie->poster) }}" alt="{{ $movie->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                    
                    @if($firstSchedule)
                    <div style="position: absolute; top: 15px; left: 15px; display: flex; flex-direction: column; gap: 5px;">
                        
                        
                        <span style="background: var(--gold); color: black; padding: 4px 10px; border-radius: 6px; font-size: 0.65rem; font-weight: 800; text-transform: uppercase;">
    {{ $movie->schedules->first()->studio_relation->type ?? 'Reguler' }}
</span>
                    </div>
                    @endif
                </div>

                <div style="padding: 20px; flex-grow: 1; display: flex; flex-direction: column;">
                    <h3 style="color: white; margin: 0; font-size: 1.2rem;">{{ $movie->title }}</h3>
                    <p style="color: #4ade80; font-weight: bold; margin-top: 8px;">
                        Rp {{ number_format($firstSchedule->price ?? 0, 0, ',', '.') }}
                    </p>

                    <div style="margin-top: auto; margin-bottom: 20px;">
                        <p style="color: var(--gold); font-size: 0.7rem; margin-bottom: 8px; text-transform: uppercase;">Sisa Jam Tayang:</p>
                        <div style="display: flex; gap: 6px; flex-wrap: wrap;">
                            @forelse($todaySchedules->take(3) as $sch)
                                <span style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: white; padding: 4px 10px; border-radius: 8px; font-size: 0.75rem;">
                                    {{ date('H:i', strtotime($sch->time)) }}
                                </span>
                            @empty
                                <span style="color: #666; font-size: 0.75rem;">Jadwal Habis</span>
                            @endforelse
                        </div>
                    </div>

                    <a href="{{ route('movies.show', $movie->id) }}" style="background: linear-gradient(135deg, var(--gold), #b9982f); color: black; text-decoration: none; padding: 12px; border-radius: 12px; font-weight: bold; font-size: 0.9rem; text-align: center;">
                        Pesan Tiket
                    </a>
                </div>
            </div>
        @empty
            <p style="color: white; grid-column: 1/-1; text-align: center;">Film tidak ditemukan.</p>
        @endforelse
    </div>
</div>
@endsection