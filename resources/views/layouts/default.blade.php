<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Exam App</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet"/>

    <!-- App Styles -->
    <link href="{{asset('/css/app.css')}}" rel="stylesheet"/>

    <!-- JQuery -->
    <script type="text/javascript" src="{{asset('/js/jquery-3.4.1.min.js')}}"></script>
    @stack('scripts')
</head>
<body class="@yield('body-color', 'bg-purple-900')">
@section('container')
    <div class="container mx-auto mt-4 bg-white max-w-4xl rounded shadow p-3">
        <div class="border-b border-gray-400 mb-2">
            <h1 class="text-xl pb-2">@yield('title', 'Exam Project')</h1>
        </div>
        <div class="pb-2">
            <ul class="flex">
                @foreach( [
                'orm' => 'ORM',
                'query' => 'Query Builder',
                'orm-cached' => 'ORM + Cache',
                'query-cached' => 'Query + Cache',
                ] as $route => $label)
                    <li class="mr-3">
                        <a class="inline-block border py-1 px-3 {{request()->routeIs($route)?'bg-blue-500 text-white':'border-white text-blue-500'}}"
                           href="{{route($route)}}">{{$label}}</a>
                    </li>
                @endforeach
            </ul>
        </div>

        @yield('content')
    </div>
@show
</body>
</html>
