@extends('modele')

@section('contents')
<div class="container">
        <div class="table_prof">
                <h2>Liste des formations</h2>
                <table>
                        <tr>
                                <th>Id</th>
                                <th>Intitulé</th>
                                <th>Modifier</th>
                                <th>Supprimer</th>
                                @foreach($liste_formation as $formation)
                        <tr>
                                <td>{{$formation['id']}} </td>
                                <td>{{$formation['intitule']}} </td>
                                <td>
                                        <form method="GET" action="{{route('admin.modifier.formation')}}">
                                                @csrf
                                                <input value="{{ $formation->id }}" name="formation" type="hidden"></input>
                                                <label for="intitule">Intitulé :</label>
                                                <input type="texte" id="fprenom" name="intitule">
                                                <button type="submit">Modifier</button>
                                                <br>
                                        </form>

                                </td>
                                <td>
                                        <form method="GET" action="{{route('formation.supp.admin')}}">
                                                @csrf
                                                <input value="{{$formation->id }}" name="formation" type="hidden"></input>

                                                <button type="submit">Supprimer</button>
                                                <br>
                                        </form>
                                </td>

                        </tr>
                        @endforeach
                        </tr>
                </table>
        </div>
</div>
@endsection