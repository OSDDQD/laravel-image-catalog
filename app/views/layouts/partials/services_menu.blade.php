<div class="services">
    @foreach($servicesMenu as $page)
    <figure class="servicesBlock">
        <a href="{{ $page->content_type == \Structure\Page::CONTENT_TYPE_LINK ? $page->content : URL::Route('pages.display', ['slug' => $page->slug]) }}">
            <img src="/assets/img/client/servicesBlock{{ $page->position }}.png" alt=""/>
            <figcaption>{{ $page->title }}</figcaption>
        </a>
    </figure>
    @endforeach
</div>