@extends('modele')

@section('title','administrateur')

@section('contents')

<table class="table table-bordred">
    <tr>
        <th> Gestion des utilisateurs

        </th>
        <th> Gestion des cours

        </th>
        <th> Gestion des Formations

        </th>
        <th> Gestion des plannings

        </th>

    </tr>
    <tr>
        <td> <ul class="list-group">
        <li class="list-group-item">
                    <p><a href="{{route('prof.valider')}}">Voir les demandes de création</a> </p>
                </li>
      
                <li class="list-group-item">
                    <p><a href="{{route('admin.create.user')}}">Créer un utilisateur</a> </p>
                </li >

                <li class="list-group-item">
                    <p><a href="{{route('liste.intégral')}}">Liste des utilisateurs(modif/supp) (Intégrale)</a> </p>
                </li>
                <li class="list-group-item">
                    <p><a href="{{route('liste.type')}}">Liste des utilisateurs(modif/supp) (par type)</a> </p>
                </li>
                <li class="list-group-item">
                    <p><a href="{{route('liste.info')}}">Liste des utilisateurs(modif/supp) (par nom/prenom/login)</a> </p>
                </li>
                <li class="list-group-item">
                    <p><a href="{{route('prof.associer')}}">Associer un prof à un cours</a> </p>
                </li>

            </ul>
        </td>
        <td>

            <ul class="list-group">
                <li class="list-group-item">
                    <p><a href="{{route('cours.create')}}">Créer un cours</a> </p>
                </li>
                <li class="list-group-item">
                    <p><a href="{{route('cours.liste')}}">Voir la liste des cours(modification/suppression)</a> </p>
                </li>
                <li class="list-group-item">
                    <p><a href="{{route('recherche.cours.admin')}}">Rechercher un cours</a> </p>
                </li>

                <li class="list-group-item">
                    <p><a href="{{route('prof.associer')}}">Associer un prof à un cours</a> </p>
                </li>
                <li class="list-group-item">
                    <p><a href="{{route('liste.cours.par.ens')}}">liste des cours par enseignant</a> </p>
                </li>


            </ul>
        </td>
        <td>
            <ul class="list-group">

                <li class="list-group-item">
                    <p><a href="{{route('formation.ajout')}}">Créer une formation</a> </p>
                </li>
                <li class="list-group-item">
                    <p><a href="{{route('formation.liste')}}">Voir la liste des formations(modification/suppression)</a> </p>
                </li>

            </ul>

        </td>
        <td>
            <ul>
                <li class="list-group-item">
                    <p><a href="{{route('seance.create.admin.create')}}">créer une séance cours pour un enseignant</a> </p>
                </li>
                <li class="list-group-item">
                    <p><a href="{{route('cour.MAJ.seance.admin')}}">Liste séance cours (MAJ+Suppression) pour un enseignant(Integrale/semaine)</a> </p>
                </li>
                <li class="list-group-item">
                    <p><a href="{{route('profs')}}">Liste séance cours (MAJ+Suppression) pour un enseignant(par cours)</a> </p>
                </li>

            </ul>
        </td>

</table>
   

@endsection