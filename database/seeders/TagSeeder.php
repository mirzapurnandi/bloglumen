<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tags')->insert([
            ['name' => 'Satu Tag', 'slug' => 'satu-tag'],
            ['name' => 'Dua Tag', 'slug' => 'dua-tag'],
            ['name' => 'Tiga Tag', 'slug' => 'tiga-tag'],
            ['name' => 'Empat Tag', 'slug' => 'empat-tag'],
            ['name' => 'Lima Tag', 'slug' => 'lima-tag'],
        ]);
    }
}
