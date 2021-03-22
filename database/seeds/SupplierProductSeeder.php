<?php

use Illuminate\Database\Seeder;

class SupplierProductSeeder extends Seeder
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
            $supplier = \App\Models\Supplier::inRandomOrder()->first();
            $product = \App\Models\Product::inRandomOrder()->first();

            $supplierProduct = new \App\Models\SupplierProduct();

            $supplierProduct->supply_id = $supplier->id;
            $supplierProduct->product_id = $product->id;

            $supplierProduct->save();
        }
    }
}
