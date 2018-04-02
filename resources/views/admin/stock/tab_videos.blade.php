<div class="tab-pane @if(old('tab', 'general_data') == 'video_data') active @endif" id="video_data">
    <div class="col-md-12">{{trans('admin.A videó file-ok webes feltöltésére nincs lehetőség a nagy file méretek miatt. ')}}</div>
    <div class="clearfix"></div>
    <hr class="hr" />

    @if(count($video_files))
        <div class="col-md-4">
            <h3 class="text-center">{{trans('admin.Videó rögzítése')}}</h3>
            <div class="form-group col-md-12">
                <label>{{trans('admin.File')}}*</label>
                <input type="text" class="form-control input-sm" id="file_name" name="stock_size[file_name]" value="{{old('stock_size.file_name', '')}}" readonly />
            </div>

            <div class="form-group col-md-12">
                <label>{{trans('admin.Méret')}}*</label>
                <input type="text" class="form-control input-sm" id="file_size" name="stock_size[file_size]" value="{{old('stock_size.file_size', '')}}" readonly />
            </div>

            <div class="form-group col-md-6">
                <label>{{trans('admin.Név')}}*</label>
                <select class="form-control select2 input-sm" name="stock_size[name]">
                    <option value=""></option>
                    @foreach (config('vstock.names') as $name)
                        <option value="{{$name}}" @if(old('stock_size.name', '') == $name) selected="selected" @endif>{{$name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-md-6">
                <label>{{trans('admin.Típus')}}*</label>
                <select class="form-control select2 input-sm" name="stock_size[type]">
                    <option value=""></option>
                    @foreach (config('vstock.types') as $type)
                        <option value="{{$type}}" @if(old('stock_size.type', '') == $type) selected="selected" @endif>{{$type}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-md-6">
                <label>{{trans('admin.Méret')}}*</label>
                <input type="text" class="form-control input-sm" name="stock_size[size]" value="{{old('stock_size.size', '')}}" />
            </div>

            <div class="form-group col-md-6">
                <label>{{trans('admin.Fps')}}*</label>
                <input type="text" class="form-control input-sm" name="stock_size[fps]" value="{{old('stock_size.fps', '')}}" />
            </div>
            <div class="clearfix"></div>

            <div class="form-group col-md-12 text-right">
                <button class="btn btn-default">{{trans('admin.Rögzít')}}</button>
            </div>
        </div>

        <div class="col-md-8">
            <h3 class="text-center">{{trans('admin.Feltöltött file-ok')}}</h3>
            <div style="overflow: auto; height: 300px;">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>{{trans('admin.Törlés')}}</th>
                        <th>{{trans('admin.File')}}</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($video_files as $file)
                        <tr>
                            <td><input type="checkbox" name="delete_files[]" value="{{str_replace('\\', '/', $file->getRelativePathname())}}" /></td>
                            <td>{{str_replace('\\', '/', $file->getRelativePathname())}}</td>

                            <td><input type="button" class="btn btn-default btn-sm btn_file pull-right" value="{{trans('admin.Kiválaszt')}}" data-file-name="{{str_replace('\\', '/', $file->getRelativePathname())}}" data-file-size="{{$file->getSize()}}" /></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="clearfix"></div>
        <hr class="hr" />
    @endif

    @if($model->sizes()->count())
        <h3 class="text-center">Rögzített file-ok</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>{{trans('admin.Törlés')}}</th>
                    <th>{{trans('admin.Név')}}</th>
                    <th>{{trans('admin.Típus')}}</th>
                    <th>{{trans('admin.Méret')}}</th>
                    <th>{{trans('admin.Fps')}}</th>
                    <th>{{trans('admin.Filenév')}}</th>
                    <th>{{trans('admin.Fileméret')}}</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($model->sizes()->get() as $size)
                <tr>
                    <td><input type="checkbox" name="delete_stock_sizes[]" value="{{$size->id}}" /></td>
                    <td>{{$size->name}}</td>
                    <td>{{$size->type}}</td>
                    <td>{{$size->size}}</td>
                    <td>{{$size->fps}}</td>
                    <td>{{$size->file_name}}</td>
                    <td>{{fileFormatedSize($size->file_size)}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
</div>