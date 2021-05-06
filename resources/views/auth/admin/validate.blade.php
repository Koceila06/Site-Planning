@extends('modele')

@section('contents')
<div class="container">
    <div class="table_prof">
        <h2>Demande Enseignant</h2>
        <table>
            <tr>
                <th>Nom</th>
                <th>Prenom</th>
                <th>Operation</th>
                @foreach($liste_prof as $prof)
            <tr>
                <td>{{$prof['nom']}} </td>
                <td>{{$prof['prenom']}} </td>

                <td>
                    <form method="post" action="{{route('prof.valider')}}">
                        @csrf
                        <input type="hidden" value="{{ $prof['id'] }}" name="ut_id">
                        <button type="submit">Activer</button>
                    </form>
                    <form method="post" action="{{route('utilisateur.supprimer')}}">
                        @csrf
                        <input type="hidden" value="{{ $prof['id'] }}" name="ut_id">
                        <button type="submit">Refuser</button>
                </td>
                </form>
                </td>
            </tr>
            @endforeach

            </tr>
        </table>
    </div>
    <div class="table_etudiants">
        <h2>Demandes Etudiant</h2>

        <table>
            <tr>
                <th>Nom</th>
                <th>prenom</th>

                <th>Operation</th>
                @foreach($liste_etudiant as $etudiant)
            <tr>
                <td>{{$etudiant['nom']}} </td>
                <td>{{$etudiant['prenom']}} </td>


                <td>
                    <form method="post" action="{{route('etudiant.valider')}}">
                        @csrf
                        <input type="hidden" value="{{ $etudiant['id'] }}" name="ut_id">
                        <button type="submit">Activer</button>
                    </form>
                    <form method="post" action="{{route('utilisateur.supprimer')}}">
                        @csrf
                        <input type="hidden" value="{{ $etudiant['id'] }}" name="ut_id">
                        <button type="submit">Refuser</button>
                </td>
                </form>
            </tr>
            @endforeach

            </tr>
        </table>
    </div>
</div>

<style>
    .container {
        display: flex;
        width: 100%;
    }

    .container>* {
        flex-basis: 50%;
        padding: 0 1em;
    }
</style>

@endsection