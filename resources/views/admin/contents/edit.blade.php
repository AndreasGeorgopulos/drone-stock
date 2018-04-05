@extends('admin.index')
@section('content_header')
    <h1>{{trans('admin.Tartalom')}}: @if($model->id) {{$model->title}} [{{$model->id}}] @else {{trans('admin.Új')}} @endif</h1>
@stop

@section('content')
    <form method="post">
        {{csrf_field()}}
        @include('admin.layout.messages')
        <div class="box">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#general_data" data-toggle="tab" aria-expanded="true">{{trans('admin.Általános adatok')}}</a></li>

                    @foreach (config('app.languages') as $lang)
                        <li class=""><a href="#{{$lang}}_data" data-toggle="tab" aria-expanded="false">{{trans('admin.' . $lang)}}</a></li>
                    @endforeach
                </ul>
                <div class="tab-content">
                    @include('admin.contents.tab_general')
                    @include('admin.contents.tab_translates')
                </div>
            </div>

            <div class="box-footer">
                <a href="{{url(route('admin_contents_list'))}}" class="btn btn-default">{{trans('admin.Vissza')}}</a>
                <button type="submit" class="btn btn-info pull-right">{{trans('admin.Mentés')}}</button>
            </div>
        </div>
    </form>
@endsection

@section('js')
    <script type="text/javascript">
        $('textarea.wysig').wysihtml5();
    </script>
@endsection