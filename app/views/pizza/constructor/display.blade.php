{{ $jsonMenu }}
<div class="wrapper">
    <div class="constructor">
        <div class="texture">
            <div class="categories">
                <ul>
                    @foreach ($categories as $category)
                    <li>
                        <a href="#">{{ $category->title }}</a>
                        <ul>
                            @foreach ($category->ingredients as $ingredient)
                                {{ $ingredient->title }}<br />
                                @foreach($ingredient->options as $option)
                                    {{ $option }}<br />
                                @endforeach
                            @endforeach
                        </ul>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>