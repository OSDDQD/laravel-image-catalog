<div class="wrapper">
    <div class="constructor">
        <div class="texture">
            <div class="categories">
                <ul>
                    @foreach ($items as $item)
                        <li class="category">
                            <a href="#">{{ $item['title'] }}</a>
                            <div class="submenu">
                                <ul>
                                    @foreach ($item['ingredient'] as $ingredient)
                                        <li>
                                            <a href="#"
                                                @if(!empty($ingredient['image']))data-image="{{ $ingredient['image'] }}" @endif
                                                @if(isset($ingredient['base']))data-base="1" @endif
                                                data-id="{{ $ingredient['id'] }}"
                                                @if(isset($ingredient['size']))data-size="{{ $ingredient['size'] }}" @endif
                                                @if(isset($ingredient['max_weight']))data-max-weight="{{ $ingredient['max_weight'] }}" @endif
                                                @if(isset($ingredient['price']))data-price="{{ $ingredient['price'] }}" @endif
                                                @if(isset($ingredient['title']))data-title="{{ $ingredient['title'] }}" @endif
                                            >
                                                <span>{{ $ingredient['title'] }}</span>
                                                @if(isset($ingredient['size']))<span>{{ $ingredient['size'] }}</span>@endif
                                                @if(isset($ingredient['price']))<span>{{ $ingredient['price'] }}</span>@endif
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="main">
                <div class="presentation">
                </div>
                <div class="structure">
                    <div class="clip"></div>
                    <div id="list"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php var_dump($items); ?>
{{--@if (isset($ingredient['option']))--}}
{{--@foreach ($ingredient['option'] as $option)--}}
{{--@if(isset($option['pizza_id']))data-pizza-id="{{ $option['pizza_id'] }}" @endif--}}
{{--@if(isset($option['price']))data-price="{{ $option['price'] }}" @endif--}}
{{--@if(isset($option['max_quantity']))data-max-quantity="{{ $option['max_quantity'] }}" @endif--}}
{{--@if(isset($option['weight']))data-weight="{{ $option['weight'] }}" @endif--}}
{{--@endforeach--}}
{{--@endif--}}