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
            font-size: 20px;
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
        button {
            width: 50%;
            height: 3rem;
            margin: 1rem 0;
            color: blue;
            font-size: 1rem;
            cursor: pointer;
            border-radius: .5rem;
        }
        .form-control {
            border-radius: .25rem;
            box-shadow: inset 0 1px 1px 0 hsla(0, 0%, 0%, .08);
            background-color: hsl(220, 12%, 95%);
        }
        label {
            display: inline-block;
            width: 300px;
            text-align: left;
        }
        input, select {
            width: 300px;
            font-size: 1rem;
        }
    </style>
</head>
<body>
<div class="main">
    @yield('main')
</div>
</body>
</html>
