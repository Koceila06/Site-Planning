<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('main');
})->name('main');
//Utilisateur
Route::view('/home/auth', 'home')->middleware('auth')->name('home');

Route::view('/home', 'user.home')->middleware('auth')->middleware('is_student')->name('home.user');
Route::get('/login', [App\Http\Controllers\AuthenticatedSessionController::class, 'formLogin'])
    ->name('login');
Route::post('/login', [App\Http\Controllers\AuthenticatedSessionController::class, 'login']);
Route::get('/logout', [App\Http\Controllers\AuthenticatedSessionController::class, 'logout'])
    ->name('logout')->middleware('auth');
Route::get('/register/prof', [App\Http\Controllers\RegisterUserController::class, 'registerForm_prof'])
    ->name('register_prof');
Route::post('/register/prof', [App\Http\Controllers\RegisterUserController::class, 'register_prof']);
Route::get('/register/etu', [App\Http\Controllers\RegisterUserController::class, 'registerForm_etu'])
    ->name('register_etu');
Route::post('/register/etu', [App\Http\Controllers\RegisterUserController::class, 'register_etu']);
Route::get('user/modifier_mdp', [App\Http\Controllers\UserController::class, 'modifierMdpForm'])
    ->middleware('auth')->name('user.modifier_mdp');
Route::post('user/modifier_mdp', [App\Http\Controllers\UserController::class, 'modifierMdp'])->middleware('auth');

Route::get('/edit/info', [App\Http\Controllers\UserController::class, 'EditNomForm'])
    ->name('edit.info')->middleware('auth');
Route::post('/edit/info', [App\Http\Controllers\UserController::class, 'EditNom'])->name('edit')->middleware('auth');

Route::get('/validation/compte/prof', [App\Http\Controllers\UserController::class, 'Validate_Compte_prof_list'])
    ->middleware('auth')->middleware('is_admin');
Route::post('/validation/compte/prof', [App\Http\Controllers\UserController::class, 'Validate_compte_prof'])->name('prof.valider')->middleware('auth')->middleware('is_admin');
Route::post('/suppression/compte/prof', [App\Http\Controllers\UserController::class, 'Supprimer_compte_prof'])->name('utilisateur.supprimer')->middleware('auth')->middleware('is_admin');
Route::post('/validation/compte/etudiant', [App\Http\Controllers\UserController::class, 'Validate_compte_etudiant'])->name('etudiant.valider')->middleware('auth')->middleware('is_admin');

Route::view('/admin', 'auth.admin.home')->middleware('auth')
    ->middleware('is_admin')->name('home.admin');


Route::get('/associer/prof/formation', [App\Http\Controllers\UserController::class, 'prof_list'])
    ->middleware('auth')->middleware('is_admin');
Route::post('/associer/prof/formation', [App\Http\Controllers\UserController::class, 'Associer_formation_prof'])->name('prof.associer');

Route::get('/liste/cours', [App\Http\Controllers\UserController::class, 'cours_list'])
    ->middleware('auth')->middleware('is_admin')->name('cours.liste');

Route::get('/cours/create', [App\Http\Controllers\UserController::class, 'cours_form'])
    ->name('cours.create')->middleware('auth')->middleware('is_admin');
Route::post('/cours/create', [App\Http\Controllers\UserController::class, 'cours_create'])->middleware('auth')->middleware('is_admin');

Route::get('/liste/cformation', [App\Http\Controllers\UserController::class, 'formation_list'])
    ->middleware('auth')->middleware('is_admin')->name('formation.liste');

Route::get('/ajout/formation', [App\Http\Controllers\UserController::class, 'ajout_formation_form'])
    ->middleware('auth')->middleware('is_admin')->name('formation.ajout');
Route::post('/ajout/formation', [App\Http\Controllers\UserController::class, 'ajout_formation'])->middleware('auth')->middleware('is_admin');

Route::get('/liste/cours/formation', [App\Http\Controllers\UserController::class, 'liste_cours_formation'])
    ->middleware('auth')->middleware('is_student')->name('formation.cours.liste');

Route::get('/liste/cours/prof', [App\Http\Controllers\UserController::class, 'liste_cours_prof'])
    ->middleware('auth')->middleware('is_prof')->name('prof.cours.liste');

Route::view('/prof', 'prof.home')->middleware('auth')
    ->middleware('is_prof')->name('home.prof');

