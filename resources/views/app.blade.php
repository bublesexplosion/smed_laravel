<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title inertia>{{ config('app.name', 'Laravel') }}</title>

        <!---define o favicon a ser usado--->
        <link rel="icon" type="image/ico" href="/images/favicon.ico?v=1">

         <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Gov.br Design System - CSS (URL Corrigida) -->
        <link rel="stylesheet" href="https://cdn.gov.br/design-system/core.css">
        <!-- Font Awesome para os ícones de seta (fa-angle-down) -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- Scripts -->
        @routes
        @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
        @inertiaHead
    </head>
    <body class="font-sans antialiased">
        <!-- Gov.br Design System - JS (URL Corrigida) -->
        <script src="https://cdn.gov.br/design-system/core.js"></script>
        
        @inertia
    </body>
</html>
