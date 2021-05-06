<!DOCTYPE>
<html>

<head>
    <meta charset="utf-8">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">


    <style>

  

        h1 {
            text-align: center;
        }



        table,
        th,
        td {
            border: 2px solid black;
            border-collapse: collapse;
            padding: 20px;
            text-align: center;
        }

        .etat {
            background-color: lightblue;
        }

        .error {
            background-color: lightpink;
        }

    

        #t01 {
            background-color: #f1f1c1;
        }
        body{
            margin-left: 10px;
        }
        #menu{
            width:100%;
            margin-bottom: 20px;
        }
    </style>

</head>

<body >
    @section('menu')
    <table >
        @guest()
        <tr>
        <th><a href="{{route('login')}}">Login</a></th>
        <th><a href="{{route('register_prof')}}">Enregistrement en tant que enseignant</a></th>
        <th><a href="{{route('register_etu')}}">Enregistrement en tant que étudiant</a></th>
    </tr>
        @endguest
    </table>

    <table id="menu">
        @auth

        <tr>
            <th><a href="{{route('logout')}}">Deconnexion</a></th>
            <th><a href="{{route('home.user')}}">Page Etudiant</a></th>
            <th><a href="{{route('home.prof')}}">Page Enseignant</a></th>
            <th><a href="{{route('home.admin')}}">Page Admin</a></th>
        </tr>
        @endauth
    </table>


    @show

    @section('etat')
    @if(session()->has('etat'))
    <p class="etat">{{session()->get('etat')}}</p>
    @endif
    @show

    @section('errors')
    @if ($errors->any())
    <div class="error">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    @show

    @yield('contents')


</body>

</html>