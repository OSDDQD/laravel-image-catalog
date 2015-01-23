@extends('layouts.'.$page->template)

@section('services_menu')
    @if (isset($servicesMenu))
        <section class="lightGray">
            <div class="middle">
                @include('layouts.partials.services_menu')
            </div>
        </section>
	@endif
@stop

@section('content')
    @if (isset($pageTitle) and $pageTitle)
        <h2>{{ $pageTitle }}</h2>
    @endif
    @if ($page->content_type == 'material')
        @include("structure.pages.partials.$page->content_type")
    @elseif ($page->content_type == 'html')
        {{ $page->content }}
    @endif
@stop

@section('news_slider')
    @if (isset($latestNews))
        @include('materials.news_slider')
    @endif
@stop