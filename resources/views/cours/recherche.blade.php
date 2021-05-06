@extends('modele')

@section('title','Enregistrement')

@section('contents')
<p>Rechercher un cours</p>
<form method="post">
    <label for="nom">Cours :</label>
    <input type="text" name="cours"><br>

    <input type="submit" value="Recherche">
    @csrf
</form>
@endsection