@extends('admin.index')
@section('content_header')
    <h1>{{trans('admin.Tartalmak')}} / {{trans('admin.Kategóriák')}}</h1>
@stop

@section('content')
    @include('admin.layout.table.index')
@endsection