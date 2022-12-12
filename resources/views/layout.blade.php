@php
    $user = auth()->user();
    $route = Route::getCurrentRoute()->getName();
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($title) ? $title : null }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand @if ($route == "index") active @endif" href="{{ route('index') }}">@lang("title.home")</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="nav navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link @if ($route == "project.list") active @endif" href="{{ route('project.list') }}">@lang("title.projects")</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if ($route == "service.list") active @endif" href="{{ route('service.list') }}">@lang("title.services")</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if ($route == "manf.list") active @endif" href="{{ route('manf.list') }}">@lang("title.manfs")</a>
                    </li>
                @if ($user)
                    <li class="nav-item">
                        <a class="nav-link @if ($route == "user.project.my") active @endif" href="{{ route('user.project.my') }}">@lang("title.my-projects")</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if ($route == "user.project.my") active @endif" href="{{ route('user.project.my') }}">@lang("title.my-manfs")</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}">@lang("title.logout")</a>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link @if ($route == "login") active @endif" href="{{ route('login') }}">@lang("title.login")</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if ($route == "register") active @endif" href="{{ route('register') }}">@lang("title.register")</a>
                    </li>
                @endif
                </ul>
            </div>
        </div>
    </nav>
    @yield("body")
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>
</html>