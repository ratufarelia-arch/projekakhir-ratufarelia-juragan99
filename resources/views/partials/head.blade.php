<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<title>{{ $title ?? config('app.name') }}</title>

<link rel="icon" type="image/png" href="{{ asset('favicon/favicon.png') }}">

<!-- Hilangkan ini dulu -->
{{-- <link rel="icon" href="{{ asset('public') }}" type="image/svg+xml"> --}}
<link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">


<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

@vite(['resources/css/app.css', 'resources/js/app.js'])
@fluxAppearance
