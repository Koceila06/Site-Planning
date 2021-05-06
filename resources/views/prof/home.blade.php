@extends('modele')

@section('title','home: user')

@section('contents')
<table class="table table-bordred">
    <ul class="list-group">
    <li class="list-group-item">
<a href="{{route('user.modifier_mdp')}}">Modifier le mot de passe</a></li>
<li class="list-group-item">
<a href="{{route('edit.info')}}">Modifier le Nom/Prenom </a></li>
<li class="list-group-item">
<a href="{{route('prof.cours.liste')}}">Voir la liste des cours dont vous etes responsable </a></li>
 <li class="list-group-item">
<a href="{{route('cour.create.seance')}}">Créer une séance de cours </a></li>
<li class="list-group-item">
<a href="{{route('cours.mise_ajour_prof')}}">Liste et (Maj/supp) d'une séance de cours(Integrale/semaine) </a></li>
<li class="list-group-item">
<a href="{{route('cour.MAJ.seance')}}">Liste et (Maj/supp) d'une séance de cours(Par cours) </a></li>


    </ul>
</table>

    @endsection