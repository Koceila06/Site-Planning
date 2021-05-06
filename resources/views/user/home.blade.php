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
<a href="{{route('formation.cours.liste')}}">Voir la liste des cours disponibles </a></li>
<li class="list-group-item">
<a href="{{route('inscr.etud')}}">S'inscrire dans un cours </a></li>
<li class="list-group-item">
<a href="{{route('supp.etud')}}">Se désinscrire d'un cours </a></li>
<li class="list-group-item">
<a href="{{route('liste.etud')}}">Liste des cours inscris </a></li>
<li class="list-group-item">
<a href="{{route('liste.recherche')}}">Rechercher un cours </a></li>
<li class="list-group-item">
<a href="{{route('planning.cours')}}">Voir son planning(Integral/semaine) </a></li>
<li class="list-group-item">
<a href="{{route('planning.cours.recherhce.par_cours')}}">Voir son planning par cours </a></li>




</ul>
</table>

@endsection