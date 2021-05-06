@extends('modele')
@section('title','Recherche')
@section('contents')
<p>Choisir un type</p>
<form method="post">
    <label for="type">Type:</label>
    <select name="type" >

        <option value="enseignant">enseignant</option>
        <option value="etudiant">etudiant</option>
        <option value="admin">admin</option>

    </select>
    <input type="submit" value="Envoyer">
    @csrf
</form>
@endsection