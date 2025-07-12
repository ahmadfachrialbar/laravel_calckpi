<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class Adminseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
        'nip' => '1234567890', 
        'name' => 'Admin',
        'email' => 'admin@gmail.com',
        'password' => Hash::make('password'), // Gunakan Hash untuk password 
        'job_position_id' => 9, 
        'role' => 'admin',
        'join_date' => now(), 
    ])->assignRole('admin'); // Assign role admin ke user ini

        // Jika ingin menambahkan lebih banyak admin, bisa ditambahkan di sini
        
    }
}
