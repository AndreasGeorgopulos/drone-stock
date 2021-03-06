<div class="col-md-6">
    <div class="form-group">
        <label>{{trans('admin.Név')}}</label>
        <input type="text" name="name" class="form-control" value="{{old('name', $model->name)}}" />
    </div>
    <div class="form-group">
        <label>{{trans('admin.E-mail cím')}}</label>
        <input type="email" class="form-control" name="email" value="{{old('email', $model->email)}}" />
    </div>
    <div class="form-group">
        <label>{{trans('admin.Aktív')}}</label>
        <select class="form-control select2" name="active">
            <option value="1" @if(old('active', $model->active) == 1) selected="selected" @endif>{{trans('admin.Igen')}}</option>
            <option value="0" @if(old('active', $model->active) == 0) selected="selected" @endif>{{trans('admin.Nem')}}</option>
        </select>
    </div>
</div>

<div class="col-md-6">
    <div class="form-group">
        <label>{{trans('admin.Jelszó')}}</label>
        <input type="password" class="form-control" name="password" placeholder="" />
    </div>
    <div class="form-group">
        <label>{{trans('admin.Jelszó megerősítés')}}</label>
        <input type="password" class="form-control" name="password_confirmation" placeholder="" />
    </div>
</div>

<div class="clearfix"></div>