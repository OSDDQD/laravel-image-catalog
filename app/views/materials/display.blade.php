@extends('layouts.' . ($backPage ? $backPage->template : 'client_wslider'))

@section('content')
    @if ($backPage)
    <h1>{{ $backPage->title }}</h1>
    @endif

    @include('materials.news')

    @if ($backPage)
    <a href="{{ URL::Route('pages.display', ['slug' => $backPage->slug]) }}">{{ Lang::get('buttons.back_to_list') }}</a>
    @endif
@stop