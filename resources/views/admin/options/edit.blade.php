@extends('admin.index')
@section('content_header')
    <h1>{{trans('admin.Opció')}}: @if($model->id) {{$model->lq_key}} [{{$model->id}}] @else {{trans('admin.Új')}} @endif</h1>
@stop

@section('content')
    <form method="post">
        {{csrf_field()}}
        @include('admin.layout.messages')
        <div class="box">
            <div class="col-md-6">
                <div class="form-group">
                    <label>{{trans('admin.Kulcs')}}*</label>
                    <input type="text" name="lq_key" class="form-control" value="{{old('lq_key', $model->lq_key)}}" />
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label>{{trans('admin.Érték')}}*</label>
                    <textarea name="lq_value" class="form-control">{{old('lq_value', $model->lq_value)}}</textarea>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label>{{trans('admin.Megjegyzés')}}*</label>
                    <textarea name="notice" class="form-control">{{old('notice', $model->notice)}}</textarea>
                </div>
            </div>
            <div class="clearfix"></div>

            <div class="box-footer">
                <a href="{{url(route('admin_options_list'))}}" class="btn btn-default">{{trans('admin.Vissza')}}</a>
                <button type="submit" class="btn btn-info pull-right">{{trans('admin.Mentés')}}</button>
            </div>
        </div>
    </form>
@endsection