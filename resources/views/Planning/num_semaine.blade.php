@extends('modele')

@section('title','Recherche')

@section('contents')
<p>Choisir un numéro de semaine</p>
<form method="post">
    <label for="fnom">Semaine:</label>
    <input type="text" id="fnom" name="num"><br>

    <input type="submit" value="Envoyer">
    @csrf
</form>
@endsection