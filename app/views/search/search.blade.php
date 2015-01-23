@extends('layouts.client_noslider')

@section('content')
<div class="resultSearch">
    <div class="resultTop">
        <h1>{{ Lang::get('client.search.results_header') }}</h1>
        <menu class="menuResult">
            @foreach ($scopes as $scope)
                <li{{ $scope == $where ? ' class="active"' : null }}>
                    <a href="{{ URL::Route('search', ['q' => $query, 'where' => $scope]) }}">{{ Lang::get("client.search.scopes.$scope") }}</a>
                </li>
            @endforeach
            <div class="clear"></div>
        </menu>
    </div>
    @if ($results)
        @include("search.partials.$where")
        {{ $results->appends(['q' => $query])->links() }}
    @else
        <p class="searchErr">{{ Lang::get('search.err.search_error') }}</p>
    @endif
</div>
@stop