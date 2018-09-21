<?php

use Illuminate\Database\Seeder;

class CountryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Country::class, 5)->create()->each(function ($country) {
            $country->cities()->save(factory(App\City::class)->make());
            $country->cities()->save(factory(App\City::class)->make());
            $country->cities()->save(factory(App\City::class)->make());
            $country->cities()->save(factory(App\City::class)->make());
            $country->cities()->save(factory(App\City::class)->make());
        });
    }
}
