<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'username' => 'admin',
            'role' => 'admin',
            'password' => Hash::make('admin'),
        ]);
        User::create([
            'username' => 'pegawai',
            'role' => 'pegawai',
            'password' => Hash::make('pegawai'),
        ]);
    }
}
