@extends('drone-stock.index')
@section('content')

    <div class="video">
        @if(!empty($stock->images))
            <figure><img src="{{$stock->images['500_500']['url']}}" class="img-responsive" /></figure>
        @endif
        <p>{!! $t->lead !!}</p>
        <p>{!! $t->body !!}</p>

            <table class="table table-bordered">
                <tbody>
        @foreach ($stock->sizes()->where('active', 1)->get() as $size)
            <tr>
                <td><input type="radio" value="{{$size->id}}" /></td>
                <td>{{$size->name}}</td>
                <td>{{$size->price}}</td>
                <td>{{$size->size}} @ {{$size->fps}} fps {{$size->type}}</td>
                <td>{{fileFormatedSize($size->file_size)}}</td>
            </tr>
        @endforeach
                </tbody>
            </table>

    </div>
@endsection