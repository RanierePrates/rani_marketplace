<?php

use App\Product;
use App\Store;
use Illuminate\Database\Seeder;

class StoreTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $stores = Store::all();

        $stores->each(function ($store) {
            $store->products()->save(
                factory(Product::class)->make()
            );
        });
    }
}
