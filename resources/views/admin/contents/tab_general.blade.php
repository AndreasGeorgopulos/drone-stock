<div class="tab-pane active" id="general_data">
    <div class="col-md-6">
        <div class="form-group">
            <label>{{trans('admin.Név')}}*</label>
            <input type="text" name="title" class="form-control" value="{{old('key', $model->title)}}" />
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>{{trans('admin.Kategória')}}*</label>
            <input disabled="disabled" type="text" name="title" class="form-control" value="{{old('key', $model->title)}}" />
        </div>
    </div>
    <div class="clearfix"></div>
</div>