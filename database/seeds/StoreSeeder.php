<?php

use Illuminate\Database\Seeder;
use App\Store;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $store = new Store;
        $store->store_id = 'jabong';
        $store->store_name = 'Jabong';
        $store->store_details = 'One Stop Shop for all your fashionable items.';
        $store->store_link = 'http://www.jabong.com';
        $store->store_logo = '/assets/img/brands/Jabong-Logo.jpg';
        $store->store_category = 'fashion';
        $store->store_cashback = 13;
        $store->save();
    }
}
