<?php

namespace App\Http\Controllers;

use App\Models\Formation;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class RegisterUserController extends Controller
{
    //Enregistrement d'un pprof
    public function registerForm_prof()
    {
        return view('auth.register_prof');
    }

    public function register_prof(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:40',
            'prenom' => 'required|string|max:40',
            'login' => 'required|string|max:30|unique:users',
            'mdp' => 'required|string|confirmed|min:6|max:60'
        ]);

        $user = new User();
        $user->nom = $request->input('nom');
        $user->prenom = $request->input('prenom');
        $user->login = $request->input('login');
        $user->mdp = Hash::make($request->input('mdp'));
        $user->type = null;

        $user->save();
        $request->session()->flash('etat', 'Demande d ajout éfectuée');


        return redirect()->route('main');
    }
    //Enregstrement d'un etudiant
    public function registerForm_etu()
    {
        $form = Formation::all();
        return view('auth.register_etu', ['formations' => $form]);
    }

    public function register_etu(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:40',
            'prenom' => 'required|string|max:40',
            'login' => 'required|string|max:30|unique:users',
            'mdp' => 'required|string|confirmed|min:6|max:60',
            'formation' => 'required'
        ]);

        $user = new User();
        $user->nom = $request->input('nom');
        $user->prenom = $request->input('prenom');
        $user->login = $request->input('login');
        $user->mdp = Hash::make($request->input('mdp'));
        $user->formation_id = intval($request->formation);
        $user->type = null;

        $user->save();
        $request->session()->flash('etat', 'Demande d ajout éfectuée');


        return redirect()->route('main');
    }
}
