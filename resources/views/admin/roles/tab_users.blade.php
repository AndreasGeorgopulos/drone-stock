<div class="tab-pane" id="user_data">
    <p>{{trans('admin.Válassza ki ctrl+bal egérgomb segítségével azokat a felhasználókat, akik ehhez a jogosultsághoz tartoznak.')}}</p>
    <div class="form-group" style="height: 200px; overflow: auto;">
        @foreach ($users as $u)
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="role_users[]" value="{{$u->id}}" @if($u->roles()->where('role_id', $model->id)->first()) checked="checked" @endif>
                    {{$u->name}} [{{$u->id}}]
                </label>
            </div>
        @endforeach
    </div>
    <div class="clearfix"></div>
</div>