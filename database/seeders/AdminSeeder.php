<?php

namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@zenithtix.com',
            'password' => bcrypt('admin123'),
            'is_admin' => 1,
        ]);
    }
}
