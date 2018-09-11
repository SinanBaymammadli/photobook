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
        factory(App\Category::class, 5)->create()->each(function ($c) {
            for ($i = 0; $i < 5; $i++) {
                $p = $c->products()->save(factory(App\Product::class)->make());

                // product photos
                $p->photos()->save(factory(App\ProductPhoto::class)->make());
                $p->photos()->save(factory(App\ProductPhoto::class)->make());
                $p->photos()->save(factory(App\ProductPhoto::class)->make());
                $p->photos()->save(factory(App\ProductPhoto::class)->make());
                $p->photos()->save(factory(App\ProductPhoto::class)->make());

                // product types
                $p->types()->save(factory(App\ProductType::class)->make());
                $p->types()->save(factory(App\ProductType::class)->make());
            }
        });
    }
}
