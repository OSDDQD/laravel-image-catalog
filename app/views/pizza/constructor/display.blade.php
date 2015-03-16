<script>
    $(document).ready(function(){
        var pizza = {};
        pizza.plate = [];

        pizza.elements = {{ $json }};

        $('.foundation').one('click', function() {
            $('.fundUl').show(100);
        });
        var myBool = false;

        $('.foundation .fundUl li a').each(function() {
            $(this).on('click', function(){
                pizzaQuery.plate = [];
                var pizzaId = $(this).attr('data-id');
                var pizzaTitle = $(this).attr('data-title');
                var pizzaMaxWeight = $(this).attr('data-maxweight');
                var pizzaPosition = $(this).attr('data-position');
                var pizzaSize = $(this).attr('data-size');
                pizzaQuery.plate.push({id: pizzaId, title: pizzaTitle, max_weight: pizzaMaxWeight, position: pizzaPosition, size: pizzaSize});
                myBool = true;
                console.log('первый li');
                console.log(myBool);
                console.log(pizzaQuery.plate);
            });
        });

        var addWeight = 0; //счетчик веса для пиццы
        var numb = 0; //счетчик количества ингредиентов для пиццы
        var numb2 = 1;

        $('.underUl li a').each(function(){
            $(this).on('click', function(){
                $(this).children('span').each(function(){

                    var dataPizzaId = $(this).attr('data-pizza_id');
                    var dataPrice = $(this).attr('data-price');
                    var dataMaxQuantity = $(this).attr('data-max_quantity');
                    var dataWeight = $(this).attr('data-weight');

                    var arrIdPizza = pizzaQuery.plate[0].id;
                    if(dataPizzaId == arrIdPizza){
                        var ingrCatId = $(this).parent().attr('data-id');
                        var ingrCatPosition = $(this).parent().attr('data-position');
                        var ingrCatTitle = $(this).parent().attr('data-title');

                        var maxWeight = pizzaQuery.plate[0].max_weight;
                        maxWeight = parseInt(maxWeight);
                        dataWeight = parseInt(dataWeight);
                        dataMaxQuantity = parseInt(dataMaxQuantity);

                        if(myBool){
                            if(numb < dataMaxQuantity && addWeight < maxWeight){
                                addWeight += Number(dataWeight);
                                numb += Number(numb2);
                                pizzaQuery.plate.push({id: ingrCatId, position: ingrCatPosition, title: ingrCatTitle, price: dataPrice});
                                console.log('второй li');
                                console.log(addWeight);
                                console.log(numb);
                                console.log(pizzaQuery.plate);

                            }
                            else{
                                console.log('Превышен максимальный вес пиццы или количество ингредиентов');
                                myBool = false;

                                if(!myBool){
                                    addWeight = 0;
                                    numb = 0;
                                }
                            }
                        }
                    }
                });
            });
        });
    });
</script>
<div class="wrapper">
    <div class="constructor">
        <div class="texture">
            <div class="categories">
                <ul>
                    @foreach ($items as $item)
                        <li>
                            <a href="#">{{ $item['title'] }}</a>
                            <ul>
                                @foreach ($item['ingredient'] as $ingredient)
                                    <li>
                                        <a href="#"
                                        @if(!empty($ingredient['image']))data-image="{{ $ingredient['image'] }}" @endif
                                        @if(isset($ingredient['base']))data-base="1" @endif
                                        data-id="{{ $ingredient['id'] }}"
                                        @if(isset($ingredient['size']))data-size="{{ $ingredient['size'] }}" @endif
                                        @if(isset($ingredient['max_weight']))data-max-weight="{{ $ingredient['max_weight'] }}" @endif
                                        @if (isset($ingredient['option']))
                                            @foreach ($ingredient['option'] as $option)
                                                @if(isset($option['pizza_id']))data-pizza-id="{{ $option['pizza_id'] }}" @endif
                                                @if(isset($option['price']))data-price="{{ $option['price'] }}" @endif
                                                @if(isset($option['max_quantity']))data-max-quantity="{{ $option['max_quantity'] }}" @endif
                                                @if(isset($option['weight']))data-weight="{{ $option['weight'] }}" @endif
                                            @endforeach
                                        @endif
                                        >{{ $ingredient['title'] }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
