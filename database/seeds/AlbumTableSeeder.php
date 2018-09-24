<?php

use Illuminate\Database\Seeder;

class AlbumTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Album::create([
            "name" => "Generic album",
            "min_photo_count" => 2,
            "max_photo_count" => 5,
            "monthly_price" => 19999,
        ]);
    }
}
