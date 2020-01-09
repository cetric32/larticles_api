<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta name="csrf-token" content="{{ csrf_token()}}">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script>window.Laravel = { csrfToken: '{{ csrf_token()}}'}</script>
        <title>Larticles</title>    
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">    
    </head>
    <body>
        <div id="app" class="container">
            <div>
                <articles></articles> 
            </div>                        
        </div>
        <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>
