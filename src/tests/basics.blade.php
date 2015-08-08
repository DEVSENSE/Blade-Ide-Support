<html>
<head>
    <title>App Name - @yield('title')</title>
</head>
<body>
    @section('sidebar')
    This is the master sidebar.
    @show

    {{-- This comment will not be in the rendered HTML --}}

    @{{ This will not be processed by Blade }}

    <div class="container">
        Hello, {{ $name }}.
        
        The current UNIX timestamp is {{ time() }}.

        @if (count($records) === 1)
        I have one record!
        @elseif (count($records) > 1)
        I have multiple records!
        @else
        I don't have any records!
        @endif

        @unless (Auth::check())
        You are not signed in.
        @endunless

        @yield('content')
    </div>
</body>
</html>