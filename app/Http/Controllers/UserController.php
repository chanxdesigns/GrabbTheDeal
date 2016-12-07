<?php

namespace App\Http\Controllers;

use App\Custom\Mailer\Mailer;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Requests;
use Psy\Util\Json;

class UserController extends Controller
{
    /**-------------------------------------------------------------
	 * User Base Controller
	 *
	 * Contains user related functions
	 *
	 * [[Transactions, Withdrawals,
	 *   Bank Account Details,
	 * 	 User Activity
	 * ]]
	 *------------------------------------------------------------*/

	/**
	 * UserController constructor.
	 *
	 * Check for user authentication
	 * @param Request $request
	 * @return void
	 */
	
	public function __construct(Request $request) {
		//$this->middleware('auth');
	}

	/**
	 * Get Account Details
	 * @param Request $request
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */

	public function getDashboard ($id) {
		$user = User::join('users_account_info','users.user_id','=','users_account_info.user_id')
			->where('users.user_id',$id)
			->firstOrFail();

		$activities = DB::table('users_activities')
			->where('user_id',$id)
			->orderBy('id','desc')
			->take(5)
			->get();

		$bonuses = DB::table('users_bonus')
			->where('user_id',$id)
			->orderBy('id','desc')
			->take(5)
			->get();

		$withdrawals = DB::table('users_withdrawals')
			->where('user_id',$id)
			->orderBy('id','desc')
			->take(5)
			->get();

		$referrals = DB::table('users_referrals')
			->where('user_id',$id)
			->orderBy('id','desc')
			->take(5)
			->get();

		return view('pages.account.myaccount', compact('user','activities','bonuses','withdrawals','referrals'));
	}

	/**
	 * Get User Activities
	 * Shopping activities
	 *
	 * @param $id
	 * @return $this
	 */
	public function getActivity ($id) {
		$activities = DB::table('users_activities')
			->where('user_id',$id)
			->orderBy('id','desc')
			->simplePaginate(20);

		return view('pages.account.partials.activitypartial')->with('activities',$activities);
	}

	/**
	 * Get User Received Bonus
	 *
	 * Get all user received bonuses that includes
	 * registration, referral bonus and extra bonus
	 *
	 * @param $id
	 * @return $this
	 */
	public function getBonus ($id) {
		$bonuses = DB::table('users_bonus')
			->where('user_id',$id)
			->orderBy('id','desc')
			->simplePaginate(20);

		return view('pages.account.partials.bonuspartial')->with('bonuses',$bonuses);
	}

	/**
	 * Get Withdrawals Lists
	 *
	 * @param $id
	 * @return $this
	 */
	public function getWithdrawals ($id) {
		$withdrawals = DB::table('users_withdrawals')
			->where('user_id',$id)
			->orderBy('id','desc')
			->simplePaginate(20);

		return view('pages.account.partials.withdrawalpartial')->with('withdrawals', $withdrawals);
	}

	/**
	 * Get Referred Users Lists
	 *
	 * @param $id
	 * @return $this
	 */
	public function getReferrals ($id) {
		$referrals = DB::table('users_referrals')
			->where('user_id',$id)
			->orderBy('id','desc')
			->simplePaginate(20);

		return view('pages.account.partials.referralpartial')->with('referrals',$referrals);
	}

	/**
	 * Get Profile Details
	 *
	 * @param $id
	 * @return array
	 */
	public function getProfileDetails ($id) {
		$user = User::find($id);

		return array(
			'full_name' => $user->full_name,
			'email' => $user->email,
			'phone' => $user->phone_number,
			'gender' => $user->gender
		);
	}

	/**
	 * Update Profile Details
	 *
	 * @param $id
	 * @param Request $request
	 */
	public function updateProfileDetails ($id, Request $request) {
		$user = User::find($id);

		$user->full_name = $request->input('name');
		$user->phone_number = $request->input('phone');
		$user->gender = $request->input('gender');

		$user->save();
	}

