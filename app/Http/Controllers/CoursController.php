<?php

namespace App\Http\Controllers;

use App\Models\Cours;
use App\Models\Planning;
use App\Models\User;
use App\Models\Formation;
use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CoursController extends Controller
{
    // formulaire inscription etudiant
    public function inscr_etud_form()
    {
        $user = User::where('id', auth()->user()->id)->first();
        $form = Formation::where('id', $user->formation_id)->first();
        $courss = $form->cours;
        return view('cours.inscr_etud')->with('les_cours', $courss);
    }
    //inscription etudiant
    public function inscr_etud(Request $request)
    {
        $u = auth()->user()->id;
        $user = User::where('id', '=', $u)->first();
        $cours = $request->courss;
        $user->cours()->attach($cours);
        $request->session()->flash('etat', 'Cours ajouté');
        return redirect()->route('home.user');
    }
    // formulaire pour supprimer un cours etudiant
    public function supp_etud_form()
    {
        $u = auth()->user()->id;
        $user = User::where('id', '=', $u)->first();
        $courss = $user->cours()->get();
        return view('cours.inscr_etud')->with('les_cours', $courss);
    }
    // suprimer un cours inscris
    public function sup_etud(Request $request)
    {
        $u = auth()->user()->id;
        $user = User::where('id', '=', $u)->first();
        $cours = $request->courss;
        $user->cours()->detach($cours);
        $request->session()->flash('etat', 'Cours supprimé');
        return redirect()->route('home.user');
    }
    //voir la liste des cours inscris
    public function liste_cours_inscrit()
    {
        $u = auth()->user()->id;
        $user = User::where('id', '=', $u)->first();
        $courss = $user->cours()->get();
        return view('cours.liste_inscris')->with('liste_cours', $courss);
    }
    //formulaire de recherche d'un cours
    public function recherche_cours_form()
    {
        return view('cours.recherche');
    }

    //recherche un cours
    public function recherche_cours(Request $request)
    {
        $request->validate([
            'cours' => 'required|string|max:40',

        ]);
        //le 'LIKE' permet d'effectuer une recherche à partir d'un caract ou string
        //par exemple si on a "cou","cour","avc" -->on recherche "c" le resultat sera "cou","cour"
        $user = User::where('id', auth()->user()->id)->first();
        $form = Formation::where('id', $user->formation_id)->first();
        $courss = Cours::where('intitule', 'LIKE', "%{$request->cours}%")->where('formation_id', "=", $form->id)->get();
        return view('cours.liste_user')->with('liste_cours', $courss);
    }
    //afficher le planing d'un etudiant
    public function planning_cours_etu()
    {
        return view('planning.affiche')->with('cours', auth()->user()->cours);
    }


    //créer une seance de cours
    public function create_seance_form()
    {
        return view('planning.create_cours')->with('user', Auth::user());
    }

    public function create_seance(Request $request)
    {
        $request->validate([
            'cours' => 'required|string|max:40',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date',
        ]);
        $p = new Planning();
        $p->date_debut = $request->date_debut;
        $p->date_fin = $request->date_fin;
        $p->cours_id = $request->cours;
        $p->save();
        $request->session()->flash('etat', 'Crénau crée avec succès');
        return redirect()->route('home');
    }
    //afficher + filtrer par semaine du planning

    public function recherche_cours_planning_form(Request $request)
    {
        $u = User::find(auth()->user()->id);
        if ($query = $request->query()) {
            // Mozilla
            // $weekDate = Carbon::now()->setISODate(Carbon::now()->year, intval($query['week']));
            // Chrome
            preg_match('/W\d+/', $request['week'], $weekMatches);
            preg_match('/\d+\-/', $request['week'], $yearMatches);
            $week = preg_replace('/W/', '', $weekMatches[0]);
            $year = preg_replace('/\-/', '', $yearMatches[0]);
            $weekDate = Carbon::now()->setISODate($year, $week);
            $startOfWeek = $weekDate->startOfWeek()->toDateString();
            $endOfWeek = $weekDate->endOfWeek()->toDateString();

            $courss = $u->cours()->whereHas('plannings', function ($q) use ($startOfWeek, $endOfWeek) {
                $q->whereDate('date_debut', '>=', $startOfWeek)->whereDate('date_fin', '<=', $endOfWeek);
            })->get();
        } else {
            $courss = auth()->user()->cours;
        }


        return view('planning.affiche')->with('cours', $courss);
    }
    //rechercher un planning par cours
    //Utilisation d'une deuxieme vue("affiche_un_cour"[pour toute les operation])
    public function recherche_par_cour_form()
    {
        $u = auth()->user()->id;
        $user = User::where('id', '=', $u)->first();
        $cours = $user->cours()->get();
        return view('cours.inscr_etud')->with('les_cours', $cours);
    }
    public function recherche_par_cour(Request $request)
    {
        $cours = Cours::find($request->courss);
        return view('planning.affiche_un_cours')->with('cour', $cours);
    }


    //mise à jour d'une seance d'un cours
    public function Maj_seance_form_semaine(Request $request)
    {
        $u = auth()->user()->id;

        if ($query = $request->query()) {
            preg_match('/W\d+/', $request['week'], $weekMatches);
            preg_match('/\d+\-/', $request['week'], $yearMatches);
            $week = preg_replace('/W/', '', $weekMatches[0]);
            $year = preg_replace('/\-/', '', $yearMatches[0]);
            $weekDate = Carbon::now()->setISODate($year, $week);
            $startOfWeek = $weekDate->startOfWeek()->toDateString();
            $endOfWeek = $weekDate->endOfWeek()->toDateString();

            $cours = Cours::where('user_id', "=", "$u")->whereHas('plannings', function ($q) use ($startOfWeek, $endOfWeek) {
                $q->whereDate('date_debut', '>=', $startOfWeek)->whereDate('date_fin', '<=', $endOfWeek);
            })->get();
        } else {
            $cours = Cours::where('user_id', "=", "$u")->get();
        }

        return view('planning.affiche_par_cours')->with('cours', $cours);
    }
    public function Maj_seance_semaine(Request $request)
    {

        $request->validate([
            'planning' => 'required',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date',
        ]);

        $planning = Planning::find($request->planning);

        $planning->date_debut = $request->date_debut;
        $planning->date_fin = $request->date_fin;
        $planning->save();

        $request->session()->flash('etat', 'Crénau Mis à jours avec succès');
        return redirect()->route('home');
    }
    //supprimer une séance de cours
    public function sup_seance(Request $request)
    {
        $request->validate([
            'planning' => 'required',


        ]);
        $planning = Planning::find($request->planning);
        $planning->delete();
        $request->session()->flash('etat', 'Crénau supprimé');
        return redirect()->route('home');
    }
    //mise a jours d'une seance de cours
    public function Maj_seance_cour_form()
    {
        $u = auth()->user()->id;
        $les_cours = Cours::where('user_id', "=", "$u")->get();
        return view('planning.affiche_par_cours_')->with('les_cours', $les_cours);
    }

    public function Maj_seance_cour(Request $request)
    {
        // $request ->validate([
        //     'cours'=>'required',
        // ]) raviewh
        $cours = Cours::find($request->cours);
        return view('planning.form_cour_recherche')->with('cours', $cours);
    }
    //recherche un cours 
    public function recherche_cours_admin_from()
    {

        return view('auth.admin.recherche');
    }
    public function recherche_cours_admin(Request $request)
    {

        $request->validate([
            'cours' => 'required|string',
        ]);
        $cours = Cours::where('intitule', '=', $request->cours)->first();
        if ($cours == null) {
            return back()->withErrors('Le cours n existe pas');
        }
        return view('auth.admin.affiche_un_cours')->with('cours', $cours);
    }

    //modification d'un cours

    public function modifier_cours_admin(Request $request)
    {
        // $request->validate([
        //     'cours'=>'required',
        // ])
        $cours = Cours::find($request->cours);
        if ($request->intitule != null) {
            $cours->intitule = $request->intitule;
            $cours->save();
            $request->session()->flash('etat', 'Intitulé modifié');
        }
        if ($request->formation != null) {
            $cours->formation_id = intval($request->formation);
            $cours->save();

            $request->session()->flash('etat', 'Formation modifiée');
        }

        if ($request->prof != null) {
            $cours->user_id = $request->prof;
            $cours->save();
            $request->session()->flash('etat', 'Enseignant modifié');
        }
        $cours->save();
        return redirect()->route('home.admin');
    }
    //suppression d'un cours
    public function supprimer_cours_admin(Request $request)
    {
        //pour supprimer un cours il faut supprimer tout ses planning ainsi detacher touts ses users

        $cours = Cours::find($request->cours);
        $plannings = Planning::where('cours_id', $request->cours)->get();
        $users = $cours->users;
        foreach ($plannings as $planning) {
            $planning->delete();
        }
        foreach ($users as $user) {

            $user->cours()->detach($cours);
        }

        $cours->delete();
        $request->session()->flash('etat', 'Cours supprimé');
        return redirect()->route('cours.liste');
    }

    //mise a jours d'une séance de cours avec filtration par semaine
    public function Maj_seance_form_semaine_admin(Request $request)
    {
        $u = User::where('id', $request->user)->first()->id;
        $query = $request->query();
        if ($query && isset($query['week'])) {
            // Mozilla
            // $weekDate = Carbon::now()->setISODate(Carbon::now()->year, intval($query['week']));
            // Chrome
            preg_match('/W\d+/', $request['week'], $weekMatches);
            preg_match('/\d+\-/', $request['week'], $yearMatches);
            $week = preg_replace('/W/', '', $weekMatches[0]);
            $year = preg_replace('/\-/', '', $yearMatches[0]);
            $weekDate = Carbon::now()->setISODate($year, $week);
            $startOfWeek = $weekDate->startOfWeek()->toDateString();
            $endOfWeek = $weekDate->endOfWeek()->toDateString();
            $cours = Cours::where('user_id', "=", "$u")->whereHas('plannings', function ($q) use ($startOfWeek, $endOfWeek) {
                $q->whereDate('date_debut', '>=', $startOfWeek)->whereDate('date_fin', '<=', $endOfWeek);
            })->get();
        } else {
            $cours = Cours::where('user_id', "=", "$u")->get();
            // dd($cours);
        }

        return view('planning.admin_affiche_par_cours')->with('cours', $cours);
    }
    //Partie mise a jours et modification de la part de l'admin
    public function Maj_seance_cour_form_(Request $request)
    {
        $u = User::where('id', $request->user)->first();
        $les_cours = Cours::where('user_id', "=", "$u->id")->get();
        return view('planning.affiche_par_cours_')->with('les_cours', $les_cours);
    }

    public function plans(Request $request)
    {
        $u = User::where('id', $request->user)->first();
        // dd($u);
        $les_cours = Cours::where('user_id', "=", "$u->id")->get();
        return view('planning.admin_affiche_par_cours')->with('cours', $les_cours);
    }


    public function cours(Request $request)
    {
        $u = User::where('id', $request->user)->first();
        $les_cours = Cours::where('user_id', "=", "$u->id")->get();
        return view('planning.admin_select_cours')->with('les_cours', $les_cours);
    }

    public function affichage(Request $request)
    {
        $u = User::where('id', $request->user)->first();
        $cour = Cours::where('user_id', "=", "$u->id")->where('id', $request->cours)->first();
        return view('planning.admin_afficher_cours')->with('cour', $cour);
    }
}
