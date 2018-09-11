<?php

use App\Order;
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
        factory(App\User::class, 10)->create()->each(function ($user) {
            event(new Registered($user));

            for ($i = 0; $i < 2; $i++) {
                // create order
                $order = Order::create([
                    'user_id' => $user->id,
                    'status_id' => 1,
                ]);

                // create item for each order
                for ($j = 0; $j < 2; $j++) {
                    $order_item = $order->items()->save(factory(App\OrderItem::class)->make());

                    for ($k = 0; $k < $order_item->product_type->photo_count; $k++) {
                        $order_item->photos()->save(factory(App\OrderItemPhoto::class)->make());
                    }
                }
            }

        });
    }
}
