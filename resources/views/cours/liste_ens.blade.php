@extends('modele')

@section('contents')
<div class="container">
    <div class="table_prof">
        <h2>Liste des cours</h2>
        <table>
            <tr>
                <th>Id</th>
                <th>Intitulé</th>
                <th>Modifier</th>
                <th>Supprimer</th>

                @foreach($liste_cours as $cours)
            <tr>
                <td>{{$cours['id']}} </td>
                <td>{{$cours['intitule']}} </td>


            </tr>

            </tr>
            @endforeach
        </table>
    </div>
</div>
@endsection