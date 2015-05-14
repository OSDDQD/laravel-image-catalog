<?php $items = \Catalog\Category::with('translations')->whereIsVisible(true)->whereIsIntro(false)->orderBy('position')->get(); ?>
<ul id="main-menu">
    <li class="menu-item"><a href="{{ URL::Route('home') }}/#intro"><img src="/assets/img/intro.png" /></a></li>
    @foreach($items as $item)
        <li id="menu-item-{{ $item->id }}" class="menu-item scroll"><a href="{{ URL::Route('home') }}#{{ $item->id }}">{{ $item->title }}</a></li>
    @endforeach
</ul><!-- #main-menu -->