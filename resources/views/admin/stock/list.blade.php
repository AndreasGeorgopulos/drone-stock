<div class="box-body">
    <div class="dataTables_wrapper form-inline dt-bootstrap">
        @include('admin.layout.table.header')
        <div class="row">
            <div class="col-sm-12">
                <table class="table table-bordered table-striped dataTable">
                    <thead>
                    <tr role="row">
                        <th class="@if($sort == 'id') sorting_{{$direction}} @else sorting @endif" data-column="id">#</th>
                        <th class="@if($sort == 'name') sorting_{{$direction}} @else sorting @endif" data-column="name">{{trans('admin.Cím')}}</th>
                        <th class="@if($sort == 'clip_length') sorting_{{$direction}} @else sorting @endif" data-column="clip_length">{{trans('admin.Klip hossza')}}</th>
                        <th class="@if($sort == 'aspect_ratio') sorting_{{$direction}} @else sorting @endif" data-column="aspect_ratio">{{trans('admin.Képarány')}}</th>
                        <th>{{trans('admin.Rögzített file-ok')}}</th>
                        <th>
                            <a href="{{url(route('admin_stock_edit'))}}" class="btn btn-primary btn-sm pull-right"><i class="fa fa-plus"></i> {{trans('admin.Új v-stock')}}</a>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($list as $model)
						<?php $translate = $model->translates()->where('language_code', App::getLocale())->first(); ?>
                        <tr role="row" class="odd">
                            <td>{{$model->id}}</td>
                            <td>{{$model->name}}</td>
                            <td>{{$model->clip_length}}</td>
                            <td>{{$model->aspect_ratio}}</td>
                            <td>{{$model->sizes()->count()}}</td>
                            <td>
                                <div class="btn-group pull-right">
                                    <button type="button" class="btn btn-primary btn-sm">{{trans('admin.Műveletek')}}</button>
                                    <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                        <span class="caret"></span>
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="{{url(route('admin_stock_edit', ['id' => $model->id]))}}"><i class="fa fa-edit"></i> {{trans('admin.Szerkesztés')}}</a></li>
                                        <li class="divider"></li>
                                        <li><a href="{{url(route('admin_stock_delete', ['id' => $model->id]))}}" class="confirm"><i class="fa fa-trash"></i> {{trans('admin.Törlés')}}</a></li>
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