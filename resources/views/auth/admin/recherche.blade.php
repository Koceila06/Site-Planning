@extends('modele')

@section('title','Recherche')

@section('contents')
<p>Rechercher un cours</p>
<form method="post">
    <label for="nom">Cours :</label>
    <input type="text" name="cours">
    <input type="submit" value="Recherche">
    @csrf
</form>
@endsection