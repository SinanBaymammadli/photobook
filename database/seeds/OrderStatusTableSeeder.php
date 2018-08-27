<?php

use App\OrderStatus;
use Illuminate\Database\Seeder;

class OrderStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OrderStatus::create([
            'name' => 'active',
            'display_name' => 'Active',
            'description' => 'Newly created order',
        ]);

        OrderStatus::create([
            'name' => 'waiting',
            'display_name' => 'Waiting',
            'description' => 'Photos send to printing',
        ]);

        OrderStatus::create([
            'name' => 'shipped',
            'display_name' => 'Shipped',
            'description' => 'Order shipped',
        ]);

        OrderStatus::create([
            'name' => 'delivered',
            'display_name' => 'Delivered',
            'description' => 'Order has been delivered successfully',
        ]);
    }
}
