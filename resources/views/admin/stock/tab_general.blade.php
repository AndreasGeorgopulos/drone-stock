<div class="tab-pane @if(old('tab', 'general_data') == 'general_data') active @endif" id="general_data">
    <div class="col-md-6">
        <div class="form-group">
            <label>{{trans('admin.Név')}}*</label>
            <input type="text" name="name" class="form-control" value="{{old('name', $model->name)}}" />
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>{{trans('admin.Kategória')}}*</label>
            <select class="form-control select2" name="category_id">
                <option value="0"></option>
                @foreach ($categories as $cat)
                    <option value="{{$cat->id}}" @if(old('category_id', $model->category_id) == $cat->id) selected="selected" @endif>{{$cat->translates()->where('language_code', App::getLocale())->first()->meta_title}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="col-md-3">
        <div class="form-group">
            <label>{{trans('admin.Klip hossza')}}*</label>
            <input type="text" name="clip_length" class="form-control" value="{{old('clip_length', $model->clip_length)}}" />
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
            <label>{{trans('admin.Képarány')}}*</label>
            <input type="text" name="aspect_ratio" class="form-control" value="{{old('aspect_ratio', $model->aspect_ratio)}}" />
        </div>
    </div>

    <div class="form-group col-md-3">
        <label>{{trans('admin.Aktív')}}</label>
        <select class="form-control select2" name="translate[{{$lang}}][active]">
            <option value="1" @if(old('active', $model->active) == 1) selected="selected" @endif>{{trans('admin.Igen')}}</option>
            <option value="0" @if(old('active', $model->active) == 0) selected="selected" @endif>{{trans('admin.Nem')}}</option>
        </select>
    </div>


    <div class="clearfix"></div>
</div>