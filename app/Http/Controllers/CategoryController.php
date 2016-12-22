<?php

namespace App\Http\Controllers;

use App\Custom\Helpers\Helpers;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Get Stores For Specified Offers
     *
     * Get the stores details for the specified offer array
     * In the function argument
     *
     * @param $search_query
     * @return array
     */
    private function getStores ($category = "") {
        // Get All Stores
        if ($category) {
            $offerrows = DB::table('offers')
                ->join('parent_category_offers','offers.offer_id','=','parent_category_offers.offer_id')
                ->where('parent_category_offers.category_id',$category)
                ->get();

            $stores = [];
            foreach ($offerrows as $offer_row) {
                $storerows = DB::table('stores')
                    ->join('store_offers','stores.store_id','=','store_offers.store_id')
                    ->where('store_offers.offer_id',$offer_row->offer_id)
                    ->get();
                foreach ($storerows as $store) {
                    array_push($stores, array(
                        "store_name" => $store->store_name,
                        "store_id" => $store->store_id,
                        "store_link" => $store->store_link,
                        "store_logo" => $store->store_logo,
                        "store_cashback" => $store->store_cashback,
                        "store_cashback_amount" => $store->store_cashback_amount
                    ));
                }
            }

            return Helpers::unique_arr($stores, 'store_id');
        }
        else {
            $rows = DB::table('stores')
                ->join('store_offers','stores.store_id','=','store_offers.store_id')
                ->get();

            $stores_list = [];
            foreach ($rows as $row) {
                array_push($stores_list, array(
                    "store_id" => $row->store_id,
                    "store_name" => $row->store_name,
                    "store_details" => $row->store_details,
                    "store_link" => $row->store_link,
                    "store_logo" => $row->store_logo
                ));
            }

            return Helpers::unique_arr($stores_list, 'store_id');
        }
    }

    /**
     * Get Store Details for particular offer
     *
     * @param $offers
     * @return array
     */
    private function getSingleOfferStoreName ($offers) {
        $stores = [];
        foreach ($offers as $offer) {
            $results = DB::table('stores')
                ->select('stores.store_id','stores.store_name','stores.store_link','stores.store_logo')
                ->join('store_offers', 'stores.store_id', '=', 'store_offers.store_id')
                ->where('store_offers.offer_id', $offer->offer_id)
                ->first();
            array_push($stores,$results);
        }

        return $stores;
    }

    /**
     * View Categories
     *
     * Display list of available parent categories
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function viewCategories ()
    {
        /**
         * Filter categories by stores
         **/
        if (isset($_GET) && !empty($_GET['stores'])) {
            $stores = $_GET['stores'];

            $queryResults = DB::table('parent_category_offers')
                ->join('store_offers', 'parent_category_offers.offer_id', '=', 'store_offers.offer_id')
                ->whereRaw("store_offers.store_id = ANY('{" . strip_tags(implode(',', $stores)) . "}'::text[])")
                ->get();

            $categories = [];
            foreach ($queryResults as $result) {
                // Get number of offers for this category
                $cat_offers_count = DB::table('offers')
                    ->join('parent_category_offers', 'offers.offer_id', '=', 'parent_category_offers.offer_id')
                    ->join('store_offers', 'offers.offer_id', '=', 'store_offers.offer_id')
                    ->where('parent_category_offers.category_id', $result->category_id)
                    ->whereRaw("store_offers.store_id = ANY('{" . strip_tags(implode(',', $stores)) . "}'::text[])")
                    ->count();

                // Get the Category details of this category
                $category_details = DB::table('parent_categories')
                    ->where('parent_categories.category_id',$result->category_id)
                    ->first();

                // Max Cashback
                $max_cashback = DB::table('offers')
                    ->join('parent_category_offers', 'offers.offer_id', '=', 'parent_category_offers.offer_id')
                    ->where('parent_category_offers.category_id', $result->category_id)
                    ->max('offer_cashback');

                // Push all into Categories array
                array_push($categories, array(
                    "category_id" => $category_details->category_id,
                    "category_name" => $category_details->category_name,
                    "category_img" => $category_details->category_img,
                    "offers_count" => $cat_offers_count,
                    "max_cashback" => $max_cashback
                ));
            }

            $data = array(
                "offers" => "",
                "categories" => Helpers::unique_arr($categories, 'category_id'),
                "stores" => $this->getStores()
            );

            return view('pages.category.categories', $data);
        }
        /**
         * Get All Available Offer Categories
         */
        else {
            // Get category of available offers details
            $query = DB::table('parent_categories')
                ->join('parent_category_offers','parent_categories.category_id','=','parent_category_offers.category_id')
                ->get();

            // Converting category object to array
            $parent_category = [];
            foreach ($query as $parent) {
                array_push($parent_category, array(
                    "category_id" => $parent->category_id,
                    "category_name" => $parent->category_name,
                    "category_img" => $parent->category_img
                ));
            }

            // Get the Categories details and
            // Associated offer numbers and max cashback
            $parent_category = Helpers::unique_arr($parent_category,'category_id');
            $category_details = [];
            foreach ($parent_category as $key => $val) {
                $offers_count = DB::table('parent_category_offers')
                    ->join('parent_categories','parent_category_offers.category_id','=','parent_categories.category_id')
                    ->where('parent_category_offers.category_id',$val['category_id'])
                    ->count();

                // Max Cashback
                $max_cashback = DB::table('offers')
                    ->join('parent_category_offers','offers.offer_id','=','parent_category_offers.offer_id')
                    ->where('parent_category_offers.category_id',$val['category_id'])
                    ->max('offer_cashback');

                // Push all into Categories array
                array_push($category_details,array(
                    "offers_count" => $offers_count,
                    "category_name" => $val['category_name'],
                    "category_id" => $val['category_id'],
                    "category_img" => $val['category_img'],
                    "max_cashback" => $max_cashback
                ));
            }

            $data = array(
                "offers" => "",
                "categories" => $category_details,
                "stores" => $this->getStores()
            );

            return view('pages.category.categories', $data);
        }
    }

    /**
     * View Offers By Categories
     *
     * Includes Filtering via Stores and Sub-Categories
     *
     * @param $category
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function viewOffersByCategories ($category) {
            if (isset($_GET) && !empty($_GET['categories']) || !empty($_GET['stores'])) {
                $query = DB::table('offers')
                    ->select('offers.offer_id', 'offers.offer_name', 'offers.offer_details', 'offers.offer_coupon_code', 'offers.offer_cashback', 'offers.offer_cashback_amount', 'offers.offer_verified', 'offers.offer_featured', 'offers.offer_link', 'offers.offer_validity', 'offers.created_at', 'offers.updated_at')
                    ->join('store_offers','offers.offer_id','=','store_offers.offer_id')
                    ->join('parent_category_offers','parent_category_offers.offer_id','=','offers.offer_id');

                // If Categories are not present
                // Get Offers via Stores instead
                if (empty($_GET['categories']) && !empty($_GET['sort'])) {
                    $stores = $_GET['stores'];
                    if ($_GET['sort'] == "newest") {
                        $results = $query->where('parent_category_offers.category_id',$category)
                            ->whereRaw("store_offers.store_id = ANY('{" . strip_tags(implode(',', $stores)) . "}'::text[])")
                            ->distinct()
                            ->orderBy('offer_id','desc')
                            ->get();
                    }
                    elseif ($_GET['sort'] == "oldest") {
                        $results = $query->where('parent_category_offers.category_id',$category)
                            ->whereRaw("store_offers.store_id = ANY('{" . strip_tags(implode(',', $stores)) . "}'::text[])")
                            ->distinct()
                            ->orderBy('offer_id','asc')
                            ->get();
                    }
                }
                // If Stores are not present
                // Get Offers via Categories instead
                else if (empty($_GET['stores']) && !empty($_GET['sort'])) {
                    $sub_categories = $_GET['categories'];
                    if ($_GET['sort'] == "newest") {
                        $results = $query->join('category_offers', 'offers.offer_id', '=', 'category_offers.offer_id')
                            ->where('parent_category_offers.category_id', $category)
                            ->whereRaw("category_offers.category_id = ANY('{" . strip_tags(implode(',', $sub_categories)) . "}'::text[])")
                            ->distinct()
                            ->orderBy('offer_id', 'desc')
                            ->get();
                    }
                    elseif ($_GET['sort'] == "oldest") {
                        $results = $query->join('category_offers', 'offers.offer_id', '=', 'category_offers.offer_id')
                            ->where('parent_category_offers.category_id', $category)
                            ->whereRaw("category_offers.category_id = ANY('{" . strip_tags(implode(',', $sub_categories)) . "}'::text[])")
                            ->distinct()
                            ->orderBy('offer_id', 'asc')
                            ->get();
                    }
                }
                // If Both Stores and Categories are present
                else {
                    $stores = $_GET['stores'];
                    $sub_categories = $_GET['categories'];
                    if ($_GET['sort'] == "newest") {
                        $results = $query->join('category_offers','offers.offer_id','=','category_offers.offer_id')
                            ->where('parent_category_offers.category_id',$category)
                            ->whereRaw("store_offers.store_id = ANY('{" . strip_tags(implode(',', $stores)) . "}'::text[])")
                            ->whereRaw("category_offers.category_id = ANY('{" . strip_tags(implode(',', $sub_categories)) ."}'::text[])")
                            ->distinct()
                            ->orderBy('offer_id', 'desc')
                            ->get();
                    }
                    elseif ($_GET['sort'] == "oldest") {
                        $results = $query->join('category_offers','offers.offer_id','=','category_offers.offer_id')
                            ->where('parent_category_offers.category_id',$category)
                            ->whereRaw("store_offers.store_id = ANY('{" . strip_tags(implode(',', $stores)) . "}'::text[])")
                            ->whereRaw("category_offers.category_id = ANY('{" . strip_tags(implode(',', $sub_categories)) ."}'::text[])")
                            ->distinct()
                            ->orderBy('offer_id', 'asc')
                            ->get();
                    }
                }

                // Get Stores
                $all_stores = $this->getStores($category);

            }
            // If No Sub-Categories Or Stores Present
            else {
                if (!empty($_GET['sort'])) {
                    if ($_GET['sort'] == "newest") {
                        $results = DB::table('offers')
                            ->join('parent_category_offers','offers.offer_id','=','parent_category_offers.offer_id')
                            ->select('offers.offer_id','offers.offer_name','offers.offer_details','offers.offer_coupon_code','offers.offer_cashback','offers.offer_cashback_amount','offers.offer_verified','offers.offer_link','offers.offer_validity','offers.created_at','offers.updated_at')
                            ->where('parent_category_offers.category_id',$category)
                            ->orderBy('offer_id', 'desc')
                            ->get();
                    }
                    elseif ($_GET['sort'] == "oldest") {
                        $results = DB::table('offers')
                            ->join('parent_category_offers','offers.offer_id','=','parent_category_offers.offer_id')
                            ->select('offers.offer_id','offers.offer_name','offers.offer_details','offers.offer_coupon_code','offers.offer_cashback','offers.offer_cashback_amount','offers.offer_verified','offers.offer_link','offers.offer_validity','offers.created_at','offers.updated_at')
                            ->where('parent_category_offers.category_id',$category)
                            ->orderBy('offer_id', 'asc')
                            ->get();
                    }
                    // Get Stores
                    $all_stores = $this->getStores($category);
                }
                else {
                    // Get by default ascending order results
                    $results = DB::table('offers')
                        ->join('parent_category_offers','offers.offer_id','=','parent_category_offers.offer_id')
                        ->select('offers.offer_id','offers.offer_name','offers.offer_details','offers.offer_coupon_code','offers.offer_cashback','offers.offer_cashback_amount','offers.offer_verified','offers.offer_link','offers.offer_validity','offers.created_at','offers.updated_at')
                        ->where('parent_category_offers.category_id',$category)
                        ->orderBy('offer_id', 'desc')
                        ->get();
                    // Get Stores
                    $all_stores = $this->getStores($category);
                }
            }

        // Get The Sub-Categories for the specified Parent category
        $sub_cat_rows = DB::table('categories')
            ->join('category_offers','categories.category_id','=','category_offers.category_id')
            ->join('parent_categories','categories.parent','=','parent_categories.category_id')
            ->select('categories.category_id','categories.category_name')
            ->where('parent_categories.category_id',$category)
            ->get();

        // Make the Object Array to Index Array
        $sub_categories = [];
        foreach ($sub_cat_rows as $sub_cat_row) {
            array_push($sub_categories, array(
                "category_id" => $sub_cat_row->category_id,
                "category_name" => $sub_cat_row->category_name
            ));
        }

        // Get The Category Details
        $cat_details = DB::table('parent_categories')
            ->select('category_name','category_img','category_img_big')
            ->where('category_id',$category)
            ->first();

        $data = array(
            "offers" => $results,
            "sub_categories" => Helpers::unique_arr($sub_categories, 'category_id'),
            "category_details" => $cat_details,
            "offer_stores" => $this->getSingleOfferStoreName($results),
            "stores" => $all_stores
        );

        //dd($data);

        return view('pages.category.categories', $data);
    }
}
