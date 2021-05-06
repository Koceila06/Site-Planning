@extends('modele')

@section('contents')
<div class="container">
    <div class="table_prof">
        <h2> Cours</h2>
        <table>
            <tr>
                <th>Id</th>
                <th>Intitulé</th>

            <tr>
                <td>{{$cours['id']}} </td>
                <td>{{$cours['intitule']}} </td>
            </tr>

            </tr>
        </table>
    </div>
</div>
@endsection