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
        {{ Form::label(Lang::get('forms.labels.page_menu_select'), '', ['class' => 'control-label']) }}
        <select id="menu" class="form-control">
            @foreach (Structure\Menu::all() as $menu)
            <option{{ $menu->id == $currentMenu ? ' selected="selected"' : null }} value="{{ $menu->id }}">{{ $menu->title }}</option>
            @endforeach
        </select>
    </div>
    <div class="clearfix"></div>

    <script>
    $('#menu').on('change', function() {
        location.assign('{{ URL::Route("manager.structure.pages.index", ['id' => 0]) }}'.replace(0, $(this).val()));
    });
    </script>
</div>
@stop