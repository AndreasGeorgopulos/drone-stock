<div class="box-body">
    <div class="dataTables_wrapper form-inline dt-bootstrap">
        @include('admin.layout.table.header')
        <div class="row">
            <div class="col-sm-12">
                <table class="table table-bordered table-striped dataTable">
                    <thead>
                    <tr role="row">
                        <th class="hidden-xs">{{trans('admin.Kép')}}</th>
                        <th class="@if($sort == 'id') sorting_{{$direction}} @else sorting @endif" data-column="id">#</th>
                        <th class="@if($sort == 'name') sorting_{{$direction}} @else sorting @endif" data-column="name">{{trans('admin.Név')}}</th>
                        <th class="hidden-xs text-center">{{trans('admin.Aktív')}}</th>
                        <th class="visible-lg">{{trans('admin.Feltöltő')}}</th>
                        <th class="visible-lg @if($sort == 'created_at') sorting_{{$direction}} @else sorting @endif" data-column="created_at">{{trans('admin.Feltöltve')}}</th>
                        <th class="visible-md visible-lg @if($sort == 'updated_at') sorting_{{$direction}} @else sorting @endif" data-column="updated_at">{{trans('admin.Módosítva')}}</th>
                        <th>
                            <a href="{{url(route('admin_categories_edit'))}}" class="btn btn-primary btn-sm pull-right"><i class="fa fa-plus"></i> {{trans('admin.Új kategória')}}</a>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($list as $model)
                        <?php $translate = $model->translates()->where('language_code', App::getLocale())->first(); ?>
                        <tr role="row" class="odd">
                            <td class="hidden-xs">@if(!empty($model->images['50_50']['url']))<img src="{{$model->images['50_50']['url']}}" />@endif</td>
                            <td>{{$model->id}}</td>
                            <td>{{$model->name}}</td>
                            <td class="hidden-xs text-center"><i class="fa @if($model->active) fa-check @else fa-square-o @endif"></i></td>
                            <td class="visible-lg">{{$model->uploader->name}}</td>
                            <td class="visible-lg">{{\Carbon\Carbon::createFromTimestamp(strtotime($model->created_at))->format(lqOption('datetime_format_' . App::getLocale(), 'Y.m.d @H:i'))}}</td>
                            <td class="visible-md visible-lg">{{\Carbon\Carbon::createFromTimestamp(strtotime($model->created_at))->format(lqOption('datetime_format_' . App::getLocale(), 'Y.m.d @H:i'))}}</td>
                            <td>
                                <div class="btn-group pull-right">
                                    <button type="button" class="btn btn-primary btn-sm">{{trans('admin.Műveletek')}}</button>
                                    <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                        <span class="caret"></span>
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="{{url(route('admin_categories_edit', ['id' => $model->id]))}}"><i class="fa fa-edit"></i> {{trans('admin.Szerkesztés')}}</a></li>
                                        <li class="divider"></li>

                                        @foreach(config('app.languages') as $lang)
                                            <li><a href="{{url('/video/' . $model->translates()->where('language_code', $lang)->first()->slug)}}" target="_blank"><i class="fa fa-external-link"></i> {{str_replace('[LANG]', trans('admin.' . $lang), trans('admin.Ugrás a [LANG] oldalra'))}}</a></li>
                                        @endforeach

                                        <li class="divider"></li>
                                        <li><a href="{{url(route('admin_categories_delete', ['id' => $model->id]))}}" class="confirm"><i class="fa fa-trash"></i> {{trans('admin.Törlés')}}</a></li>
                                    </ul>
                                </div>

                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @include('admin.layout.table.footer')
    </div>
</div>