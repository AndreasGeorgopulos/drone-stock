@extends('admin.index')
@section('content_header')
    <h1>{{trans('admin.V-Stock')}}: @if($model->id) {{$model->name}} [{{$model->id}}] @else {{trans('admin.Új')}} @endif</h1>
@stop

@section('content')
    <form method="post" enctype="multipart/form-data">
        {{csrf_field()}}
        <input type="hidden" name="tab" value="{{old('tab', 'general_data')}}" id="tab" />
        @include('admin.layout.messages')
        <div class="box">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li @if(old('tab', 'general_data') == 'general_data') class="active" @endif><a href="#general_data" data-toggle="tab" aria-expanded="true">{{trans('admin.Általános adatok')}}</a></li>

                    @foreach (config('app.languages') as $lang)
                        <li @if(old('tab', 'general_data') == $lang . '_data') class="active" @endif><a href="#{{$lang}}_data" data-toggle="tab" aria-expanded="false">{{trans('admin.' . $lang)}}</a></li>
                    @endforeach

                    <li @if(old('tab', 'general_data') == 'image') class="active" @endif><a href="#image" data-toggle="tab" aria-expanded="false">{{trans('admin.Index kép')}}</a></li>
                    <li @if(old('tab', 'general_data') == 'video_data') class="active" @endif><a href="#video_data" data-toggle="tab" aria-expanded="false">{{trans('admin.Video file-ok')}}</a></li>
                </ul>
                <div class="tab-content">
                    @include('admin.stock.tab_general')
                    @include('admin.stock.tab_translates')
                    @include('admin.layout.form.tab_indeximage')
                    @include('admin.stock.tab_videos')
                </div>
            </div>

            <div class="box-footer">
                <a href="{{url(route('admin_stock_list'))}}" class="btn btn-default">{{trans('admin.Vissza')}}</a>
                <button type="submit" class="btn btn-info pull-right">{{trans('admin.Mentés')}}</button>
            </div>
        </div>
    </form>
@endsection

@section('js')
    <script type="text/javascript">
        $('textarea.wysig').wysihtml5();

        $('.nav-tabs li a').on('click', function () {
            $('#tab').val($(this).attr('href').replace('#', ''));
        });

        $('.btn_file').on('click', function () {
            $('#file_name').val($(this).attr('data-file-name'));
            $('#file_size').val($(this).attr('data-file-size'));
        });
    </script>
@endsection