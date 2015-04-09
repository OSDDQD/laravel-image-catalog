<ul id="main-menu">
    @foreach($entity as $category)
        <li id="menu-item-{{ $category->id }}" class="menu-item scroll"><a href="{{ URL::Route('home') }}#{{ $category->id }}">{{ $category->title }}</a></li>
    @endforeach
</ul><!-- #main-menu -->