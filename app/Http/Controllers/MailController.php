<?php

namespace App\Http\Controllers;

use App\Mail\MailModel;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Symfony\Component\Mailer\Exception\TransportException;

class MailController extends Controller
{
    function send(Request $request) {
        $missing = [];
        $required = [
            'MAIL_MAILER',
            'MAIL_HOST',
            'MAIL_PORT',
            'MAIL_USERNAME',
            'MAIL_PASSWORD',
            'MAIL_FROM_ADDRESS',
            'MAIL_FROM_NAME',
        ];

        foreach ($required as $var) {
            if (empty(env($var))) {
                $missing[] = $var;
            }
        }

        if (!empty($missing)) {
            return redirect()->back()->withErrors('Environment variables missing: ' . implode(', ', $missing));
        }

        $request->validate([
            'username_or_email' => 'required',
        ]);

        $usernameOrEmail = $request->username_or_email;

        if (str_contains($usernameOrEmail, '@')) {
            $email = $usernameOrEmail;
            $user = User::where('email', $email)->first();
            if (!$user) {
                return redirect()->back()->withErrors('The provided email does not match our records.');
            }
            $username = $user->username;
        } else {
            $username = $usernameOrEmail;
            $user = User::where('username', $username)->first();
            if (!$user) {
                return redirect()->back()->withErrors('The provided username does not match our records');
            }
            $email = $user->email;
        }

        $token = Str::random(40);
        $user->password = Hash::make($token);
        $user->save();

        $link = env('APP_URL') . "/password/$username/$token";

        $data = [
            'username' => $username,
            'link' => $link,
        ];

        try {
            Mail::to($email)->send(new MailModel($data));
            return redirect()->back()->with('success', "$username, check your email inbox ($email)");
        } catch (TransportException $e) {
            return redirect()->back()->withErrors('SMTP connection error');
        } catch (Exception $e) {
            return redirect()->back()->withErrors('Unknown error');
        }
    }
}
