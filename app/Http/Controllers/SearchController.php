<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Search;
use Illuminate\Http\Request;

class SearchController extends Controller
{
	/**
	 * Main Search Function
	 *
	 * Search the whole database for the specified text
	 * Full-text searching on Offer_name, Offer_details and Categories column
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function search(Request $request)
	{
		if (!empty($request->input('q'))) {
			$data = Search::getOffers($request->input());
		}
			
		return view('pages.search.search', $data);
	}
}
