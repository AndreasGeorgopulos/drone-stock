@extends('admin.index')
@section('content_header')
    <h1>{{trans('admin.Jogosultság')}}: @if($model->id) {{$model->key}} [{{$model->id}}] @else {{trans('admin.Új')}} @endif</h1>
@stop

@section('content')
    <form method="post" class="col-md-6 col-md-offset-3">
        {{csrf_field()}}
        @include('admin.layout.messages')
        <div class="box">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#general_data" data-toggle="tab" aria-expanded="true">{{trans('admin.Általános adatok')}}</a>
                    </li>

                    @foreach (config('app.languages') as $lang)
                        <li class="">
                            <a href="#{{$lang}}_data" data-toggle="tab" aria-expanded="false">{{trans('admin.' . $lang)}}</a>
                        </li>
                    @endforeach

                    @if ($model->id)
                        <li class="">
                            <a href="#acl_data" data-toggle="tab" aria-expanded="false">{{trans('admin.ACl-ek')}}</a>
                        </li>
                        <li class="">
                            <a href="#user_data" data-toggle="tab" aria-expanded="false">{{trans('admin.Felhasználók')}}</a>
                        </li>
                    @endif
                </ul>
                <div class="tab-content">
                    @include('admin.roles.tab_general')
                    @include('admin.roles.tab_translates')
                    @if ($model->id)
                        @include('admin.roles.tab_acls')
                        @include('admin.roles.tab_users')
                    @endif
                </div>
            </div>

            <div class="box-footer">
                <a href="{{url(route('admin_roles_list'))}}" class="btn btn-default">{{trans('admin.Vissza')}}</a>
                <button type="submit" class="btn btn-info pull-right">{{trans('admin.Mentés')}}</button>
            </div>
        </div>
    </form>
@endsection