Route::get('/inscr/cours/etu', [App\Http\Controllers\CoursController::class, 'inscr_etud_form'])
    ->name('inscr.etud')->middleware('is_student');
Route::post('/inscr/cours/etu', [App\Http\Controllers\CoursController::class, 'inscr_etud'])->middleware('is_student');
Route::get('/supprimer/cours/etu', [App\Http\Controllers\CoursController::class, 'supp_etud_form'])
    ->name('supp.etud')->middleware('is_student');
Route::post('/supprimer/cours/etu', [App\Http\Controllers\CoursController::class, 'sup_etud'])->middleware('is_student');

Route::get('/liste/cours/inscris', [App\Http\Controllers\CoursController::class, 'liste_cours_inscrit'])
    ->name('liste.etud')->middleware('is_student');
Route::get('/recherche/cours', [App\Http\Controllers\CoursController::class, 'recherche_cours_form'])
    ->name('liste.recherche')->middleware('is_student');
Route::post('/recherche/cours', [App\Http\Controllers\CoursController::class, 'recherche_cours'])->middleware('is_student');
Route::get('/planning/cours', [App\Http\Controllers\CoursController::class, 'planning_cours_etu'])
    ->name('planning.cours')->middleware('is_student');

Route::get('/creation/seance/cours', [App\Http\Controllers\CoursController::class, 'create_seance_form'])
    ->middleware('auth')->middleware('is_prof')->name('cour.create.seance');
Route::post('/creation/seance/cours', [App\Http\Controllers\CoursController::class, 'create_seance'])->name('cour.create.def')->middleware('auth')->middleware('is_prof');


Route::get('/planning/cours/etudiant', [App\Http\Controllers\CoursController::class, 'recherche_cours_planning_form'])
    ->name('planning.cours.recherhce')->middleware('is_student');


Route::get('/MAJ/seance/cours/admin/semaines', [App\Http\Controllers\CoursController::class, 'Maj_seance_form_semaine'])
    ->middleware('is_prof')->name('cours.mise_ajour_prof');
Route::post('/MAJ/seance/cours/admin/semaines', [App\Http\Controllers\CoursController::class, 'Maj_seance_semaine'])->name('cour.mj.semaine')->middleware('is_prof');

Route::get('/MAJ/seance/cours/mj', [App\Http\Controllers\CoursController::class, 'Maj_seance_cour_form'])
    ->middleware('is_prof')->name('cour.MAJ.seance');
Route::post('/MAJ/seance/cours/mj', [App\Http\Controllers\CoursController::class, 'Maj_seance_cour'])->middleware('is_prof');

Route::post('/supp/seance/cours', [App\Http\Controllers\CoursController::class, 'sup_seance'])->middleware('is_prof')->name('cour.supp');

Route::get('/planning/cours/etudiant/2', [App\Http\Controllers\CoursController::class, 'recherche_par_cour_form'])
    ->name('planning.cours.recherhce.par_cours')->middleware('is_student');
Route::post('/planning/cours/etudiant/2', [App\Http\Controllers\CoursController::class, 'recherche_par_cour'])->middleware('is_student');

Route::get('/recherche/cours/admin', [App\Http\Controllers\CoursController::class, 'recherche_cours_admin_from'])->name('recherche.cours.admin')->middleware('is_admin');
Route::post('/recherche/cours/admin', [App\Http\Controllers\CoursController::class, 'recherche_cours_admin'])->middleware('is_admin');

Route::post('/modifier/cours/admin', [App\Http\Controllers\CoursController::class, 'modifier_cours_admin'])->name('admin.modifier.cours')->middleware('is_admin');
Route::post('/supprimer/cours/admin', [App\Http\Controllers\CoursController::class, 'supprimer_cours_admin'])->name('admin.supprimer.cours')->middleware('is_admin');
Route::get('/recherche/cours/admin', [App\Http\Controllers\CoursController::class, 'recherche_cours_admin_from'])->name('recherche.cours.admin')->middleware('is_admin');
Route::get('/liste/cours/ens', [App\Http\Controllers\UserController::class, 'liste_cours_ens_form'])->name('liste.cours.par.ens')->middleware('is_admin');

