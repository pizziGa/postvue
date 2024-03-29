<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
        <script defer type="text/javascript" src="{{ viteJS() }}"></script>
        <link rel="stylesheet" type="text/css" href="{{ viteCSS() }}">
    </head>
    <body class="antialiased">
        <div id="app"></div>
    </body>
</html>
