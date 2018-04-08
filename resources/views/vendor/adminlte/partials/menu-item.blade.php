@php
    $can = true;
    if (isset($item['roles']) && is_array($item['roles']) && !Auth::user()->roles()->where('key', 'superadmin')->first()) {
		$query = Auth::user()->roles();
    	foreach ($item['roles'] as $index => $role) {
    		if (!$index) $query = $query->where('key', $role);
    		else $query = $query->orWhere('key', $role);
        }
    	if (!$query->count()) {
			$can = false;
        }
    }
@endphp

@if ($can)
    @if (is_string($item))
        <li class="header">{{ trans('admin.' . $item) }}</li>
    @else
        <li class="{{ $item['class'] }}">
            <a href="{{ !empty($item['route']) ? url(route($item['route'])) : '#' }}" @if (isset($item['target'])) target="{{ $item['target'] }}" @endif>
                <i class="fa fa-fw fa-{{ $item['icon'] or 'circle-o' }} {{ isset($item['icon_color']) ? 'text-' . $item['icon_color'] : '' }}"></i>
                <span>{{ trans('admin.' . $item['text']) }}</span>
                @if (isset($item['label']))
                    <span class="pull-right-container">
                        <span class="label label-{{ $item['label_color'] or 'primary' }} pull-right">{{ $item['label'] }}</span>
                    </span>
                @elseif (isset($item['submenu']))
                    <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                    </span>
                @endif
            </a>
            @if (isset($item['submenu']))
                <ul class="{{ $item['submenu_class'] }}">
                    @each('adminlte::partials.menu-item', $item['submenu'], 'item')
                </ul>
            @endif
        </li>
    @endif
@endif
