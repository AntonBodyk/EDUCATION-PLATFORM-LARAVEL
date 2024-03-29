<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&family=Russo+One&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite('public/css/style.css')
    <title>SmartLearn-Admin</title>
</head>
<body>
<header>
    <nav class="navbar navbar-dark bg-dark">
        <div class="navbar-collapse" id="navbarNav">

            <ul class="navbar">
                @guest()
                    <li class="nav-item"><h1>SmartLearn</h1></li>
                    <li class="nav-item">
                        <a href="{{route('login')}}" class="nav-link nav-login">Вхід</a>
                    </li>
                @endguest
                @auth()
                    @if(auth()->user()->role_id === 1)
                        <li class="nav-item users-block">
                            <a class="nav-link users-link" href="{{route('users.index')}}">Користувачі</a>
                            <a class="fa-solid fa-user-plus" href="{{route('users.create')}}"></a>
                        </li>
                        <li class="nav-item courses-block">
                            <a class="nav-link courses-link" href="{{route('courses.index')}}">Курси</a>
                            <a class="fa-solid fa-plus" href="{{route('courses.create')}}"></a>
                        </li>
                            <form action="{{ route('users.search')}}" method="post">
                                @csrf
                                <div class="input-group mb-3 search">
                                    <input type="text" class="form-control" name="search" placeholder="Пошук" aria-label="Пошук" aria-describedby="basic-addon2">
                                    <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Пошук</button>
                                </div>
                            </form>
                        <li class="nav-item">
                            <span class="hello-user">Доброго дня, {{auth()->user()->first_name}}!</span>
                        </li>
                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}" class="logout">
                                @csrf
                                <button type="submit" class="logout-btn">Вихід</button>
                            </form>
                        </li>
                    @endif
                @endauth
            </ul>
        </div>
    </nav>
</header>
<main>
    @yield('content')
</main>
</body>
</html>
