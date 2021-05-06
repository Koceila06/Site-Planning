@extends('modele')

@section('contents')
<div class="container">
    <div class="table_prof">

        <h2>Liste des cours des Enseignants</h2>
        <table>
            <tr>

                <th>Nom du responsable</th>
                <th>Prénom</th>
                <th>Voir les cours</th>

            </tr>

            @foreach($profs as $prof)

            <tr>
                <td>{{ $prof['nom'] }}</td>
                <td> {{ $prof['prenom'] }}</td>
                <td>
                    <form method="GET" action="{{route('cours.liste_ens_admin')}}">
                        @csrf
                        <input value="{{ $prof->id }}" name="prof" type="hidden"></input>
                        <button type="submit">Afficher détail</button>

                    </form>


                </td>


            </tr>
            @endforeach
        </table>
    </div>
</div>
@endsection