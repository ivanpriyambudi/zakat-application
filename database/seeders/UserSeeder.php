<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin'),
            'type' => 'admin',
        ]);

        // $satuan = ['kg', 'bungkus', 'liter', 'renteng', 'kerdus', 'pack'];
        // foreach ($satuan as $key) {
        //     DB::table('satuans')->insert([
        //         'nama' => $key,
        //     ]);
        // }

        // $kategori = ['rokok','minuman','makanan','roti','jajan','es krim'];
        // foreach ($kategori as $key) {
        //     DB::table('kategori_barangs')->insert([
        //         'nama' => $key,
        //     ]);
        // }
    }
}
