<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Cours;
use App\Models\User;
use App\Models\Formation;
use App\Models\Planning;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    //Modification du mot de passe

    public function modifierMdpForm()
    {
        return view('user.new_password');
    }
    public function modifierMdp(Request $request)
    {
        $validated = $request->validate([
            'old_mdp' => 'required|string|max:60',
            'mdp' => 'required|string|max:60|confirmed'
        ]);
        $mdp_ = AUTH::User()->mdp;

        if (Hash::check($validated['old_mdp'], $mdp_)) {
            $user_id = Auth::User()->id;
            $user = User::findOrFail($user_id);
            $user->mdp = Hash::make($validated['mdp']);
            $user->save();
            $request->session()->flash('etat', 'Modification effectuée');
            return redirect()->route('home');
        }

        $request->session()->flash('etat', 'erreur dans votre saisi, veuillez reesayer');
        return redirect()->route('user.modifier_mdp');
    }
    public function EditNomForm()
    {
        return view('auth.edit_nom');
    }

    /**
     * Modification du nom 
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function EditNom(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:30',
            'prenom' => 'required|string|max:30',

        ]);
        $u = Auth::id();
        $pi = User::find($u);

        $pi->nom = $request->nom;
        $pi->prenom = $request->prenom;
        $pi->save();
        $request->session()->flash('etat', 'Nom/Prénom mis à jour');

        return redirect()->route('home');
    }

    //validation du compte prof de la part de l'admin

    function Validate_Compte_prof_list()
    {

        $profs = User::where('type', null)->where('formation_id', null)->get();
        $etudiants = User::where('type', null)->where('formation_id', '!=', null)->get();
        return view('auth.admin.validate')->with('liste_prof', $profs)->with('liste_etudiant', $etudiants);
    }

    public function Validate_compte_prof(Request $request)
    {
        $us = User::findOrFail($request->ut_id);
        $us->type = 'enseignant';
        $us->save();
        $request->session()->flash('etat', 'Compte validé');

        return redirect()->route('home.admin');
    }
    public function Validate_compte_etudiant(Request $request)
    {
        $us = User::findOrFail($request->ut_id);
        $us->type = 'etudiant';
        $us->save();
        $request->session()->flash('etat', 'Compte validé');

        return redirect()->route('home.admin');
        //refuser une demande de création
    }
    public function Supprimer_compte_prof(Request $request)
    {
        $us = User::findOrFail($request->ut_id);
        $us->delete();
        $request->session()->flash('etat', 'Compte refusé');

        return redirect()->route('home.admin');
    }
    //liste des profs
    public function prof_list()
    {
        $profs = User::where('type', '!=', null)->where('formation_id', null)->get();
        $courss = Cours::all();
        return view('auth.admin.associate')->with('liste_prof', $profs)->with('cours', $courss);
    }
    //associer une formation a un prof
    public function Associer_formation_prof(Request $request)
    {
        $us = User::findOrFail($request->prof_id);

        $cr = Cours::findOrFail($request->cours_id);


        $cr->user_id = $us->id;

        $cr->save();


        $request->session()->flash('etat', 'Cours associé');

        return redirect()->route('home.admin');
    }
    //liste de tout les cours
    public function cours_list()
    {
        $courss = Cours::all();
        $formations = Formation::all();
        $profs = User::where('formation_id', null)->get();
        return view('cours.liste')->with('liste_cours', $courss)->with('formations', $formations)->with('profs', $profs);
    }
    //création d'un cours
    public function cours_form()
    {
        $profs = User::where('type', '!=', null)->where('formation_id', null)->get();
        $formation = Formation::all();

        return view('cours.create_form')->with('liste_prof', $profs)->with('formations', $formation);;
    }

    public function cours_create(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|min:2|max:40',
            'formation' => 'required',
            'user' => 'required',
        ]);

        $cour = new Cours();
        $cour->intitule = $request->nom;
        $cour->user_id = $request->user;
        $cour->formation_id = intval($request->formation);

        $cour->save();
        $request->session()->flash('etat', 'Cours crée');
        return redirect()->route('home.admin');
    }
    //liste des formations
    public function formation_list()
    {
        $formation = Formation::all();
        return view('formation.liste')->with('liste_formation', $formation);
    }
    //ajouter une formation
    public function ajout_formation_form()
    {
        return view('formation.ajout');
    }
    public function ajout_formation(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|min:5|max:40',
        ]);
        $format = new Formation();
        $format->intitule = $request->nom;
        $format->save();
        $request->session()->flash('etat', 'Formation crée');
        return redirect()->route('home.admin');
    }
    public function liste_cours_formation()
    {
        $user = User::where('id', auth()->user()->id)->first();
        if ($user->formation == null) {
            return back()->withErrors('Votre formation a été supprimée,Vous pourriez juste modifier vos informations dans l attente de la remettre');
        }
        return view('formation.liste_cours')->with('user', $user);
    }
    //liste des cours d'un porf
    public function liste_cours_prof()
    {
        $u = auth()->user()->id;
        $cours = Cours::where('user_id', "=", "$u")->get();
        return view('formation.liste_cours_res')->with('cours', $cours);
    }

    public function liste_cours_ens_form()
    {
        $profs = User::where('type', '!=', null)->where('formation_id', null)->get();

        return view('cours.liste_par_prof')->with('profs', $profs);
    }

    public function liste_cours_ens(Request $request)
    {
        $request->validate([
            'prof' => 'required',
        ]);
        $prof = User::where('id', $request->prof)->first();

        $cours = $prof->cours()->get();
        $profs = User::where('type', '!=', null)->where('formation_id', null)->get();
        $formation = Formation::all();

        return view('cours.liste')->with('liste_cours', $cours)->with('formations', $formation)->with('profs', $profs);
    }
    //modifier une formation
    public function modifier_formation_ens(Request $request)
    {
        $request->validate([
            'intitule' => 'required|string',
        ]);

        $formation = Formation::where('id', $request->formation)->first();
        $formation->intitule = $request->intitule;
        $formation->save();
        $request->session()->flash('etat', 'Formation modifiée');
        return redirect()->route('formation.liste');
    }
    //supprimer une formation
    public function supprimer_formation_admin(Request $request)
    {
        //pour supprimer une formation,il faut supprimer tout ses utilisateur ainsi 
        //que les relations de ses utilisateurs et aussi les planning
        //on peut garder le cours pour l'affecter a une autre dormation,suffir donc de mettre le champs formation_id a null
        $formation = Formation::where('id', $request->formation)->first();
     
         $users=User::where('formation_id', $request->formation)->get();
         foreach($users as $u){
         $cours = $u->cours()->get();
         foreach ($cours as $cour) {
             $plannings = Planning::where('cours_id', $cour->id)->get();
          
 
             foreach ($plannings as $planning) {
                 $planning->delete();
             }
             $use = $cour->users;
             foreach ($use as $us) {
                 $us->pivot->delete();
             }
 
             $cour->delete();
         }
         $u->delete();

        }
        $cours = Cours::where('formation_id', $request->formation)->get();

        foreach ($cours as $cour) {


            if($cour->formation_id==$formation->id){
                DB::table('cours_users')->where('cours_id',$cour->id)->delete();
                Planning::where('cours_id', $cour->id)->delete();
                $cour->delete();
                $cour->save();
                
            };
            //dans le cas ou le premier if ne marche,quand un cours a une seance et qu'il n'a pas été 
            //choisi par un etudiant,on se prefera de garder le cours et lui changer de formation(donc formation_id==null)
            $cour->formation_id = NULL;
            $cour->save();
           
        }
        $formation->delete();
        $request->session()->flash('etat', 'Formation supprimée');
        return redirect()->route('formation.liste');
    }
    //créer une séance d'un cours de la part de l'admin

    public function creation_seance_admin_form()
    {
        $prof = User::where('type', '!=', null)->where('formation_id', null)->get();
        return view('cours.create_admin')->with('profs', $prof);
    }

    public function creation_cours_admin_form(Request $request)
    {
        $users = User::where('id', $request->user)->first();
        //    dd($request->user);
        //   dd($users->cours()->get());
        return view('planning.create_cours')->with('user', $users);
    }

    public function creation_seance_admin_form_()
    {
        $prof = User::where('type', '!=', null)->where('formation_id', null)->get();
        return view('cours.par_cours')->with('profs', $prof);
    }
    //liste des utilisateur par integrale
    public function liste_integ()
    {
        $users = User::where('type', '!=', null)->get();
        //  $types=User::all()->groupBy('type')->toArray();
        return view('user.liste')->with('users', $users);
    }
    //liste des utilisateur par type

    public function liste_par_type_form()
    {
        return view('user.liste_type');
    }
    public function liste_par_type(Request $request)
    {
        $users = User::where('type', $request->type)->get();
        return view('user.liste')->with('users', $users);
    }

    public function create_user_liste()
    {
        $types = User::all()->groupBy('type')->toArray();
        return view('user.choice_type')->with('types', $types);
    }
    //Modifier les information d'un utilisateur de la part de l'admin
    public function EditNomForm_admin(Request $request)
    {
        $formation = Formation::all();
        return view('auth.admin.form_edit_name')->with('user', $request->user)->with('formations', $formation);
    }

    public function EditNom_admin(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:30',
            'prenom' => 'required|string|max:30',
            'type' => 'required',

        ]);
        $pi = User::where('id', $request->user)->first();

        $pi->nom = $request->nom;
        $pi->prenom = $request->prenom;
        if ($request->type == 'etudiant' && $request->formation == null) {
            return back()->withErrors('Vous devez choisir une formation pour un etudiant');
        };
        if ($request->type != 'etudiant' && $request->formation != null) {
            return back()->withErrors('Vous ne devez pas choisir une formation(pas de formatio) pour un admin ou un enseignant');
        };


        $pi->formation_id = $request->formation;

        if ($request->type != 'etudiant') {
            $pi->formation_id = null;
        }
        $pi->type = $request->type;

        $pi->save();
        $request->session()->flash('etat', 'Utilisateur mis à jour');

        return redirect()->route('home.admin');
    }
    //supprimer un utilisateur de la part de l'admin
    public function delet_admin(Request $request)
    {
        $u = User::find($request->user);
        $cours = $u->cours()->get();
        foreach ($cours as $cour) {
            $plannings = Planning::where('cours_id', $cour->id)->get();
         

            foreach ($plannings as $planning) {
                $planning->delete();
            }
            $use = $cour->users;
            foreach ($use as $us) {
                $us->pivot->delete();
            }

            $cour->delete();
        }
        $u->delete();
        $request->session()->flash('etat', 'Utilisateur supprimé');
        return redirect()->route('home.admin');
    }

    //filtrer les utilisateurs par nom,prenom,login
    public function recherche_nom_login_form()
    {
        return view('user.recherche_nom_login');
    }
    public function recherche_nom_login(Request $request)
    {
        $request->validate([
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'login' => 'required|string',
        ]);
        $user = User::where('nom', $request->nom)->where('prenom', $request->prenom)->where('login', $request->login)->first();
        if ($user == null) {
            return back()->withErrors('Utilisateure n existe pas');
        }
        return view('user.liste_one')->with('user', $user);
    }
    //création d'un utilisateur de la part de l'admin'
    public function create_user_compte_form()
    {
        $formation = Formation::all();
        return view('auth.admin.create_users')->with('formations', $formation);
    }
    public function create_user_compte(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:40',
            'prenom' => 'required|string|max:40',
            'login' => 'required|string|max:30|unique:users',
            'type' => 'required|string|max:30|',
            'mdp' => 'required|string|confirmed|min:6|max:60',
        ]);
        if (($request->type == 'enseignant' && $request->formation != null) || ($request->type == 'etudiant' && $request->formation == null)) {
            return back()->withErrors('Une formation est requise pour un etudiant et ne doit pas etre  choisie (Pas de formation) pour un prof   ');
        }

        $user = new User();
        $user->nom = $request->input('nom');
        $user->prenom = $request->input('prenom');
        $user->login = $request->input('login');
        $user->mdp = Hash::make($request->input('mdp'));
        if ($request->type != 'enseignant') {
            $user->formation_id = intval($request->formation);
        }
        $user->type = $request->input('type');

        $user->save();
        $request->session()->flash('etat', 'Utilisateur crée avec succès');


        return redirect()->route('home.admin');
    }
}
