<?php

use App\Order;
use App\Photo;
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

            $o = Order::create([
                'user_id' => $u->id,
                'status_id' => 1,
            ]);

            for ($i = 0; $i < 40; $i++) {
                Photo::create([
                    'user_id' => $u->id,
                    'order_id' => $o->id,
                    "url" => "default-avatar.png",
                ]);
            }
        });
    }
}
