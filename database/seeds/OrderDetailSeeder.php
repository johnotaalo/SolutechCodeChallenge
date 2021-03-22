<?php

use Illuminate\Database\Seeder;

class OrderDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $number = 10;

        for ($i = 0; $i < $number; $i++){
            $order = \App\Models\Order::inRandomOrder()->first();
            $product = \App\Models\Product::inRandomOrder()->first();

            $orderDetail = new \App\Models\OrderDetail();

            $orderDetail->order_id = $order->id;
            $orderDetail->product_id = $product->id;

            $orderDetail->save();
        }
    }
}
