<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
</head>
<style>
    body {
        background-color: #1e272e
    }

    .top{
        margin-top: 320px
    }
</style>

<body>
    <div class="container top">
        <div class="row justify-content-center">
            <div class="col-2 text-center">
                <img src="{{ asset('images/pandoradev.png') }}" alt="" width="70px">
            </div>
            <div class="w-100 mt-5 d-flex justify-content-center gap-2">
                @foreach ($flags as $see)
                    <a href="/task/{{ $see->key }}" class="btn btn-outline-light btn-sm mb-2">{{ $see->name }}</a>
                @endforeach
            </div>
        </div>
    </div>
</body>

</html>