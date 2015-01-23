<form action="{{ URL::Route('search') }}" method="get" class="form-search">
    <div class="searchFormBlock">
        <input class="search-class" type="text" name="q" placeholder="{{ Lang::get('forms.labels.search_site') }}"/>
    </div>
    <input type="submit" value="" class="searchSub"/>
</form>