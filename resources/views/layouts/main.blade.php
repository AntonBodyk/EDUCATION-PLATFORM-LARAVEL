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
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{route('admin')}}">Головна</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('users.index')}}">Користувачі</a>
                    <a class="fa-solid fa-user-plus" href="{{route('users.create')}}"></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Курси</a>
                    <a class="fa-solid fa-plus"></a>
                </li>
            </ul>
        </div>
    </nav>
</header>
<main>
    @yield('content')
</main>
</body>
</html>
