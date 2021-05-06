<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    public function formLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    { //pour se connecter
        $request->validate([
            'login' => 'required|string',
            'mdp' => 'required|string'
        ]);

        $credentials = [
            'login' => $request->input('login'),
            'password' => $request->input('mdp')
        ];
        $u = User::where('login', $request->input('login'))->first();
        if (isset($u->type) && $u->type == null) {
            return back()->withErrors([
                'login' => 'votre compte n est pas encore validé par l administrateur',
            ]);
        }
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $request->session()->flash('etat', 'Login successful');
            return redirect()->intended('/home/auth');
        }

        //il a pas reussi a ce connecter
        return back()->withErrors([
            'login' => 'Erreur survenu sur le login',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('login');
    }
}
