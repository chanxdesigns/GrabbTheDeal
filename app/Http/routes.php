<?php

/***-----------------------------------------
 | Available App Routes
 | Grabb The Deal
 | www.grabbthedeal.in - 2016
-------------------------------------------*/

// Home Page
Route::get('/', 'HomeController@home');
// How It Works
Route::get('/how-it-works', function () {
    return view('pages.how-it-works');
});
// About Us
Route::get('/about', function () {
    return view('pages.about');
});
// Help, Support & FAQ
Route::get('/faq', function () {
   return view('pages.help-support.help');
});
// Contact Us
Route::get('/contact', 'ContactController@getContactForm');
// Send Contact Mail
Route::post('/contact/send', 'ContactController@sendContactData');
// Terms and Conditions
Route::get('/terms-conditions', function () {
    return view('pages.terms-condition');
});
// Privacy Policy
Route::get('/privacy-policy', function () {
    return view('pages.privacy-policy');
});

/***----------------------------------------
 | Offers and Stores Route
 -----------------------------------------*/
Route::group(['middleware' => 'web'], function () {
// Display Offers By Store
    Route::get('/offers/{store}', 'OffersController@getOffers')->name('offers');
// Display All Stores
    Route::get('/stores', 'StoresController@getStores')->name('stores');
// Display Offers By Category
    Route::get('/categories', 'CategoryController@viewCategories')->name('categories');
    Route::get('/category/{category?}', 'CategoryController@viewOffersByCategories')->name('offersByCategories');
// Search Route
    Route::get('/search', 'SearchController@search');

/***----------------------------------------
 | User Authentication Route
-----------------------------------------*/
    // Login & Register Posts URL
    Route::post('/login', 'AuthController@doLogin')->name('login');
    Route::post('/register', 'AuthController@doRegister')->name('register');
    // Token Verification
    Route::get('/verify/{id}/{token}', 'AuthController@verifyEmail')->name('verifyEmail');
    // Forgot and Reset Password
    Route::get('/password/reset', 'PasswordResetController@getResetPage');
    Route::post('/password/reset/request', 'PasswordResetController@doPasswordReset');
    Route::get('/password/reset/{id}/{token}', 'PasswordResetController@verifyPasswordResetToken');
    Route::post('/password/reset/new', 'PasswordResetController@generateNewPassword');
    // Prefix with '/user'
    Route::group(['prefix' => 'user', 'middleware' => 'auth'], function () {
        // Logout
        Route::get('/logout', 'AuthController@doLogout')->name('logout');
        // Get partials of each myaccount menu tab
		Route::get('/{id}/myaccount', 'UserController@getDashboard')->name('myaccount');
        Route::get('/{id}/dashboard', 'UserController@getDashboard');
        Route::get('/{id}/activity', 'UserController@getActivity');
        Route::get('/{id}/bonus', 'UserController@getBonus');
        Route::get('/{id}/withdrawals', 'UserController@getWithdrawals');
        Route::post('/{id}/withdrawals/request', 'UserController@sendWithdrawalRequest');
        Route::get('/{id}/referrals', 'UserController@getReferrals');
        Route::get('/{id}/profile', 'UserController@getProfileDetails');
        Route::post('/{id}/profile/update', 'UserController@updateProfileDetails');
        Route::get('/{id}/payment', 'UserController@getPaymentDetails');
        Route::post('/{id}/payment/update', 'UserController@updatePaymentDetails');
        Route::post('/{id}/support/request', 'UserController@requestSupport');

        /**--------------------------------------
         *  AJAX Urls
         *  {
         *      "dashboard": "#dashboard",
         *      "activity": "#activity",
         *      "bonus": "#bonus",
         *      "withdrawals": "#withdrawals",
         *      "referrals": "#referrals",
         *      "profile": "#profile",
         *      "payment": "#payment",
         *      "support": "#support"
         * }
         */
    });

    /**
     * Cashback Store Redirect Page
     */
    Route::get('/offer-redirect/{offer_id}', 'OffersController@visitOfferRedirectPage');
    Route::get('/load-offer/{offer_id}', 'OffersController@loadOffer');
    Route::get('/store-redirect/{store_id}', 'StoresController@visitStoreRedirectPage');
    Route::get('/load-store/{store_id}', 'StoresController@loadStore');
    Route::get('/deal-redirect/{deal_id}', 'HomeController@visitDealRedirectPage');
    Route::get('/load-deal/{deal_id}', 'HomeController@loadDeal');

    /**
     * Postback Tracking Conversions
     * Track Conversions: Payout, Sale, Transaction ID
     *
     * http://www.grabbthedeal.in/pb/tracking?offer_id=1202&source=direct&payout=99.1785&transaction_id=TestNew&aff_sub=c3446faa-0e07-40e8-aef4-92301f553abb&aff_sub2=flipkart
     */
    Route::get('/pb/tracking', 'TrackingController@trackConversion');
});