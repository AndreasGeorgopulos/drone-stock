@extends('drone-stock.index')
@section('content')

    @foreach ($category->stocks as $stock)
        @php($t = $stock->translates()->where('language_code', App::getLocale())->first())
        <article class="col-md-4 col-sm-3 col-xs-2">
            <a href="{{url('/v-stock/' . $category_slug . '/' . $t->slug)}}">
                <h2>{{$t->meta_title}}</h2>
                @if(!empty($stock->images))
                    <figure><img src="{{$stock->images['250_250']['url']}}" /><figcaption>{{$t->meta_description}}</figcaption></figure>
                @endif
            </a>
        </article>
    @endforeach
@endsection