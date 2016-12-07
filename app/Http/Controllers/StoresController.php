<?php

namespace App\Http\Controllers;

use App\Category;
use App\Custom\Helpers\Helpers;
use App\Offer;
use App\Store;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;

class StoresController extends Controller
{
    protected $stores;
    protected $offers;
    //Perform requisite actions as defined in the function
    //Display the Stores Page
    public function getStores() {
        //Get all store categories
        if (isset($_GET) && !empty($_GET['categories'])) {
            $cat = $_GET['categories'];
            $query = DB::table('stores')
                ->join('category_stores', 'stores.store_id', '=', 'category_stores.store_id')
                ->whereRaw("category_stores.category_id = ANY('{" . strip_tags(implode(',', $cat)) . "}'::text[])")
                ->get();

            $stores = [];
            foreach ($query as $val) {
                array_push($stores, array(
                   "store_id" => $val->store_id,
                    "store_name" => $val->store_name,
                    "store_details" => $val->store_details,
                    "store_link" => $val->store_link,
                    "store_logo" => $val->store_logo,
                    "store_cashback" => $val->store_cashback,
                    "store_cashback_amount" => $val->store_cashback_amount,
                    "offers_count" => DB::table('store_offers')->where('store_id',$val->store_id)->count()
                ));
            }
            $data = array(
              "categories" => $this->getStoreCategories(),
                "stores" => Helpers::unique_arr($stores, 'store_id')
            );

            return view('pages.stores.stores', $data);
        }
        else {
            $query = DB::table('stores')->get();

            $stores = [];
            foreach ($query as $val) {
                array_push($stores, array(
                    "store_id" => $val->store_id,
                    "store_name" => $val->store_name,
                    "store_details" => $val->store_details,
                    "store_link" => $val->store_link,
                    "store_logo" => $val->store_logo,
                    "store_cashback" => $val->store_cashback,
                    "store_cashback_amount" => $val->store_cashback_amount,
                    "offers_count" => DB::table('store_offers')->where('store_id',$val->store_id)->count()
                ));
            }

            $data = array(
                "categories" => $this->getStoreCategories(),
                "stores" => Helpers::unique_arr($stores, 'store_id')
            );

            return view('pages.stores.stores', $data);
        }
    }

    //Get Store Categories
    public function getStoreCategories () {
        //Get categories data from database
        $cat_arr = DB::table('parent_categories')
            ->join('category_stores','parent_categories.category_id','=','category_stores.category_id')
            ->get();
        //Make an empty categories array
        $categories = [];
        //Foreach categories not in categories array
        //Insert it in categories array
        foreach ($cat_arr as $key => $value) {
            array_push($categories, array(
                "category_id" => $value->category_id,
                "category_name" => $value->category_name
            ));
        }
        //Return the categories array
        return Helpers::unique_arr($categories,'category_name');
    }
    
    // Stores Redirect Page
    public function visitStoreRedirectPage ($store_id) {
        if (!is_null(DB::table('stores')->where('store_id', $store_id)->first())) {
            $store = DB::table('stores')->where('store_id', $store_id)->first();
            return view('pages.storeRedirect')->with('store',$store);
        }
    }

    public function loadStore ($store_id, Request $request) {
        define('SELFID', "c3446faa-0e07-40e8-aef4-92301f553abb");

        if (!is_null(DB::table('stores')->where('store_id', $store_id)->first())) {
            $store = DB::table('stores')->where('store_id', $store_id)->first();

            // Make Link
            $rawUrl = explode('$', $store->store_link);
            for($i = 0; $i < count($rawUrl); $i++) {
                if ($rawUrl[$i] === "source") {
                    $rawUrl[$i] = $request->cookie('source');
                }
                elseif ($rawUrl[$i] === "user_id") {
                    $rawUrl[$i] = is_null($request->cookie('user_id')) ? SELFID : $request->cookie('user_id');
                }
                elseif ($rawUrl[$i] === "store_id") {
                    $rawUrl[$i] = $store->store_id;
                }
            }
            // Join URL array
            $url = implode("",$rawUrl);
            
            // Return the link
            return response()->json($url,200);
        }
    }
}
