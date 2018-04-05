<div class="box-body">
    <div class="dataTables_wrapper form-inline dt-bootstrap">
        @include('admin.layout.table.header')
        <div class="row">
            <div class="col-sm-12">
                <table class="table table-bordered table-striped dataTable">
                    <thead>
                    <tr role="row">
                        <th class="@if($sort == 'id') sorting_{{$direction}} @else sorting @endif" data-column="id">#</th>
                        <th class="@if($sort == 'name') sorting_{{$direction}} @else sorting @endif" data-column="name">{{trans('admin.Név')}}</th>
                        <th class="@if($sort == 'email') sorting_{{$direction}} @else sorting @endif" data-column="email">{{trans('admin.E-mail')}}</th>
                        <th>
                            <a href="{{url(route('admin_users_edit'))}}" class="btn btn-primary btn-sm pull-right"><i class="fa fa-plus"></i> {{trans('admin.Új felhasználó')}}</a>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($list as $model)
                        <tr role="row" class="odd">
                            <td>{{$model->id}}</td>
                            <td class="sorting_1">{{$model->name}}</td>
                            <td>{{$model->email}}</td>
                            <td>
                                <div class="btn-group pull-right">
                                    <button type="button" class="btn btn-primary btn-sm">{{trans('admin.Műveletek')}}</button>
                                    <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                        <span class="caret"></span>
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="{{url(route('admin_users_edit', ['id' => $model->id]))}}"><i class="fa fa-edit"></i> {{trans('admin.Szerkesztés')}}</a></li>
                                        <li><a href="{{url(route('admin_users_force_login', ['id' => $model->id]))}}" class="confirm"><i class="fa fa-user"></i> {{trans('admin.Bejelentkezés, mint...')}}</a></li>
                                        <li class="divider"></li>
                                        <li><a href="{{url(route('admin_users_delete', ['id' => $model->id]))}}" class="confirm"><i class="fa fa-trash"></i> {{trans('admin.Törlés')}}</a></li>
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