<!doctype html>
<html lang="{{App::getLocale()}}">
<head>
    <title>{{!empty($meta_data['title']) ? $meta_data['title'] : 'Drone-stock'}}</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @if (!empty($meta_data))
        @foreach ($meta_data as $name => $content)
            <meta name="{{str_replace('_', ':', $name)}}" content="{{$content}}">
        @endforeach
    @endif

    <link type="text/css" rel="stylesheet" href="{{asset('asset/gzip/index.css?v=' . time())}}" />
    <script type="text/javascript" src="{{asset('asset/gzip/index.js?v=' . time())}}"></script>
</head>

<body>
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{trans('frontend.Nyelv')}}</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        @foreach (config('app.languages') as $lang)
                            <a class="dropdown-item" href="{{url('change_language/' . $lang)}}">{{trans('frontend.' . $lang)}}</a>
                        @endforeach
                        <div class="dropdown-divider"></div>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="#">{{trans('frontend.Kosár')}}</a>
                </li>
            </ul>
            <form id="search_form" class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" placeholder="{{trans('frontend.Keresés')}}" aria-label="{{trans('frontend.Keresés')}}">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">{{trans('frontend.Keresés')}}</button>
            </form>
        </div>
    </nav>
</header>

<div class="wrapper">
    <h1>{{!empty($meta_data['title']) ? $meta_data['title'] : 'Drone-stock'}}</h1>
    @yield('content')
</div>

<footer></footer>
@yield('js')

<script type="text/javascript">
    window.addEventListener("load", function(){
        window.cookieconsent.initialise({
            "palette": {
                "popup": {
                    "background": "#343434",
                    "text": "#ddaf2f"
                },
                "button": {
                    "background": "#e7a814",
                    "text": "#303030"
                }
            },
            "theme": "classic",
            "content": {
                "message": "A felhasználói élmény növelése érdekében oldalunk cookie-kat használ. Oldalunk használatával Ön beleegyezik a cookie-k alkalmazásába.",
                "dismiss": "Rendben",
                "link": "Bővebben...",
                "href": "http://www.agrotyre.hu/cookie-szabalyzat"
            }
        })
    });
</script>

<script type="text/javascript">
    $(document).ready(function () {
        $('#search_form').submit(function () {
            var searchtext = $(this).find('input[type=search]').val();
            if (searchtext.length >= 3) location.href = '/' + '{{trans('frontend.search_slug')}}' + '/' + searchtext;
            return false;
        });
    });
</script>

</body>
</html>