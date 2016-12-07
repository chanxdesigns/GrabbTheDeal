<?php

namespace App;

use App\Custom\Helpers\Helpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Search extends Model
{
    protected static $sql_query;

    /**
     * Get Categories For Specified Offers
     *
     * Get the category details for the specified offer array
     * In the function argument
     *
     * @param $search_query
     * @return array
     */
    private static function getCategories($search_query) {
        // Categories array
        $categories = [];

        // Get Stores
        $storesQ_ = DB::table('offers')
            ->join('store_offers', 'offers.offer_id', '=', 'store_offers.offer_id')
            ->select('offers.offer_id')
            ->whereRaw('to_tsvector(offers.offer_name) || to_tsvector(store_offers.store_id) || to_tsvector(offers.offer_details) @@ plainto_tsquery(:query)',['query' => $search_query])
            ->get();

        // Get Category Details
        for ($i = 0; $i < count($storesQ_); $i++) {
            $query = DB::table('categories')
                ->join('category_offers', 'categories.category_id', '=', 'category_offers.category_id')
                ->select('categories.category_name', 'categories.category_id')
                ->where('category_offers.offer_id', $storesQ_[$i]->offer_id)
                ->get();

            // Insert into $categories array
            for ($j = 0; $j < count($query); $j++) {
                array_push($categories, array(
                    "category_name" => $query[$j]->category_name,
                    "category_id" => $query[$j]->category_id
                ));
            }
        }

        // Return filtered categories array
        return Helpers::unique_arr($categories, 'category_id');
    }

    private static function getSingleStore ($offers) {
        $stores = [];
        foreach ($offers as $offer) {
            $store = DB::table('stores')
                ->join('store_offers', 'stores.store_id', '=', 'store_offers.store_id')
                ->where('store_offers.offer_id', $offer->offer_id)
                ->first();
            array_push($stores,$store);
        }
        return $stores;
    }

    /**
     * Get Stores For Specified Offers
     *
     * Get the stores details for the specified offer array
     * In the function argument
     *
     * @param $search_query
     * @return array
     */
    private static function getStores ($search_query) {
        $stores = [];
        $results = DB::select(self::$sql_query, ["query" => $search_query]);

        foreach ($results as $result) {
            $sqlres = DB::table('stores')
                ->join('store_offers', 'stores.store_id', '=', 'store_offers.store_id')
                ->where('store_offers.offer_id', $result->offer_id)
                ->first();

            array_push($stores, array(
                "store_id" => $sqlres->store_id,
                "store_name" => $sqlres->store_name,
                "store_details" => $sqlres->store_details,
                "store_link" => $sqlres->store_link,
                "store_logo" => $sqlres->store_logo,
                "store_cashback" => $sqlres->store_cashback
            ));
        }

        // Return unique stores array
        return Helpers::unique_arr($stores,'store_id');
    }

    /**
     * Get the results from the search query
     *
     * Search the database for the query specified by the user
     *
     * @param $input array
     * @return array
     * */
    public static function getOffers ($input) {

        // Regex to filter the search query and replace every whitespace with the pipe character
        //$filter_query = preg_replace('/[\t\s\.,\/#!$%\^&\*;:{}=\-_`~\(\)]+/', " ", $input['q']);
        //$query = strip_tags(preg_replace('/[\s]+/', "|", $filter_query));

        // Default SQL Query
        self::$sql_query = "SELECT DISTINCT offers.offer_id,offers.offer_name,offers.offer_details,offers.offer_coupon_code,offers.offer_cashback,offers.offer_cashback_amount,offers.offer_verified,offers.offer_link,offers.offer_validity,offers.created_at,offers.updated_at FROM (SELECT offers.offer_id,offers.offer_name,offers.offer_details,offers.offer_coupon_code,offers.offer_cashback,offers.offer_cashback_amount,offers.offer_verified,offers.offer_link,offers.offer_validity,offers.created_at,offers.updated_at FROM offers JOIN category_offers USING(offer_id) JOIN parent_category_offers USING(offer_id) JOIN store_offers USING(offer_id) WHERE to_tsvector(category_offers.category_id) || to_tsvector(parent_category_offers.category_id) || to_tsvector(offers.offer_name) || to_tsvector(offers.offer_details) || to_tsvector(store_offers.store_id) @@ plainto_tsquery(:query)) as Offers";

        // Get and Assign Sort Value
        $sort = "DESC";
        if (isset($input['sort'])) {
            if ($input['sort'] == "newest") {
                $sort = "DESC";
            }
            elseif ($input['sort'] == "oldest") {
                $sort = "ASC";
            }
        }

        // Filter the URL Query Chain
        if (isset($input['categories']) && isset($input['stores'])) {
            $sql = self::$sql_query." JOIN category_offers USING (offer_id) JOIN store_offers USING (offer_id) WHERE category_offers.category_id = ANY('{".strip_tags(implode(',',$input['categories']))."}'::text[]) AND store_offers.store_id = ANY('{".strip_tags(implode(',',$input['stores']))."}'::text[]) ORDER BY offer_id ". $sort;

            $result = DB::select($sql, ['query' => $input['q']]);
        }
        elseif (isset($input['categories'])) {
            $sql = self::$sql_query." JOIN category_offers USING (offer_id) WHERE category_offers.category_id = ANY('{".strip_tags(implode(',',$input['categories']))."}'::text[]) ORDER BY offer_id ". $sort;

            $result = DB::select($sql, ['query' => $input['q']]);
        }
        elseif (isset($input['stores'])) {
            $sql = self::$sql_query." JOIN store_offers USING (offer_id) WHERE store_offers.store_id = ANY('{".strip_tags(implode(',',$input['stores']))."}'::text[]) ORDER BY offer_id ". $sort;

            $result = DB::select($sql, ['query' => $input['q']]);
        }
        else {
            $result= DB::select(self::$sql_query." ORDER BY offer_id ". $sort, ['query' => $input['q']]);
        }

        // Return the result
        return array(
            "search_query" => $input['q'],
            "search_results" => $result,
            "categories" => self::getCategories($input['q']),
            "singleStore" => self::getSingleStore($result),
            "stores" => self::getStores($input['q'])
        );

    }
}
