@extends('modele')
@section('title','Recherche')
@section('contents')
<p>Veuillez choisir le cours</p>
<form method="get" action="{{ route('affichage') }}">
    <input hidden name="user" value="{{ Request::get('user') }}">
    <label for="Cours" >Cours</label>
    <select name="cours" >
        @foreach($les_cours as $cour)
        <option value="{{ $cour->id }}">{{ $cour->intitule }}</option>
        @endforeach
    </select>
    <input type="submit" value="Envoyer">
    @csrf
</form>
@endsection