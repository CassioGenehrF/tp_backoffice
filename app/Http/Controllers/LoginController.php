<?php

namespace App\Http\Controllers;

use App\Helpers\WordpressAuthenticator;
use App\Http\Requests\Login\LoginRequest;
use App\Http\Requests\Login\LogoutRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return view('login');
        } else {
            $user = Auth::user();
            
            if ($user->role == 'contributor') {
                return redirect('/broker');
            } else if ($user->role == 'editor') {
                return redirect('/owner');
            } else if ($user->role == 'administrator') {
                return redirect('/admin');
            }
        }
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
            
            if ($user->role == 'contributor') {
                return redirect('/broker');
            } else if ($user->role == 'editor') {
                return redirect('/owner');
            } else if ($user->role == 'administrator') {
                return redirect('/admin');
            }

            // TODO: redirect para "permission not found", algo do genero
            return redirect('/user');
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
