<?php

namespace App\Http\Controllers;

use App\Custom\Mailer\Mailer;
use Illuminate\Http\Request;

use App\Http\Requests;

class ContactController extends Controller
{
    public function getContactForm () {
        return view('pages.contact');
    }

    public function sendContactData (Request $request) {
        if (!empty($request->input())) {
            $contact_data = array(
                "email" => $request->input('email'),
                "name" => $request->input('name'),
                "subject" => $request->input('subject'),
                "contact_msg" => $request->input('message')
            );

            $mail_view = view('email.contact',$contact_data);

            $data = array(
                'from'    =>  $request->input('name').' '.'<'.$request->input('email').'>',
                'to' => 'chppal50@gmail.com',
                'subject' => 'New Contact Form Request From - '.$request->input('email'),
                'html' => $mail_view
            );

            Mailer::sendMessage($data);

            return response()->json('Successfully sent', 200);
        }
        else {
            return response()->json('Empty Form. Please write something.', 400);
        }
    }
}