Route::get('/liste/cours/ens/admin', [App\Http\Controllers\UserController::class, 'liste_cours_ens'])->name('cours.liste_ens_admin')->middleware('is_admin');
Route::get('/modifier/cours/ens/admin', [App\Http\Controllers\UserController::class, 'modifier_formation_ens'])->name('admin.modifier.formation')->middleware('is_admin');
Route::get('/supprimer/formation', [App\Http\Controllers\UserController::class, 'supprimer_formation_admin'])->name('formation.supp.admin')->middleware('is_admin');
Route::get('/create/cours/seance/admin', [App\Http\Controllers\UserController::class, 'creation_seance_admin_form_'])->name('seance.create.admin.create')->middleware('is_admin');
Route::post('/create/cours/seance/admin', [App\Http\Controllers\UserController::class, 'creation_cours_admin_form'])->name('seance.create.admin')->middleware('is_admin');

Route::get('/MAJ/seance/cours/mj/admin/select', [App\Http\Controllers\UserController::class, 'creation_seance_admin_form'])
    ->middleware('auth')->middleware('is_prof')->name('cour.MAJ.seance.admin');

Route::get('/MAJ/seance/cours/mj/admin', [App\Http\Controllers\CoursController::class, 'Maj_seance_form_semaine_admin'])->name('admin.modif.supp')->middleware('is_admin');

Route::get('/MAJ/seance/cours/mj/admin/supp', [App\Http\Controllers\UserController::class, 'creation_seance_admin_form_'])
    ->middleware('auth')->middleware('is_admin')->name('cour.admin.par.seance');

Route::get('/MAJ/seance/cours/mj/supp/admin', [App\Http\Controllers\CoursController::class, 'Maj_seance_cour_form_'])->middleware('is_prof')->name('admin.cours');
Route::get('/MAJ/seance/cours/mj/supp/admin/plan', [App\Http\Controllers\CoursController::class, 'plans'])->name('admin.plans')->middleware('is_admin');


Route::get('/MAJ/seance/profs', [App\Http\Controllers\UserController::class, 'creation_seance_admin_form_'])
    ->middleware('auth')->middleware('is_admin')->name('profs');
Route::post('/MAJ/seance/profs', [App\Http\Controllers\CoursController::class, 'cours'])
    ->middleware('auth')->middleware('is_admin')->name('cours');
Route::get('/MAJ/seance/affichage', [App\Http\Controllers\CoursController::class, 'affichage'])
    ->middleware('auth')->middleware('is_admin')->name('affichage');

Route::get('/liste/users', [App\Http\Controllers\UserController::class, 'liste_integ'])
    ->middleware('auth')->middleware('is_admin')->name('liste.intégral');

//////////////////////////////////////////

Route::get('/liste/users/type', [App\Http\Controllers\UserController::class, 'liste_par_type_form'])
    ->middleware('auth')->middleware('is_admin')->name('liste.type');

Route::post('/liste/users/type', [App\Http\Controllers\UserController::class, 'liste_par_type'])->middleware('auth')->middleware('is_admin');


Route::get('/create/user', [App\Http\Controllers\UserController::class, 'create_user_from_admin'])
    ->middleware('auth')->middleware('is_admin')->name('create.user.byadmin');
Route::post('/create/user', [App\Http\Controllers\UserController::class, 'create_user_from'])->middleware('auth')->middleware('is_admin');


Route::get('/edit/info/admin', [App\Http\Controllers\UserController::class, 'EditNomForm_admin'])
    ->name('edit.info.admin')->middleware('is_admin');
Route::post('/edit/info/admin', [App\Http\Controllers\UserController::class, 'EditNom_admin'])->name('edit.admin')->middleware('is_admin');
Route::get('/user/supp/admin', [App\Http\Controllers\UserController::class, 'delet_admin'])
    ->name('user.supp.admin')->middleware('is_admin');

Route::get('/edit/info/admin/npl', [App\Http\Controllers\UserController::class, 'recherche_nom_login_form'])
    ->name('liste.info')->middleware('is_admin');

Route::post('/edit/info/admin/npl', [App\Http\Controllers\UserController::class, 'recherche_nom_login'])->middleware('is_admin');
////////
Route::get('/create/user/admin', [App\Http\Controllers\UserController::class, 'create_user_compte_form'])
    ->name('admin.create.user')->middleware('is_admin');
Route::post('/create/user/admin', [App\Http\Controllers\UserController::class, 'create_user_compte'])->middleware('is_admin');
