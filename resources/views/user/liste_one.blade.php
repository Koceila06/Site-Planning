@extends('modele')

@section('contents')
<div class="container">
    <div class="table_prof">
        <h2>Liste des Utilisateurs</h2>
        <table>


            <tr>
                <th>Id</th>
                <th>nom</th>
                <th>prenom</th>
                <th>type</th>
                <th>Modifier</th>
                <th>Suppression</th>
            <tr>
                <td>{{$user['id']}} </td>
                <td>{{$user['nom']}} </td>
                <td>{{$user['prenom']}} </td>
                <td>{{$user['type']}} </td>
                <td>
                    <form method="get" action="{{route('edit.info.admin')}}">
                        @csrf
                        <input value="{{ $user->id }}" name="user" type="hidden"></input>
                        <input type="submit" value="Modifier">
                    </form>
                </td>
                <td>
                    <form method="GET" action="{{route('user.supp.admin')}}">
                        @csrf
                        <input value="{{$user->id }}" name="user" type="hidden"></input>

                        <button type="submit">Supprimer</button>
                        <br>
                    </form>
                </td>
            </tr>
            </tr>
        </table>
    </div>
</div>
@endsection