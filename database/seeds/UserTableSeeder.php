<?php

use App\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class, 15)->create()->each(function ($u) {
            event(new Registered($u));

            for ($i = 0; $i < 40; $i++) {
                $u->photos()->save(factory(App\Photo::class)->make());
            }
        });
    }
}
