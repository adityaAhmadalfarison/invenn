<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommodityLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $locations = [
            'Laboratorium Multimedia',
            'Laboratorium Pemrograman 1',
            'Laboratorium Pemrograman 2',
            'Ruang Teknisi',
            'Laboratorium Jaringan 1',
            'Laboratorium Jaringan 2',
            'Laboratorium AI',
            'Laboratorium Perakitan'
        ];

        for ($i = 1; $i < count($locations); $i++) {
            DB::table('commodity_locations')->insert([
                'name' => $locations[$i],
                'description' => 'Ruangan ' . $i,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        for ($i = 1; $i < 6; $i++) {
            DB::table('commodity_locations')->insert([
                'name' => 'Kelas ' . $i,
                'description' => 'Ruangan Kelas ' . $i,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
