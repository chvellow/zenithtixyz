<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Movie;

class MovieSeeder extends Seeder
{
    public function run(): void
    {
        Movie::create([
            'title' => 'The Zenith Awakens',
            'genre' => 'Sci-Fi',
            'duration' => 132,
            'description' => 'Sebuah kisah epik tentang perang antar galaksi...',
            'poster' => 'posters/zenith.jpg'
        ]);

        Movie::create([
            'title' => 'Midnight Horror',
            'genre' => 'Horror',
            'duration' => 98,
            'description' => 'Film horror dengan nuansa thriller intens...',
            'poster' => 'posters/horror.jpg'
        ]);

        Movie::create([
            'title' => 'Dreams in Yellow',
            'genre' => 'Romance',
            'duration' => 120,
            'description' => 'Drama romantis yang lembut dan penuh makna...',
            'poster' => 'posters/dreams.jpg'
        ]);
    }
}
