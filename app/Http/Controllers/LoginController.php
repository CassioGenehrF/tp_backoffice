<?php

namespace App\Http\Controllers;

use App\Helpers\WordpressAuthenticator;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\LogoutRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function auth(LoginRequest $request)
    {
        $credentials = $request->only(['user_login', 'password']);

        $user = User::query()
            ->where('user_login', $credentials['user_login'])
            ->first();

        if (!$user) {
            return back()->withErrors([
                'username' => 'O login e/ou senha informados estão incorretos.',
            ]);
        }

        $wp_auth = new WordpressAuthenticator();

        if ($wp_auth->checkPassword($credentials['password'], $user->user_pass)) {
            Auth::login($user);
            $request->session()->regenerate();

            return redirect('/owner');
        }

        return back()->withErrors([
            'username' => 'O login e/ou senha informados estão incorretos.',
        ]);
    }

    public function logout(LogoutRequest $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
