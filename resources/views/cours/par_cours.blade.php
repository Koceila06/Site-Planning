@extends('modele')

@section('title','Liste des profs')

@section('contents')
<p>Choisir un enseignant</p>
<form method="post">

    <label for="formation" >Enseingant :</label>

    <select name="user" >
        @foreach($profs as $user)
        <option value="{{ $user->id }}">{{ $user->nom }}</option>
        @endforeach
    </select>

    <input type="submit" value="Suivant">
    @csrf
</form>
@endsection