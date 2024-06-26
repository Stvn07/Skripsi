<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSS -->
    <link rel="stylesheet" href="resources/css/dashboard.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    {{-- Icon Bootstrap --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    <title>@yield('title')</title>

<body>
    <div class="container-fluid">
        <div class="row flex-nowrap">
            <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-light">
                <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
                    <a href="/"
                        class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                        <img src="storage/images/LogoNabungKuy.png">
                    </a>
                    <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start"
                        id="menu">
                        <li class="active nav-item ">
                            <a href="/" class="nav-link align-middle px-0 active">
                                <i class="fs-3 bi-house"></i><span class="ms-1 d-none d-sm-inline">Home</span>
                            </a>
                        </li>
                        @if (Auth::check())
                            <li class="active">
                                <a href="{{ route('profile', Auth::user()->id) }}" class="nav-link px-0 align-middle">
                                    <i class="fs-4 bi-table"></i> <span
                                        class="ms-1 d-none d-sm-inline">{{ __('profile') }}</span>
                                </a>
                            </li>
                        @endif

                        <li>
                            <a href="{{ route('openTransaction') }}" class="nav-link px-0 align-middle">
                                <i class="fs-4 bi-people"></i> <span
                                    class="ms-1 d-none d-sm-inline">{{ __('transaction') }}</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('openReport') }}" class="nav-link px-0 align-middle">
                                <i class="fs-4 bi-people"></i> <span
                                    class="ms-1 d-none d-sm-inline">{{ __('report') }}</span>
                            </a>
                        </li>
                    </ul>
                    <hr>
                </div>
            </div>

            {{-- Content --}}
            <div class="col py-3">
                <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
                @yield('content')
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
