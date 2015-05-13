<ul id="main-menu">
    <li class="menu-item"><a href="{{ URL::Route('home') }}/#intro"><img src="/assets/img/intro.png" /></a></li>
    @foreach($entity as $category)
        <li id="menu-item-{{ $category->id }}" class="menu-item scroll"><a href="{{ URL::Route('home') }}#{{ $category->id }}">{{ $category->title }}</a></li>
    @endforeach
</ul><!-- #main-menu -->