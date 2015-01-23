<tr>
    <td>{{ Form::checkbox("id[$i]", $entity->id, 0, ['class' => 'select-row']) }}</td>
    <td>
        @if (isset($fieldAsIndex))
            {{--*/ $index = $entity->$fieldAsIndex /*--}}
        @else
            @if (method_exists($entities, 'getPerPage'))
                {{--*/ $index = $i + $entities->getPerPage() * ($entities->getCurrentPage() - 1) + 1 /*--}}
            @else
                {{--*/ $index = $i + 1 /*--}}
            @endif
        @endif
        {{ isset($iPrefix) ? $iPrefix : null }}{{ $index }}
    </td>
    @foreach ($fields as $field)
    <td>
        @if (!is_array($field))
            @include('manager.partials.index_td_field')
        @else
            @include('manager.partials.index_td_field', ['field' => $field[0], 'options' => $field[1]])
        @endif
    </td>
    @endforeach
    <td>
        @if (isset($actions))
            @foreach ($actions as $action => $params)
            @if (is_numeric($action))
                <?php $action = $params; ?>
            @endif
            <a class="btn btn-xs btn-{{ isset($params['class']) ? $params['class'] : 'primary' }}" href="{{
                URL::Route((isset($params['route']) ? $params['route'] : "manager.$routeSlug.$action"),
                (isset($editRouteParams) ? array_merge($editRouteParams, ['id' => $entity->id]) : ['id' => $entity->id]))
            }}">{{ isset($params['label']) ? $params['label'] : Lang::get('buttons.'.$action) }}</a>
            @endforeach
        @endif
    </td>
</tr>
@if (isset($nested) and $nested == true)
    @foreach ($entity->subEntities as $subEntity)
    @include ('manager.partials.index_tr', ['entity' => $subEntity, 'iPrefix' => (isset($iPrefix) ? $iPrefix . $index.'.' : $index.'.')])
    @endforeach
@endif