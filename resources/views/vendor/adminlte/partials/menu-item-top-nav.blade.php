@if (is_array($item))
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
        <li class="{{ $item['top_nav_class'] }}">
            <a href="{{ !empty($item['route']) ? url(route($item['route'])) : '#' }}"
               @if (isset($item['submenu'])) class="dropdown-toggle" data-toggle="dropdown" @endif
               @if (isset($item['target'])) target="{{ $item['target'] }}" @endif
            >
                <i class="fa fa-fw fa-{{ $item['icon'] or 'circle-o' }} {{ isset($item['icon_color']) ? 'text-' . $item['icon_color'] : '' }}"></i>
                {{ trans('admin.' . $item['text']) }}
                @if (isset($item['label']))
                    <span class="label label-{{ $item['label_color'] or 'primary' }}">{{ $item['label'] }}</span>
                @elseif (isset($item['submenu']))
                    <span class="caret"></span>
                @endif
            </a>
            @if (isset($item['submenu']))
                <ul class="dropdown-menu" role="menu">
                    @foreach($item['submenu'] as $subitem)
						<?php
						$can = true;
						if (isset($subitem['role']) && !Auth::user()->roles()->where('key', $subitem['role'])->first()) {
							if (!Auth::user()->roles()->where('key', 'superadmin')->first()) {
								$can = false;
							}
						}
						?>
                        @if ($can)
                            @if (is_string($subitem))
                                @if($subitem == '-')
                                    <li role="separator" class="divider"></li>
                                @else
                                    <li class="dropdown-header">{{ $subitem }}</li>
                                @endif
                            @else
                            <li class="{{ $subitem['top_nav_class'] }}">
                                <a href="{{ !empty($item['route']) ? url(route($item['route'])) : '#' }}">
                                    <i class="fa fa-{{ $subitem['icon'] or 'circle-o' }} {{ isset($subitem['icon_color']) ? 'text-' . $subitem['icon_color'] : '' }}"></i>
                                    {{ trans('admin.' . $subitem['text']) }}
                                    @if (isset($subitem['label']))
                                        <span class="label label-{{ $subitem['label_color'] or 'primary' }}">{{ $subitem['label'] }}</span>
                                    @endif
                                </a>
                            </li>
                            @endif
                        @endif
                    @endforeach
                </ul>
            @endif
        </li>
    @endif
@endif
