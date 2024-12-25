<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Product extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            [
                'category_id' => 1,
                'name' => 'kursi',
                'price' => 10000,
                'image' => 'IMG-0001',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 1,
                'name' => 'meja',
                'price' => 20000,
                'image' => 'IMG-0002',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
