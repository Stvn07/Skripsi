<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

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

    <style>
        body {
            display: flex;
            margin: 0;
            font-family: Arial, sans-serif;
            height: 100vh;
        }

        .sidebar {
            width: 250px;
            padding-top: 20px;
            background-color: #dfffcf;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .logo {
            margin-bottom: 10px;
        }

        .logo img {
            width: 150px;
            height: 150px;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            width: 100%;
            padding: 15px 20px;
            margin: 5px 0;
            color: #333;
            text-decoration: none;
            transition: background-color 0.3s, color 0.3s;
            font-size: 18px;
        }

        .sidebar-link .icon {
            margin-right: 10px;
            font-size: 24px;
        }

        .sidebar-link.active {
            background-color: #a8f397;
            color: #000;
        }

        .sidebar-link:hover {
            background-color: #e0e7ff;
            color: #1e40af;
        }

        .content {
            flex-grow: 1;
            padding: 20px;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <div class="logo">
            <img src="storage/images/LogoNabungKuy.png" alt="Nabung Kuy Logo">
        </div>
        <a href="#" class="sidebar-link active">
            <span class="icon">🏠</span>
            Home
        </a>
        <a href="{{ route('openTransaction') }}" class="sidebar-link">
            <span class="icon">💲</span>
            {{ __('transaction') }}Transactions
        </a>
        <a href="#" class="sidebar-link">
            <span class="icon">🪙</span>
            Budgets
        </a>
        <a href="#" class="sidebar-link">
            <span class="icon">📈</span>
            Reports
        </a>
    </div>
    <div class="content">
        @yield('content')
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
