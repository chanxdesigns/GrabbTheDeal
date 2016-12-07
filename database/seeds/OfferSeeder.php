<?php

use Illuminate\Database\Seeder;
use App\Offer;

class OfferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $offer = new Offer;
        $offer->offer_name = "Shoes 50% Off Only On Purchase Of Rs. 1500";
        $offer->offer_slug = str_slug("Shoes 40% Off Only On Purchase Of Rs. 1500","-");
        $offer->offer_id = 123715;
        $offer->offer_details = "Get upto 40% Off on all shoes on purchase of minimum of Rs. 1500. Get an additional 8% as cashback when you purchase from Grabb The Deal";
        $offer->offer_category = "fashion";
        $offer->offer_cashback = 8;
        $offer->offer_verified = "true";
        $offer->offer_featured = "true";
        $offer->offer_link = "http://www.jabong.com/some-offer-here-there";
        $offer->offer_validity = \Carbon\Carbon::now();
        $offer->offer_store_logo = "/assets/img/brands/Jabong-Logo.jpg";
        $offer->offer_store_id = "jabong";
        $offer->save();
    }
}
