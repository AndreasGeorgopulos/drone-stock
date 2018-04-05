<div class="tab-pane" id="user_data">
    <p>{{trans('admin.Válasszd ki azokat a jogosultságokat, amelyekkel ez a felhasználó rendelkezhet.')}}</p>
    <div class="form-group" style="height: 200px; overflow: auto;">
        @foreach ($roles as $role)
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="roles[]" value="{{$role->id}}" @if($model->roles()->where('role_id', $role->id)->first()) checked="checked" @endif>
                    {{$role->translates()->where('language_code', App::getLocale())->first()->name}}
                </label>
            </div>
        @endforeach
    </div>
    <div class="clearfix"></div>
</div>