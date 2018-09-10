<?php

use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Category::class, 5)->create()->each(function($c) {
            for ($i=0; $i < 5; $i++) {
                $c->products()->save(factory(App\Product::class)->make());
            }
        });
    }
}
