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
</div>