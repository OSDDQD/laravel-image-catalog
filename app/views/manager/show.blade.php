@extends('layouts.manager')

@section('page-header')
{{ Lang::get('manager.actions.show', ['entity' => Lang::choice("entities.$slug.gen", 1)]) }}
@stop

@section('content')
@include("$routeSlug.partials.show", ['entity' => $entity])
@stop