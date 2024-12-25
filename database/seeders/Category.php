<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Category extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            [
                'name' => 'furniture',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'electronics',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
