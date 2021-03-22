<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="The Essential Medicines Dashboard assists in..." />
    <title>
        {{ config('app.name', 'Laravel') }} - Login Page
    </title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/theme.min.css') }}">

    <style>
        body {
        display: none;
        }
    </style>
</head>
<body class="d-flex align-items-center bg-auth border-top border-top-2 border-primary">
    <div class="container-fluid">
        <div class="row align-items-center justify-content-center">
            <div class="col-md-8">
                @yield('content')
            </div>
        </div>
    </div>
</body>
</html>
