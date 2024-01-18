<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite('public/css/style.css')
    <title>Admin-page</title>
</head>
<body>
<header>
    <nav class="navbar navbar-dark bg-dark">
        <div class="navbar-collapse" id="navbarNav">
            <ul class="navbar">
                @guest()
{{--                    <li class="nav-item">--}}
{{--                        <a class="nav-link active" aria-current="page" href="{{route('admin')}}">Головна</a>--}}
{{--                    </li>--}}
                    <li class="nav-item">
                        <a href="{{route('login')}}" class="nav-link nav-login">Вхід</a>
                    </li>
                @endguest
                @auth()
                    @if(auth()->user())
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('users.index')}}">Користувачі</a>
                            <a class="fa-solid fa-user-plus" href="{{route('users.create')}}"></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('courses.index')}}">Курси</a>
                            <a class="fa-solid fa-plus" href="{{route('courses.create')}}"></a>
                        </li>
                        <li class="nav-item">
                            <a class="fa-solid fa-file-arrow-down" href="{{route('export-users')}}"></a>
                            <a class="fa-regular fa-envelope" href="{{route('users-email')}}"></a>
                        </li>
                        <li class="nav-item">
                            <span class="hello-user">Доброго дня, {{auth()->user()->first_name}}!</span>
                        </li>
                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}" class="logout">
                                @csrf
                                <button type="submit" class="logout-btn">Вихід</button>
                            </form>
                        </li>
                        @else
                            <li class="nav-item">
                                <a href="{{route('login')}}" class="nav-link nav-login">Вхід</a>
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
