<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmailLogin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;


class AuthController extends Controller
{
    protected function validator(array $data)
    {
    return Validator::make($data, [
        'name' => 'required|max:255',
        'email' => 'required|email|max:255|unique:users',
    ]);
    }



    protected function create(array $data)
    {
    return User::create([
        'name' => $data['name'],
        'email' => $data['email'],
    ]);
    }


    public function login(Request $request) {

        $this->validate($request, ['email' => 'required|email|exists:users']);
        $emailLogin = EmailLogin::createForEmail($request->input('email'));

        $url = route('auth.email-authenticate', [
            'token' => $emailLogin->token
        ]);

        Mail::send( 'email',['url' => $url], function ($m) use ($request) {
            $m->from('alnosila.abd@gmail.com', 'MyApp');
            $m->to($request->input('email'))->subject('MyApp Login');
        });

        return response()->json(['url' => $url]);
    }


    public function authenticateEmail($token)
    {
        $emailLogin = EmailLogin::validFromToken($token);

        Auth::login($emailLogin->user);

        return redirect('home');
    

    
    }
}
