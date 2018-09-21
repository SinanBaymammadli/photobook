<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CountryTableSeeder::class);
        $this->call(LaratrustSeeder::class);
        $this->call(OrderStatusTableSeeder::class);
        $this->call(CategoryTableSeeder::class);
        $this->call(UserTableSeeder::class);
    }
}
