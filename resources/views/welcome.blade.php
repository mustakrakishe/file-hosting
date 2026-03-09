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

        <div class="d-flex justify-content-center">
            <form action="{{ route('files.upload') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="formFileMultiple" class="form-label">PDF or DOCX (Max 10MB)</label>
                    <div class="input-group">
                        <input class="form-control @error('files') is-invalid @enderror" type="file" name="files[]" multiple>

                        <button type="submit" class="btn btn-primary">Upload</button>
                    </div>

                        @error('files')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror

                        @if ($errors->has('files.*'))
                            <div class="invalid-feedback d-block">
                                @foreach ($errors->get('files.*') as $messages)
                                    @foreach ($messages as $message)
                                        <div class="d-block">{{ $message }}</div>
                                    @endforeach
                                @endforeach
                            </div>
                        @endif
                </div>
            </form>
        </div>

        @foreach ($files as $file)
        <ul class="list-group list-group-horizontal justify-content-center">
            <li class="list-group-item w-100">{{ $file->name }}</li>
            <li class="list-group-item">{{ $file->created_at }}</li>
            <li class="list-group-item">
                <form action="{{ route('files.delete', $file->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </li>
        </ul>
        @endforeach

        {{ $files->links() }}
    </div>
</body>

</html>