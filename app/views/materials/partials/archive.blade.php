@extends('layouts.client_wslider')

@section('content')
<h2 class="pageHead">{{ Lang::get('components.archive._title') }}</h2>
<div class="contentSeparator">
@foreach ($entities as $entity)
    <div class="newsArchive">
        <h3 class="anonsTitle">
            <a href="{{ URL::Route('materials.news.display', ['id' => $entity->id]) }}">{{ $entity->title }}</a>
        </h3>
        {{ (isset($textShorten) and (int) $textShorten) ?
            mb_substr(strip_tags($entity->text, '<p><div><span><br>'), 0, (int) $textShorten, 'UTF-8') . '&hellip;' :
            $entity->text }}
        <div class="readmore">
            <a href="{{ URL::Route('materials.news.display', ['id' => $entity->id]) }}">{{ Lang::get('buttons.read_more') }}</a>
        </div>
    </div>
@endforeach
</div>

@if (method_exists($entities, 'links'))
    <div class="paginationSeparator right">
        {{ $entities->links() }}
    </div>
@endif

@stop