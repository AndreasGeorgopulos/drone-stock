@extends('drone-stock.index')
@section('content')

    <div class="categories row">
        @foreach ($category->stocks as $stock)
            @php($t = $stock->translates()->where('language_code', App::getLocale())->first())
            <article class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                <a href="{{url('/video/' . $category_slug . '/' . $t->slug)}}">
                    <h2>{{$t->meta_title}}</h2>
                    @if(!empty($stock->images))
                        <figure><img src="{{$stock->images['500_500']['url']}}" class="img-responsive" /></figure>
                    @endif
                    <div class="title">{{$t->meta_title}}</div>
                </a>
            </article>
        @endforeach
    </div>
@endsection