@extends('admin.index')
@section('content_header')
    <h1>{{trans('frontend.Felhasználók')}}</h1>
@stop

@section('content')
    @include('admin.layout.table.index')
@endsection