	/**
	 * Get Payment Method Details
	 *
	 * Bank transfers and other methods of transfer
	 *
	 * @param $id
	 * @return array
	 */
	public function getPaymentDetails ($id) {
		$data = DB::table('users_account_info')
			->where('users_account_info.user_id',$id)
			->first();

		return array(
			'bank_account_name' => $data->bank_account_name,
			'bank_account_number' => $data->bank_account_number,
			'bank_name' => $data->bank_name,
			'bank_ifsc_code' => $data->bank_ifsc_code,
			'bank_address' => $data->bank_address
		);
	}

	/**
	 * Send Withdrawal Requests
	 *
	 * @param $id
	 * @param Request $request
	 *
	 * @return Json
	 */
	public function sendWithdrawalRequest ($id, Request $request) {
		$user = User::join('users_account_info','users.user_id','=','users_account_info.user_id')
			->find($id);

		if ((int)$request->input('withdrawal-amount') <= $user->available_balance) {
			// Update the available balance
			DB::table('users_account_info')
				->where('user_id',$id)
				->update([
					"available_balance" => $user->available_balance - (int)$request->input('withdrawal-amount')
				]);

			// Insert withdrawal details to withdrawals table
			$insertId = DB::table('users_withdrawals')
				->insertGetId([
					'user_id' => $id,
					'withdrawal_channel' => $request->input('withdrawal-channel'),
					'amount' => $request->input('withdrawal-amount'),
					'bank_reference_number' => null,
					'status' => 'pending',
					'created_at' => Carbon::now(),
					'updated_at' => Carbon::now()
				]);

			// Send a notification email
			$mailer_view = view('email.withdrawal',[
				'withdrawal_id' => $insertId,
				'user_name' => $user->full_name,
				'user_email' => $user->email,
				'withdrawal_channel' => $request->input('withdrawal-channel'),
				'withdrawal_amount' => $request->input('withdrawal-amount'),
				'bank_account_name' => $user->bank_account_name,
				'bank_account_number' => $user->bank_account_number,
				'bank_name' => $user->bank_name,
				'bank_ifsc' => $user->bank_ifsc_code,
				'bank_address' => $user->bank_address
			]);

			$data = array(
				'from' => $user->full_name.' '. '<'.$user->email.'>',
				'to' => 'chppal50@gmail.com',
				'subject' => 'Withdrawal ID: #'.$insertId.' New Withdrawal Request Amnt Rs. '.$request->input('withdrawal-amount'),
				'html' => $mailer_view
			);

			Mailer::sendMessage($data);

			return response()->json("Successful", 200);
		}
		else {
			return response()->json("Withdrawal amount greater than available amount", 400);
		}
	}

	// public function referrals (Request $request) {
	// 	if ($request->method() === "GET") {
	// 		$referrals = DB::table('users_referrals')
	//			->where('id')
	//	}
	// }

	/**
	 * Update Payment Method Details
	 *
	 * Updates your payment method details including
	 * bank transfers, amazon gift cards or other
	 * mode of payment .etc.
	 *
	 * @param $id
	 * @param Request $request
	 *
	 * @return void
	 */
	public function updatePaymentDetails ($id, Request $request) {
		DB::table('users_account_info')
			->where('users_account_info.user_id',$id)
			->update([
				'bank_account_name' => $request->input('bank-account-name'),
				'bank_account_number' => $request->input('bank-account-number'),
				'bank_name' => $request->input('bank-name'),
				'bank_ifsc_code' => $request->input('bank-ifsc'),
				'bank_address' => $request->input('bank-address'),
				'updated_at' => Carbon::now()
			]);
	}

	/**
	 * Help/Support Requester
	 *
	 * For any account & site related help/support
	 *
	 * @param $id
	 * @param Request $request
	 */
	public function requestSupport ($id, Request $request) {
		$mail_view = view('email.support', ['support_id' => $request->input('support-ticket'), 'support_cat' => $request->input('support-category'), 'support_msg' => $request->input('support-query')]);
		$data = array(
			'from'    =>  User::select('full_name')->where('user_id',$id)->first()->full_name .' '. '<'.User::select('email')->where('user_id',$id)->first()->email.'>',
			'to' => 'chppal50@gmail.com',
			'subject' => 'New Help Request, Support ID: '.$request->input('support-ticket'),
			'html' => $mail_view
		);

		Mailer::sendMessage($data);
	}
	
}
