@extends('modele')

@section('title','Enregistrement')

@section('contents')
<p>Créer un utilisateur</p>
<form method="post">
    <label for="fnom">Nom :</label>
    <input type="text" id="fnom" name="nom"><br>

    <label for="fprenom">Prenom :</label>
    <input type="texte" id="fprenom" name="prenom"><br>

    <label for="flogin">Login :</label>
    <input type="text" id="flogin" name="login"><br>

    <label for="type" >Type:</label>
    <select name="type"  >

        <option value="enseignant">enseignant</option>
        <option value="etudiant">etudiant</option>
        <option value="admin">admin</option>

    </select>
    <br />
    <label for="formation">Formation :</label>

    <select name="formation" >
        @foreach($formations as $formation)
        <option value="{{ $formation->id }}">{{ $formation->intitule }}</option>
        @endforeach
        <option value="{{ null}}">Pas de formation</option>

    </select>
<br />


    <label for="fmdp">Password :</label>
    <input type="password" id="fmdp" name="mdp"><br>

    <label for="fcmdp">Confirmation Password : </label>
    <input type="password" id="fcmdp" name="mdp_confirmation"><br>

    <input type="submit" value="Envoyer">
    @csrf
</form>
@endsection