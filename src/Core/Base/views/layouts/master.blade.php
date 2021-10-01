<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1" name="viewport">
    <title>Home</title>

    @yield('css')
</head>

<body>
    <div class="wrapper">
        {{-- NAVBAR --}}
        @include($global['base']['namespace'] . 'layouts.partials._navbar')

        {{-- SIDEBAR --}}
        @include($global['base']['namespace'] . 'layouts.partials._sidebar')

        {{-- PAGE CONTENT --}}
        <div class="content">
            @yield('content')
        </div>
    </div>
    
    @yield('js')
</body>
</html>
