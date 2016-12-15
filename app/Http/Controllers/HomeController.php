<?php

namespace App\Http\Controllers;

use App\Offer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * The Homepage Rendering Controller
     * Displays All Homepage Items
     */

    // This function readies the Home Page with the latest
    // Data and Stuff
    public function home () {
        // Hot Deals Card View
        $offers = Offer::where('offer_featured',true)
            ->where('offer_validity', '>', Carbon::now())
            ->orderBy('offer_id','desc')
            ->take(12)
            ->get();

        // Store Offer Count
        $storeOffer = [];
        foreach ($offers as $offer) {
            $store = DB::table('store_offers')
                ->where('offer_id',$offer->offer_id)
                ->first();

            $count = DB::table('store_offers')
                ->where('store_id',$store->store_id)
                ->count();

            array_push($storeOffer, array(
                "store_id" => $store->store_id,
                "count" => $count
            ));
        }

        // Offer Store Image
        $storeImg = [];
        foreach ($offers as $offer) {
            $store = DB::table('store_offers')
                ->select('store_id')
                ->where('offer_id', $offer->offer_id)
                ->first();

            $store_img = DB::table('stores')->select('store_logo')->where('store_id', $store->store_id)->first();
            array_push($storeImg, array(
                "store_img" => $store_img->store_logo
            ));
        }

        // Get Todays Deals
        $todays_deals = DB::table('todays_deals')
            ->orderBy('created_at', 'DESC')
            ->take(10)
            ->get();

        $deals = [];
        foreach ($todays_deals as $today_deal) {
            $store = DB::table('stores')->select('store_name','store_logo')->where('store_id',$today_deal->deal_store)->first();
            array_push($deals, array(
                "deal_id" => $today_deal->deal_id,
                "deal_name" => $today_deal->deal_name,
                "deal_details" => $today_deal->deal_details,
                "deal_img" => $today_deal->deal_img,
                "deal_link" => $today_deal->deal_link,
                "deal_store" => $today_deal->deal_store,
                "deal_store_logo" => $store->store_logo,
                "deal_store_name" => $store->store_name,
                "deal_old_price" => $today_deal->deal_old_price,
                "deal_new_price" => $today_deal->deal_new_price,
                "deal_cashback_amount" => $today_deal->deal_cashback_amount,
                "deal_cashback" => $today_deal->deal_cashback,
                "deal_discount" => $today_deal->deal_discount
            ));
        }

        $data = array(
            "sliders" => $this->getSliders(),
            "today_deals" => $deals,
            "offers" => $offers,
            "offersStoreImg" => $storeImg,
            "storeOffer" => $storeOffer,
            "top_stores" => $this->getTopStores(),
            "top_stores_offer_count" => $this->getStoreOfferCount($this->getTopStores())
        );

        return view('pages.home.home', $data);
    }

    private function getSliders () {
        $raw_sliders = DB::table('sliders')
            ->where('expiry', '>', Carbon::now())
            ->orderBy('created_at', 'desc')
            ->get();

        $main_featured = [];
        $sub_featured = [];
        foreach ($raw_sliders as $raw_slider) {
            if ($raw_slider->main_featured) {
                array_push($main_featured, $raw_slider);
            }
            else if ($raw_slider->sub_featured) {
                array_push($sub_featured, $raw_slider);
            }
        }

        return array(
            "main_featured" => $main_featured,
            "sub_featured" => array_slice($sub_featured,0,2)
        );
    }

    /**
     * Get Top 12 Stores
     *
     * @return array
     */
    private function getTopStores () {
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
        $top_ten_stores = array_splice($stores, 0, 12);

        $stores = [];
        foreach ($top_ten_stores as $store_id => $store_count) {
            $store = DB::table('stores')->where('store_id', $store_id)->first();
            array_push($stores, $store);
        }

        return $stores;

    }

    /**
     * Get Offer Count
     *
     * @param $stores
     * @return array
     */
    private function getStoreOfferCount ($stores) {
        // Get the number of offers per store.
        $offersCount = [];
        foreach ($stores as $store) {
            array_push($offersCount, DB::table('store_offers')->where('store_id',$store->store_id)->count());
        }

        return $offersCount;
    }

    /**
     * Deal Redirect View Page
     *
     * @param $deal_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function visitDealRedirectPage ($deal_id) {
        $deal = DB::table('todays_deals')
            ->where('deal_id', $deal_id)
            ->first();

        $store = DB::table('stores')
            ->where('store_id', $deal->deal_store)
            ->first();

        return view('pages.dealRedirect', compact('deal','store'));
    }

    public function loadDeal ($deal_id, Request $request) {
        // Self User ID
        define('SELFID',"c3446faa-0e07-40e8-aef4-92301f553abb");

        $deal = DB::table('todays_deals')
            ->where('deal_id',$deal_id)
            ->first();

        // Make Link
        $rawUrl = explode('$', $deal->deal_link);
        for($i = 0; $i < count($rawUrl); $i++) {
            if ($rawUrl[$i] === "source") {
                $rawUrl[$i] = $request->cookie('source');
            }
            elseif ($rawUrl[$i] === "user_id") {
                $rawUrl[$i] = is_null($request->cookie('user_id')) ? SELFID : $request->cookie('user_id');
            }
            elseif ($rawUrl[$i] === "store_id") {
                $rawUrl[$i] = $deal->deal_store;
            }
        }
        // Join URL array
        $url = implode("",$rawUrl);

        // Return the link
        return response()->json($url,200);
    }

}
