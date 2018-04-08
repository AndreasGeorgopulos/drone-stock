<div class="tab-pane @if(old('tab', 'general_data') == 'image') active @endif" id="image">
    <div class="col-md-6">
        <div class="form-group">
            <label>{{trans('admin.Új indexkép feltöltése')}}</label>
            <input type="file" name="indexImage" class="form-control" />
        </div>

        @if (!empty($indexImages))
            <div class="form-group">
                <label>{{trans('admin.Indexkép méretek')}}</label>
                <table class="table table-striped">
                    <tbody>
                        @foreach ($indexImages as $key => $value)
                            <tr>
                                <td>{{$value['size']}}</td>
                                <td><a href="{{$value['url']}}" target="_blank">{{$value['url']}}</a></td>
                                <td></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    @if (!empty($indexImages))
        <div class="col-md-6">
            <div class="form-group">
                <label>{{trans('admin.Feltöltött indexkép')}}</label>
                <img class="img img-responsive" src="{{$indexImages['original']['url']}}" />
            </div>

            <div class="form-group">
                <label><input type="checkbox" name="delete_indexImage" /> {{trans('admin.Kép törlése')}}</label>
            </div>
        </div>
    @endif
    <div class="clearfix"></div>

    <div class="col-md-8">
        <table class="table table-striped">
            <tbody>
            @foreach ($settings as $s)
                <tr>
                    <td><b>{{$s['title']}}</b></td>
                    <td>{{$s['value']}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="clearfix"></div>

</div>