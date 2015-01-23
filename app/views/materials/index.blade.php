@extends('manager.index')

@section('toolbar')
<div class="navbar navbar-btn">
    @if (isset($toolbar))
        @foreach($toolbar as $button)
            <a href="{{ URL::Route($button['route'], (isset($button['routeParams']) ? $button['routeParams'] : null)) }}"><button class="btn-large btn-{{ $button['class'] }} btn">{{ $button['label'] }}</button></a>
        @endforeach
    @else
        <a href="{{ URL::Route("manager.$routeSlug.create", (isset($createRouteParams) ? $createRouteParams : null)) }}"><button class="btn-large btn-success btn">{{ Lang::get('buttons.create') }}</button></a>
    @endif
    <div class="pull-right form form-inline">
        {{ Form::label(Lang::get('forms.labels.material_type_select'), '', ['class' => 'control-label']) }}
        <select id="type" class="form-control">
            <option value="">{{ Lang::get('fields.material.types._all') }}</option>
            @foreach ($possibleTypes as $type => $label)
            <option{{ $type == $currentType ? ' selected="selected"' : null }} value="{{ $type }}">{{ $label }}</option>
            @endforeach
        </select>
    </div>
    <div class="clearfix"></div>

    <script>
    $('#type').on('change', function() {
        location.assign('{{ URL::Route("manager.$routeSlug.index") }}/' + $(this).val());
    });
    </script>
</div>
@stop