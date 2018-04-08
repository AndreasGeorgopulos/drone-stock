<div class="box-body">
    <div class="dataTables_wrapper form-inline dt-bootstrap">
        @include('admin.layout.table.header')
        <div class="row">
            <div class="col-sm-12">
                <table class="table table-bordered table-striped dataTable">
                    <thead>
                    <tr role="row">
                        <th class="@if($sort == 'id') sorting_{{$direction}} @else sorting @endif" data-column="id">#</th>
                        <th class="@if($sort == 'key') sorting_{{$direction}} @else sorting @endif" data-column="key">{{trans('admin.Kulcs')}}</th>
                        <th data-column="name">{{trans('admin.Érték')}}</th>
                        <th data-column="description">{{trans('admin.Megjegyzés')}}</th>
                        <th>
                            <a href="{{url(route('admin_options_edit'))}}" class="btn btn-primary btn-sm pull-right"><i class="fa fa-plus"></i> {{trans('admin.Új opció')}}</a>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($list as $model)
                        <tr role="row" class="odd">
                            <td>{{$model->id}}</td>
                            <td>{{$model->lq_key}}</td>
                            <td>{{$model->lq_value}}</td>
                            <td>{{$model->notice}}</td>
                            <td>
                                <div class="btn-group pull-right">
                                    <button type="button" class="btn btn-primary btn-sm">{{trans('admin.Műveletek')}}</button>
                                    <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                        <span class="caret"></span>
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="{{url(route('admin_options_edit', ['id' => $model->id]))}}"><i class="fa fa-edit"></i> {{trans('admin.Szerkesztés')}}</a></li>
                                        <li class="divider"></li>
                                        <li><a href="{{url(route('admin_options_delete', ['id' => $model->id]))}}" class="confirm"><i class="fa fa-trash"></i> {{trans('admin.Törlés')}}</a></li>
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