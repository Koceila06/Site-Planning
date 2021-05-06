@extends('modele')

@section('title','Modifier le MDP')

@section('contents')
<h1>Modifier le Mot de passe</h1>
<form method="post">

    Ancien MDP: <input type="password" name="old_mdp"></p>

    Nouveau MDP <input type="password" id="fmdp" name="mdp"></p>

    Confirmer MDP <input type="password" id="fcmdp" name="mdp_confirmation"></p>

    <input type="submit" value="Envoyer">
    @csrf
</form>
@endsection