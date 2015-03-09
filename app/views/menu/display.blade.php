<div class="catalog">
    <div class="category">
        <h2>{{ Lang::get('pizzas.pizzas') }}</h2>
        @foreach ($pizzas as $pizza)
            <div class="item">
                @if (isset($pizza->image))
                    <img class="preview" src="{{ \URL::Route('preview.managed', ['object' => 'pizza', 'mode' => 'frontend', 'format' => 'jpg', 'file' => $pizza->image]) }}" alt="" />
                @else
                    <img class="preview" src="/assets/img/client/logo_blank.png" alt="" />
                @endif
                <div class="title">{{ $pizza->title }}</div>
                <div class="description">{{ $pizza->description }}</div>
                <div class="data">
                    <span class="weight">{{ number_format($pizza->max_weight) }}{{ Lang::get('pizzas.numeric.gramm') }}</span>
                    <span class="price">{{ number_format($pizza->price) }} {{ Lang::get('pizzas.numeric.value') }}</span>
                    <a class="addtocart" href="#"><img src="/assets/img/client/cart.png" alt="{{ Lang::get('pizzas.additional.add') }}" /></a>
                </div>
            </div>
    @endforeach
    </div>
    @foreach ($additional as $category)
    <div class="category">
        <h2>{{ $category->title }}</h2>
        @foreach ($category->items as $item)
            <div class="item">
                 @if (isset($item->image))
                     <img class="preview" src="{{ \URL::Route('preview.managed', ['object' => 'menu-item', 'mode' => 'frontend', 'format' => 'jpg', 'file' => $item->image]) }}" alt="" />
                 @else
                      <img class="preview" src="/assets/img/client/logo_blank.png" alt="" />
                 @endif
                 <div class="title">{{ $item->title }}</div>
                 <div class="description">{{ $pizza->description }}</div>
                 <div class="data">
                    <span class="price">{{ number_format($item->price) }} {{ Lang::get('pizzas.numeric.value') }}</span>
                    <a class="addtocart" href="#"><img src="/assets/img/client/cart.png" alt="{{ Lang::get('pizzas.additional.add') }}" /></a>
                 </div>
            </div>
        @endforeach
    </div>
    @endforeach
</div>
