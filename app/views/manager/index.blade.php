@extends('layouts.manager')

@section('page-header')
{{ Lang::get('manager.actions.index', ['entities' => Lang::choice("entities.$slug.gen", 2)]) }}
    @if (isset($headerSubtext))
        <small>{{ $headerSubtext }}</small>
    @endif
@stop

@section('toolbar')
@if (!isset($toolbar) or $toolbar)
    <div class="navbar navbar-btn">
        @if (isset($toolbar))
            @foreach($toolbar as $button)
                <a href="{{ URL::Route($button['route'], (isset($button['routeParams']) ? $button['routeParams'] : null)) }}"><button class="btn-large btn-{{ $button['class'] }} btn">{{ $button['label'] }}</button></a>
            @endforeach
        @else
            <a href="{{ URL::Route("manager.$routeSlug.create", (isset($createRouteParams) ? $createRouteParams : null)) }}"><button class="btn-large btn-success btn">{{ Lang::get('buttons.create') }}</button></a>
        @endif
    </div>
@endif
@stop

@section('content')
@include('manager.partials.index_table')
@stop