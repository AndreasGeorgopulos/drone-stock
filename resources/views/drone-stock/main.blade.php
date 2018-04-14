@extends('drone-stock.index')
@section('content')

    <div class="categories row">
        @foreach ($categories as $c)
            @php($t = $c->translates()->where('language_code', App::getLocale())->first())
            @continue(!$t->active)
            <article class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                <a href="{{url('/video/' . $t->slug)}}">
                    <h2>{{$t->meta_title}}</h2>
                    @if(!empty($c->images))
                        <figure><img src="{{$c->images['500_500']['url']}}" class="img-responsive" /></figure>
                    @endif
                    <div class="title">{{$t->meta_title}}</div>
                </a>
            </article>
        @endforeach
        <div class="clearfix"></div>
    </div>

@endsection