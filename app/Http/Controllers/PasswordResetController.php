<?php

namespace App\Http\Controllers;

use App\Custom\Mailer\Mailer;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Generator\RandomLibAdapter;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidFactory;

class PasswordResetController extends Controller
{
    public function getResetPage () {
        return view('pages.reset.password');
    }

    public function doPasswordReset (Request $request) {
       if ($request->input('password-reset-email')) {
           // Check for user presence
           $user = DB::table('users')
               ->where('email',$request->input('password-reset-email'))
               ->first();

           if (!is_null($user)) {
               // Generate Unique User ID
               $uuidFac = new UuidFactory();
               $uuidFac->setRandomGenerator(new RandomLibAdapter());
               Uuid::setFactory($uuidFac);

               // Token string
               $tokenString = Uuid::uuid4()->toString();

               // Check for token usage
               $token = DB::table('tokens')
                   ->where('user_id',$user->user_id)
                   ->first();

               if (is_null($token->password_reset_token)) {
                    DB::table('tokens')
                        ->where('user_id',$user->user_id)
                        ->update([
                            'password_reset_token' => $tokenString,
                            'password_reset_status' => false
                        ]);
                   $token_link = url('/password/reset',['user_id' => $user->user_id,'token' => $tokenString]);
               }
               else if ($token->password_reset_status) {
                   DB::table('tokens')
                       ->where('user_id',$user->user_id)
                       ->update([
                           'password_reset_token' => $tokenString,
                           'password_reset_status' => false
                       ]);
                   $token_link = url('/password/reset',['user_id' => $user->user_id,'token' => $tokenString]);
               }
               else {
                   $query = DB::table('tokens')
                       ->select('password_reset_token')
                       ->where('user_id',$user->user_id)
                       ->first();
                   $token_link = url('/password/reset',['user_id' => $user->user_id,'token' => $query->password_reset_token]);
               }

               // Prepare Mail View
               $mail_view = view('email.reset')->with('token_link', $token_link);
               $data = array(
                   'from'    =>  env('APP_NAME').' '.'<verify@grabbthedeal.in>',
                   'to' => $user->email,
                   'subject' => 'Reset Password Link - Grabb The Deal',
                   'html' => $mail_view
               );
               // Send Mail
               Mailer::sendMessage($data);
               return response()->json('Successful',200);
           }
           else {
               return response()->json('Email not exists', 404);
           }
       }
    }

    public function verifyPasswordResetToken ($id,$token) {
        $token = DB::table('tokens')
            ->where('user_id',$id)
            ->where('password_reset_token',$token)
            ->first();

        if (!$token->password_reset_status) {
            DB::table('tokens')
                ->where('user_id',$id)
                ->update([
                    "password_reset_status" => true
                ]);
            return view('pages.reset.newpassword')->with('user_id',$id);
        }
        else {
            return response()->json('Token already used. Reuse the Forget Password field', 401);
        }
    }

    public function generateNewPassword (Request $request) {
        $query = DB::table('users')
            ->where('user_id', $request->input('user_id'))
            ->update([
               'password' => bcrypt($request->input('new-password'))
            ]);

        if ($query) {
            return response()->json('Password successfully reset', 200);
        }
        else {
            return response()->json('Internal server error', 500);
        }
    }
}
