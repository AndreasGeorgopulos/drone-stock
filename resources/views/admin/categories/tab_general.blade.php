<div class="tab-pane @if(old('tab', 'general_data') == 'general_data') active @endif" id="general_data">
    <div class="col-md-6">
        <div class="form-group">
            <label>{{trans('admin.Név')}}*</label>
            <input type="text" name="name" class="form-control" value="{{old('name', $model->name)}}" />
        </div>
    </div>

    <div class="form-group col-md-2">
        <label>{{trans('admin.Aktív')}}</label>
        <select class="form-control select2" name="active">
            <option value="1" @if(old('active', $model->active) == 1) selected="selected" @endif>{{trans('admin.Igen')}}</option>
            <option value="0" @if(old('active', $model->active) == 0) selected="selected" @endif>{{trans('admin.Nem')}}</option>
        </select>
    </div>

    <div class="clearfix"></div>
</div>