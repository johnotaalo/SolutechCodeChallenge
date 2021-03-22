<?php

use Illuminate\Database\Seeder;

use App\Models\Supplier;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\Supplier::class, 10)->create();
    }
}
