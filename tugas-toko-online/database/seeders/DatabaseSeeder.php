<?php

namespace Database\Seeders;

use App\Models\Barang;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
    User::create([
        'id_user' => 'USR00001',
        'nama_lengkap' => 'Kevin Akbar',
        'email' => 'kevin@example.com',
        'username' => 'kevin',
        'password' => 'user123',
        'no_hp' => '0895377620405',
        'alamat' => 'Jl. Nurul IslaM',
    ]);

    User::create([
        'id_user' => 'USR00002',
        'nama_lengkap' => 'Lycoris Wanderer',
        'email' => 'wanderer@example.com',
        'username' => 'wanderer',
        'password' => 'user123',
        'no_hp' => '082240336394',
        'alamat' => 'Jl. Nurul Islam',
    ]);

        $data = [
            ['BRG001', 'Buku Tulis',  'Buku tulis 38 lembar',        5000,  50, 'buku-tulis.jpg'],
            ['BRG002', 'Pulpen',      'Pulpen tinta hitam 0.5 mm',   3000, 100, 'pulpen.jpg'],
            ['BRG003', 'Penggaris',   'Penggaris plastik 30 cm',     4000,  30, 'penggaris.jpg'],
            ['BRG004', 'Pensil 2B',   'Pensil 2B untuk ujian',       2500,  80, 'pensil.jpg'],
            ['BRG005', 'Penghapus',   'Penghapus putih bersih',      1500,  60, 'penghapus.jpg'],
            ['BRG006', 'Spidol',      'Spidol whiteboard hitam',     7000,  40, 'spidol.jpg'],
            ['BRG007', 'Stapler',     'Stapler kecil + isi',        15000,  20, 'stapler.jpg'],
            ['BRG008', 'Kertas HVS',  'Kertas HVS A4 1 rim',        45000,  15, 'kertas-hvs.jpg'],
            ['BRG009', 'Tipe-X',      'Correction tape (stok habis)', 6000,  0, 'tipex.jpg'],
            ['BRG010', 'Map Plastik', 'Map plastik snap A4',         2000,  70, 'map.jpg'],
        ];

        foreach ($data as [$id, $nama, $deskripsi, $harga, $stok, $gambar]) {
            Barang::create([
                'id_barang' => $id,
                'nama_barang' => $nama,
                'deskripsi' => $deskripsi,
                'harga' => $harga,
                'stok' => $stok,
                'gambar' => $gambar,
            ]);
        }
    }
}
