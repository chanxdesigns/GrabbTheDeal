<?php

namespace App\Providers;

use App\Custom\Helpers\Helpers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('layouts.master', function ($view) {
            /**
             * Navbar Dynamic Contents
             *
             * Generate the top 10 stores using the total offers count
             * Generate the top 10 categories using the total offers count
             */
            $get_stores = DB::table('store_offers')->get();
            $stores_with_count = [];
            foreach ($get_stores as $store) {
                $store_offer_count = DB::table('store_offers')->where('store_id', $store->store_id)->count();
                array_push($stores_with_count, array(
                    $store->store_id => $store_offer_count
                ));
            }

            for ($i = 0; $i < count($stores_with_count); $i++) {
                foreach ($stores_with_count[$i] as $key => $val) {
                    $stores[$key] = $val;
                }
            }
            arsort($stores);
            $top_ten_stores = array_splice($stores, 0, 10);

            $stores = [];
            foreach ($top_ten_stores as $store_id => $store_count) {
                $store = DB::table('stores')->where('store_id', $store_id)->first();
                array_push($stores, $store);
            }

            /**
             * Generate the top 10 categories using the total offers count
             */
            $get_categories = DB::table('parent_category_offers')->get();
            $categories_offer_count = [];

            foreach ($get_categories as $get_category) {
                $category_offer_count = DB::table('parent_category_offers')->where('category_id', $get_category->category_id)->count();
                array_push($categories_offer_count, array(
                    $get_category->category_id => $category_offer_count
                ));
            }

            for ($i = 0; $i < count($categories_offer_count); $i++) {
                foreach ($categories_offer_count[$i] as $key => $val) {
                    $categories[$key] = $val;
                }
            }
            // Sort out the categories that have the highest number of orders
            arsort($categories);
            // Extract the top 10 categories
            $top_ten_categories = array_splice($categories, 0, 10);

            // Top categories details array
            $categories = [];
            foreach ($top_ten_categories as $category_id => $offer_count) {
                $category = DB::table('parent_categories')->where('category_id', $category_id)->first();
                array_push($categories, $category);
            }

            /**
             * Footer Dynamic Contents
             *
             * Generate Categories and Stores Links
             */
            $total_categories = DB::table('parent_categories')->get();
            $total_stores = DB::table('stores')->get();

            // Data to be passed to the view
            $data = array(
                "top_stores" => $stores,
                "top_categories" => $categories,
                "categories" => $total_categories,
                "stores" => $total_stores
            );

            $view->with($data);
        });
        /**
        View::composer('layouts.master', function ($view) {
            $get_stores = DB::table('category_stores')
                ->take(20)
                ->get();

            $stores = [];
            $categories = [];
            foreach ($get_stores as $store) {
                //dd(!in_array($store->category_id,$categories));
                if (!in_array($store->category_id,$categories)) {
                    $category = DB::table('parent_categories')
                        ->select('category_id','category_name')
                        ->where('category_id',$store->category_id)
                        ->first();

                    array_push($categories, $category->category_id);

                    $store = DB::table('stores')
                        ->join('category_stores','stores.store_id','=','category_stores.store_id')
                        ->select('stores.store_name','stores.store_id')
                        ->where('category_stores.category_id', $store->category_id)
                        ->get();

                    array_push($stores, array(
                        "category" => $category,
                        "store" => $store
                    ));
                }
            }

            $view->with('footerStores',$stores);
        });
         **/
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
