@extends('drone-stock.index')
@section('content')
    @foreach ($categories as $c)
        @php($t = $c->translates()->where('language_code', App::getLocale())->first())
        @continue(!$t->active)
        <article class="col-md-4 col-sm-3 col-xs-2">
            <a href="{{url('/v-stock/' . $t->slug)}}">
            <h2>{{$t->meta_title}}</h2>
            @if(!empty($c->images))
                <figure><img src="{{$c->images['250_250']['url']}}" /><figcaption>{{$t->meta_description}}</figcaption></figure>
            @endif
            </a>
        </article>
    @endforeach
@endsection