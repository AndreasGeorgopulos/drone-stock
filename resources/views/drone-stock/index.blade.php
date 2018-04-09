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
<h1>{{!empty($meta_data['title']) ? $meta_data['title'] : 'Drone-stock'}}</h1>
@yield('content')
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

</body>
</html>