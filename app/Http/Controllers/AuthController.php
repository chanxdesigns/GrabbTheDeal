<?php

namespace App\Http\Controllers;

use App\Custom\Mailer\Mailer;
use App\Token;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;

use App\Http\Requests;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Generator\RandomLibAdapter;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidFactory;
use RandomLib\Factory;

class AuthController extends Controller
{
	/**
	 * Make and Save Token
	 *
	 * @param $id integer
	 * @return Route
	 */
	private function makeAndSaveToken ($id) {

		if (!Token::where('user_id',$id)->first()) {

			// Generate Universally Unique Token string
			$randomLibFactory = new Factory();
			$randomLibGenerator = $randomLibFactory->getLowStrengthGenerator();
			$uuidFactory = new UuidFactory();
			$uuidFactory->setRandomGenerator(new RandomLibAdapter($randomLibGenerator));

			// Initialise and Save Token
			$token = Uuid::uuid4()->toString();

			DB::table('tokens')
				->insert([
					"user_id" => $id,
					"email_token" => $token,
					"created_at" => Carbon::now(),
					"updated_at" => Carbon::now()
				]);

			return route('verifyEmail',['id' => $id, 'token' => $token]);
		} else {
			return route('verifyEmail',['id' => $id, 'token' => Token::select('email_token')->where('user_id',$id)->first()->email_token]);
		}
	}

	/**
	 * E-Mail Token Verification
	 *
	 * Verify token sent to the email
	 *
	 * @param $user_id
	 * @param $token
	 * @return RedirectResponse|string
	 */
	public function verifyEmail ($user_id, $token) {
		// Check for user availability
		$tokenData = DB::table('tokens')
			->where('user_id', $user_id)
			->where('email_token', $token)
			->first();

		if (!is_null($tokenData)) {
			DB::table('users')
				->where('user_id', $user_id)
				->update([
					"validated" => true
				]);

			echo "Thanks for verifying";
			return redirect()->to('/');
		}
		else {
			return 'Token Not Valid';
		}
	}

	public function loginPage() {
		return view('pages.login.login');
	}

	public function registerPage () {
		return view('pages.register.register');
	}

    /**
	 *
	 * Login Logic
	 *
	 * Implements all login logic
	 *
	 * @param $request Request
	 * @return string json
	 */
	public function doLogin (Request $request) {
		// Check for user availability
		$query = DB::table('users')
			->where('email',$request->input('email'))
			->first();

		if(!is_null($query) && Hash::check($request->input('password'), $query->password))
		{
			$user = $query;

			// JSON: 201 Created
			return response()->json('Successfully Created',201)
				->cookie('user_id',$user->user_id,1440,null,null,null,false)
				->cookie('user_name',$user->full_name,1440,null,null,null,false)
				->cookie('email',urlencode($user->email),1440,null,null,null,false);
		}
		return response()->json('Login Failed', 401);
	}

	/**
	 *
	 * Register Method
	 *
	 * Implements all registration logic
	 * Token generation and email sending
	 *
	 * @param $request Request
	 * @return string json
	 */
	public function doRegister (Request $request) {
		// Check if e-mail present in database
		if (!User::where('email',$request->input('email'))->first())
		{
			// Generate Unique User ID
			$uuidFac = new UuidFactory();
			$uuidFac->setRandomGenerator(new RandomLibAdapter());
			Uuid::setFactory($uuidFac);

			// Unique User ID
			$uniqueid = Uuid::uuid4()->toString();

			// User Model
			$user = new User();
			$user->user_id = $uniqueid;
			$user->full_name = $request->input('full_name');
			$user->email = $request->input('email');
			$user->validated = false;
			$user->password = bcrypt($request->input('password'));
			$user->sub_id = str_random(15);
			$user->save();

			// Users Account Info Model
			DB::table('users_account_info')
				->insert([
					"user_id" => $uniqueid,
					"available_balance" => 0,
					"pending_balance" => 150,
					"referral_code" => str_random(10)
				]);

			// Update Bonus Activity
			DB::table('users_bonus')
			->insert([
				"user_id" => $uniqueid,
				"bonus_amount" => 150,
				"bonus_type" => "Registration",
				"status" => "completed",
				"created_at" => Carbon::now(),
				"updated_at" => Carbon::now()
			]);

			// Make Token Link
			$token_link = $this->makeAndSaveToken($uniqueid);
			$mail_view = view('email.verify')->with(['name' => $user->full_name, 'token_link' => $token_link]);
			$data = array(
				'from'    =>  env('APP_NAME').' '.'<verify@grabbthedeal.in>',
				'to' => $user->email,
				'subject' => 'Verify Your Email Now',
				'html' => $mail_view
			);

			// Send account verification mail
			Mailer::sendMessage($data);

			// JSON: 201 Created
			return response()->json('Successfully Created',201)
				->cookie('user_id',$uniqueid,1440,null,null,null,false)
				->cookie('user_name',$user->full_name,1440,null,null,null,false)
				->cookie('email',urlencode($user->email),1440,null,null,null,false);
		}
		else {
			return response()->json("E-mail already registered",403);
		}
	}

	/**
	 * Logout Method
	 *
	 * Clears the session
	 * Reload the page
	 *
	 * @param Request $request
	 * @return RedirectResponse
	 */
	public function doLogout (Request $request) {
		return redirect()->back()
			->cookie('user_id','')
			->cookie('user_name','')
			->cookie('email','');
	}
}
