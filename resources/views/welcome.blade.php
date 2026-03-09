<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }}</title>

    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>

<body>
    <div class="container px-0 py-4" style="width:800px;">
        <a href="/" class="text-dark text-decoration-none">
            <h1 class="text-center mb-3">File Hosting</h1>
        </a>

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        @foreach ($files as $file)
        <ul class="list-group list-group-horizontal justify-content-center">
            <li class="list-group-item w-100">{{ $file->name }}</li>
            <li class="list-group-item">{{ $file->created_at }}</li>
        </ul>
        @endforeach

        {{ $files->links() }}
    </div>
</body>

</html>