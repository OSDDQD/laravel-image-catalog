@extends('layouts.manager')

@section('page-header')
{{ Lang::get('manager.actions.index', ['entities' => Lang::choice("entities.$slug.gen", 2)]) }}
@stop

@section('content')
@include("$routeSlug.partials.form")
@stop