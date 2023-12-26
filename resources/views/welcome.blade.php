<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>MAD MUSIC Tour Planner</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=Roboto:wght@400;700&display=swap"
        rel="stylesheet">

</head>

<body class="bg-gradient-to-br from-gray-100 to-gray-300 overflow-hidden">
    <div id="app" class="relative"></div>
    <div id="alerts" class="fixed top-10 right-5"></div>
    <div id="confirm"></div>
    @vite('resources/js/app.js')
</body>

</html>
