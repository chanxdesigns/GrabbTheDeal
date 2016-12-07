<?php

namespace App\Http\Controllers;

use App\Custom\Mailer\Mailer;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;

class TrackingController extends Controller
{
    private $offer_id;
    private $source;
    private $payout;
    private $transaction_id;
    private $aff_sub;
    private $aff_sub_2;
    private $aff_sub_3;
    private $aff_sub_4;
    private $aff_sub_5;

    /**
     * Aff_Sub = User ID
     */

    public function __construct () {
        if (!empty($_GET)) {
            // Get Offer ID
            if (!empty($_GET['offer_id']))
                $this->offer_id = $_GET['offer_id'];

            // Get Source Name
            if (!empty($_GET['source']))
                $this->source = $_GET['source'];

            // Get Payout Amount
            if (!empty($_GET['payout']))
                $this->payout = $_GET['payout'];

            // Get Transaction ID
            if (!empty($_GET['transaction_id']))
                $this->transaction_id = $_GET['transaction_id'];

            // Get User ID
            if (!empty($_GET['aff_sub']))
                $this->aff_sub = $_GET['aff_sub'];

            // Get Store ID
            if (!empty($_GET['aff_sub2']))
                $this->aff_sub_2 = $_GET['aff_sub2'];

            if (!empty($_GET['aff_sub3']))
                $this->aff_sub_3 = $_GET['aff_sub3'];

            if (!empty($_GET['aff_sub4']))
                $this->aff_sub_4 = $_GET['aff_sub4'];

            if (!empty($_GET['aff_sub5']))
                $this->aff_sub_5 = $_GET['aff_sub5'];
        }
        else {
            return response()->json('No query string found');
        }
    }

    public function trackConversion () {
        if (!is_null($this->aff_sub)) {
            $created_time = Carbon::now();
            $updated_time = $created_time;

            // Insert into Tracking DB
            try {
                DB::table('tracking')
                    ->insert([
                        "offer_id" => $this->offer_id,
                        "source" => $this->source,
                        "payout" => $this->payout,
                        "transaction_id" => $this->transaction_id,
                        "aff_sub_1" => $this->aff_sub,
                        "aff_sub_2" => $this->aff_sub_2,
                        "aff_sub_3" => $this->aff_sub_3,
                        "aff_sub_4" => $this->aff_sub_4,
                        "aff_sub_5" => $this->aff_sub_5,
                        "created_at" => $created_time,
                        "updated_at" => $updated_time
                    ]);
            }
            catch (\Exception $e) {
                dd($e);
            }

            // Get Store Name
            $store_name = DB::table('stores')
                ->select('store_name')
                ->where('store_id', $this->aff_sub_2)
                ->first();

            // Get User Details
            $user = DB::table('users')
                ->select('*')
                ->where('user_id', $this->aff_sub)
                ->first();

            // Insert Into User Activities
            try {
                DB::table('users_activities')
                    ->insert([
                        "user_id" => $this->aff_sub,
                        "merchant_name" => $store_name->store_name,
                        "estimated_cashback" => floor($this->payout),
                        "transaction_id" => $this->transaction_id,
                        "status" => "Pending",
                        "created_at" => $created_time,
                        "updated_at" => $updated_time
                    ]);
            }
            catch (\Exception $e) {
                dd($e);
            }

            // Increase Pending User Balance
            try {
                $pd_cb = DB::table('users_account_info')
                    ->select('pending_balance')
                    ->where('user_id',$this->aff_sub)
                    ->first();
                $pd_cb = floor($this->payout) + $pd_cb->pending_balance;
                DB::table('users_account_info')
                    ->where('user_id', $this->aff_sub)
                    ->update([
                        "pending_balance" => $pd_cb
                    ]);
            }
            catch (\Exception $e) {
                dd($e);
            }

            $mail_view = view('email.conversionNotification')
                ->with([
                    'name' => $user->full_name,
                    'store_name' => $store_name->store_name,
                    'date' => $created_time->toDateString(),
                    'cashback' => floor($this->payout)
                ]);

            $data = array(
                'from' => env('APP_NAME') . ' ' . '<auto-order-confirm@grabbthedeal.in>',
                'to' => $user->email,
                'subject' => 'Order Update: #'.$this->transaction_id.' On '.$store_name->store_name,
                'html' => $mail_view
            );

            Mailer::sendMessage($data);

            return response()->json('Success',200);
        }
        else {
            return response()->json('No Sub ID Found',404);
        }
    }
}
