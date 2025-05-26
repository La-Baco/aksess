<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}">
    <link href="{{ asset('assets/images/logo/ikon.svg') }} " rel="icon">
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/error.css') }}">
</head>

<body>
    <div id="error">
        <div class="error-page container text-center">
            <div class="col-md-6 col-10 offset-md-3 offset-1">
                <img class="img-error mb-3" src="{{ asset('assets/images/samples/error-500.png') }}" alt="Not Found"
                    style="max-width: 650%; height: auto;">
                <h1 class="error-title">Error</h1>
                <h1 class="error-title fs-2 fs-md-3 fs-lg-2">System In Development</h1>
                <p class="fs-6 text-gray-600">The website is currently unavailable. Try again later or contact the
                    developer.</p>

                {{-- @php
                    $role = auth()->user()->role ?? null;
                @endphp

                @if ($role)
                    <a
                        href="{{ $role === 'admin' ? route('dashboard.admin') : ($role === 'guru' ? route('dashboard.guru') : route('dashboard.siswa')) }}"
                        class="btn btn-sm btn-outline-primary mt-2"
                    >
                        Go Home
                    </a>
                @endif --}}
            </div>
        </div>
    </div>
</body>

</html>
