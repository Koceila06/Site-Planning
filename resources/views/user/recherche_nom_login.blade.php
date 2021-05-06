@extends('modele')

@section('contents')
<form method="post">

    <label for="nom">Nom : </label>
    <input type="text" name="nom"><br>

    <label for="Prenom"> Prenom :</label>
    <input type="text" name="prenom">
    <br />
    <label for="login"> Login :</label>
    <input type="text" name="login">
    <input type="submit" value="Envoyer">
    @csrf
</form>
@endsection