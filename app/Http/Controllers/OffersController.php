<?php

namespace App\Http\Controllers;

use App\Custom\Helpers\Helpers;
use App\Offer;
use App\Store;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class offersController extends Controller
{
    /**
     * @param $storeid
     * @param string $category
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     * Routes
     * ----------------------------------------------
     * www.grabbthedeal.in/offers/{store}
     * www.grabbthedeal.in/offers/{store}/{category}
     * ----------------------------------------------
     */

    /**
     * Get Stores For All Offers
     *
     * @param $offer
     * @return $stores array
     */
    private function getStoresForAllOffers ($store_offers) {
        $stores = [];
        foreach ($store_offers as $store_offer) {
            $store = DB::table('stores')->where('store_id',$store_offer->store_id)->first();
            //dd($store);
            array_push($stores, array(
               "store_name" => $store->store_name,
                "store_id" => $store->store_id,
                "store_link" => $store->store_link,
                "store_logo" => $store->store_logo,
                "store_cashback" => $store->store_cashback
            ));
        }
        return Helpers::unique_arr($stores, 'store_id');
    }

    /**
     * Get Categories For Offers
     *
     * Get all the categories for the specified offer ids
     *
     * @param $offers
     * @return array
     */
    private function getCategories ($offers) {
        $categories = [];
        foreach ($offers as $val) {
            $cat_arr = DB::table('categories')
                ->join('category_offers','categories.category_id','=','category_offers.category_id')
                ->select('categories.category_name','categories.category_id')
                ->where('category_offers.offer_id',$val->offer_id)
                ->get();

            foreach ($cat_arr as $category) {
                array_push($categories, array(
                    "category_name" => $category->category_name,
                    "category_id" => $category->category_id
                ));
            }
        }
        return Helpers::unique_arr($categories, 'category_id');
    }

    /**
     * Get Offers
     *
     * Get offers filtered by Category
     * And also by Stores
     *
     * @param string $storeid
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getOffers ($storeid) {
            // If Store ID is present
            $query = Offer::join('store_offers', 'offers.offer_id', '=', 'store_offers.offer_id')->where('store_offers.store_id',$storeid)->where("offers.offer_validity",">", Carbon::now());
            // Get Paginated Offers Page
            if (isset($_GET) && !empty($_GET["categories"])) {
                if (empty($_GET["sort"]) || $_GET["sort"] == 'newest') {
                    $offers = $query->join("category_offers", "offers.offer_id", "=", "category_offers.offer_id")
                        ->select('offers.offer_id', 'offers.offer_name', 'offers.offer_details', 'offers.offer_coupon_code', 'offers.offer_cashback', 'offers.offer_verified', 'offers.offer_featured', 'offers.offer_link', 'offers.offer_validity', 'offers.created_at', 'offers.updated_at')
                        ->whereRaw("category_offers.category_id = ANY('{" . strip_tags(implode(',', $_GET["categories"])) . "}')")
                        ->orderBy('offer_id', 'desc')
                        ->distinct()
                        ->paginate(20);
                }
                elseif ($_GET["sort"] == 'oldest') {
                    $offers = $query->join("category_offers", "offers.offer_id", "=", "category_offers.offer_id")
                        ->select('offers.offer_id', 'offers.offer_name', 'offers.offer_details', 'offers.offer_coupon_code', 'offers.offer_cashback', 'offers.offer_verified', 'offers.offer_featured', 'offers.offer_link', 'offers.offer_validity', 'offers.created_at', 'offers.updated_at')
                        ->whereRaw("category_offers.category_id = ANY('{" . strip_tags(implode(',', $_GET["categories"])) . "}')")
                        ->orderBy('offer_id', 'asc')
                        ->distinct()
                        ->paginate(20);
                }
            }
            elseif (isset($_GET) && !empty($_GET["sort"])) {
                if ($_GET["sort"] == 'newest') {
                    $offers = $query->orderBy('offers.offer_id', 'desc')->paginate(20);
                }
                elseif ($_GET["sort"] == 'oldest') {
                    $offers = $query->orderBy('offers.offer_id', 'asc')->paginate(20);
                }
            }
            else {
                $offers = $query->orderBy('offers.offer_id', 'desc')->paginate(20);
                //dd($offers);
            }

            // Data Array to pass to the offers View
            $data = array(
                'offers' => $offers,
                'offers_count' => DB::table('store_offers')->where('store_id', $storeid)->where("offer_validity",">", Carbon::now())->count(),
                'offer_categories' => $this->getCategories($offers),
                'store' => Store::where('store_id','=',$storeid)->firstOrFail()
            );

            // Return the view with the attached data
            return view('pages.offers.offers', $data);
    }

    /**
     * Offer Redirect View Page
     *
     * @param $offer_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function visitOfferRedirectPage ($offer_id) {
        $offer = DB::table('offers')
            ->where('offer_id', $offer_id)
            ->first();

        $store = DB::table('stores')
            ->join('store_offers','stores.store_id','=','store_offers.store_id')
            ->where('store_offers.offer_id',$offer->offer_id)
            ->first();

        return view('pages.offerRedirect', compact('offer','store'));
    }

    /**
     * Load Offers
     *
     * Redirect to offer store site with tracking link
     * Update tracking link with aff_sub = User ID and aff_sub2 = Store ID if applicable
     *
     * @param $offer_id string
     * @param $request Request
     * @return redirect Redirect
     */
    public function loadOffer($offer_id, Request $request) {
        // Self User ID
        define('SELFID',"c3446faa-0e07-40e8-aef4-92301f553abb");

        $offer = DB::table('offers')
            ->where('offer_id', $offer_id)
            ->first();

        $store_id = DB::table('store_offers')
            ->where('offer_id', $offer_id)
            ->first();

        // Make Link
        $rawUrl = explode('$', $offer->offer_link);
        for($i = 0; $i < count($rawUrl); $i++) {
            if ($rawUrl[$i] === "source") {
                $rawUrl[$i] = $request->cookie('source');
            }
            elseif ($rawUrl[$i] === "user_id") {
                $rawUrl[$i] = is_null($request->cookie('user_id')) ? SELFID : $request->cookie('user_id');
            }
            elseif ($rawUrl[$i] === "store_id") {
                $rawUrl[$i] = $store_id->store_id;
            }
        }
        // Join URL array
        $url = implode("",$rawUrl);

        // Return the link
        return response()->json($url,200);
    }
}
