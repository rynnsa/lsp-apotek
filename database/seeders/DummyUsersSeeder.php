<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DummyUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userData = [
            [
                'name' => 'admin',
                'email' => 'admin@gmail.com',
                'jabatan' => 'admin',
                'password' => bcrypt('admin123'),
               
                'remember_token' => null,
            ],
            [
                'name' => 'apoteker',
                'email' => 'apoteker@gmail.com',
                'jabatan' => 'apoteker',
                'password' => bcrypt('apoteker123'),
                'remember_token' => null,
            ],
            [
                'name' => 'Karyawan',
                'email' => 'Karyawan@gmail.com',
                'jabatan' => 'Karyawan',
                'password' => bcrypt('Karyawan123'),
                'remember_token' => null,
            ],
             [
                'name' => 'kasir',
                'email' => 'kasir@gmail.com',
                'jabatan' => 'kasir',
                'password' => bcrypt('kasir123'),
                'remember_token' => null,
            ],
            [
                'name' => 'pemilik',
                'email' => 'pemilik@gmail.com',
                'jabatan' => 'pemilik',
                'password' => bcrypt('pemilik123'),
                'remember_token' => null,
            ],
        ];   

        foreach ($userData as $key => $val) {
            User::create($val);
        }
    }
}
