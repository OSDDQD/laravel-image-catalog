@extends('layouts.manager')

@section('page-header')
{{ Lang::get('manager.actions.edit', ['entity' => Lang::choice("entities.$slug.gen", 1)]) }}
@stop

@section('content')
@if ($errors->count())
    <div class="bg-danger alert-danger text-center alert">{{ Lang::get('manager.messages.form_submit_errors') }}</div>
@endif
@include("$routeSlug.partials.form", ['entity' => $entity])
@stop