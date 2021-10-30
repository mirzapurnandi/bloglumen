<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            ['name' => 'Categori Satu', 'slug' => 'categori-satu'],
            ['name' => 'Categori Dua', 'slug' => 'categori-dua'],
            ['name' => 'Categori Tiga', 'slug' => 'categori-tiga'],
            ['name' => 'Categori Empat', 'slug' => 'categori-empat'],
            ['name' => 'Categori Lima', 'slug' => 'categori-lima'],
            ['name' => 'Categori Enam', 'slug' => 'categori-enam'],
        ]);
    }
}
