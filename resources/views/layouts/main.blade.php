<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Invoice Creation</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <style>
        html {
            font-family: 'Nunito', sans-serif;
            font-weight: 400;
            height: 100vh;
            margin: 0;
            box-sizing: border-box;
            line-height: 1.15;
            font-size: 20px; /* Todo */
        }
        *, *:before, *:after {
            box-sizing: inherit;
        }
        body {
            min-height: calc(100vh - 100px);
            background-color: #fff;
            color: #636b6f;
            margin: 0;
            padding: 0;
        }
    </style>
</head>
<body>
<div class="main">
    @yield('main')
</div>
</body>
</html>
