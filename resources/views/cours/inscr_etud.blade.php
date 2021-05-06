@extends('modele')

@section('title','Inscriprion')

@section('contents')
<p>Veuillez choisir le cours</p>
<form method="post">
    <label for="Cours" >Cours </label>

    <select name="courss">
        @foreach($les_cours as $cour)
        <option value="{{ $cour->id }}">{{ $cour->intitule }}</option>
        @endforeach
    </select>
    </br>

    <input type="submit" value="Envoyer">
    @csrf
</form>
@endsection