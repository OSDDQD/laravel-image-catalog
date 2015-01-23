@if (Menu::getCollection()->has('ClientFooterMenu'))
    @foreach(Menu::getCollection()->get('ClientFooterMenu')->roots() as $root)
        <menu>
        <li><p>{{ $root->title }}</p></li>
        @if ($root->hasChildren())
            @foreach($root->children() as $item)
                <li>
                    <a href="{{ isset($item->link->path['url']) ? $item->link->path['url'] : URL::Route($item->link->path['route'][0], ['slug' => $item->link->path['route']['slug']]) }}">
                        {{ $item->title }}
                    </a>
                </li>
            @endforeach
        @endif
        </menu>
    @endforeach
@endif