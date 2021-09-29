<?php
 
namespace App\Http\Controllers\Auth;
 
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;

 
/**
 * Class LoginController
 * @package App\Http\Controllers\Auth
 */
class LoginController extends Controller
{
    /**
     * @param LoginUserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginUserRequest $request)
    {
        if (Auth::attempt($request->validated())) {
            $token = Auth::user()->createToken('api');
            $url_singed = URL::temporarySignedRoute(
                'unsubscribe', now()->addMinutes(0.5), ['user' => 1]
            );

            $uuid = Db::table('users')->where('email', $request->input('email'))->value('uuid');
            // $req = $request->email;
            return response()->json([
                'token' => $token->plainTextToken,
                'URL' => $url_singed,
                'uuid' => $uuid,
            ]);
        }
 
        return response()->json(['the user not found']);
    }
}
