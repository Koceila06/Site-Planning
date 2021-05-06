@extends('modele')

@section('title','Créer un cours')

@section('contents')
<p>Création d'un cours</p>
<form method="post">
    <label for="fnom">Intitulé :</label>
    <input type="text" name="nom" value="{{ old('nom') }}">
    <label for="formation" >Formation :</label>
   <select name="formation" >   
        @foreach($formations as $formation)
        @if (old('formation') == $formation->id)
      <option value="{{ $formation->id }}" selected>{{ $formation->intitule }}</option>
@else
      <option value="{{ $formation->id }}">{{ $formation->intitule }}</option>
@endif
        @endforeach
    </select>
    <label for="user" >Enseignant :</label>

    <select name="user" >
        @foreach($liste_prof as $user)
        @if (old('user') == $user->id)

        <option value="{{ $user->id }}" selected>{{ $user->nom }}</option>
        @else
      <option value="{{ $user->id }}">{{ $user->nom }}</option>
@endif
        @endforeach
    </select>

    <input type="submit" value="Créer">
    @csrf
</form>
@endsection