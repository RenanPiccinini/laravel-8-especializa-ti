<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'teste')</title>

    <link rel="stylesheet" href="{{ env('APP_URL') }}/public/css/app.css }}">

</head>
<body class="bg-gray-50">

    <header>

    </header>

    <div class="container mx-auto py-8">
        @yield('content')
    </div>

</body>
</html>
