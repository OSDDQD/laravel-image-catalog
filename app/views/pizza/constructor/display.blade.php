<script>
    $(document).ready(function(){
        var pizzaQuery = {};
        pizzaQuery.plate = [];
        //получаем JSON объект пицы
        pizzaQuery.jsonMenu = {{ $jsonMenu }};
        pizzaQuery.categories = pizzaQuery.jsonMenu.category;
        pizzaQuery.pizza = pizzaQuery.jsonMenu.pizza;

        //Делаем основу
        pizzaQuery.foundation = function(objPizza, classFoundation){
            for(var i=0; i<objPizza.length; i++){
                var onePizza = objPizza[i];
                classFoundation.append('<li><a href=\"#\" data-id=\"'+onePizza.id+'\" data-title=\"'+onePizza.title+'\" data-position=\"'+onePizza.position+'\" data-maxWeight=\"'+onePizza.max_weight+'\" data-size=\"'+onePizza.size+'\">'+onePizza.title+'</a></li>');
            }
        };

        //Делаем категории с и их ингредиентами
        pizzaQuery.drawСategoryMenu = function(objCat, ingredientMenu){
            for(var i=0; i<objCat.length; i++){
                var category = objCat[i];
                ingredientMenu
                    .append('<li style=\"display: none;\"><a href=\"#\" data-id=\"'+category.id+'\" data-position=\"'+category.position+'\" class=\"ingredientId\">'+category.title+'</a><ul class=\"underUl\"></ul></li>')
                    .children('li').children('.ingredientId').each(function(){
                        var idUrlCat = $(this).attr('data-id');
                        idUrlCat = parseInt(idUrlCat);

                        if(idUrlCat == category.id){
                            for(var ma in category.ingredient){
                                var ingredient = category.ingredient[ma];
                                var ingredientId = ingredient.id;
                                $(this).next().append('<li class=\"allCategories\"><a href=\"#\" data-id=\"'+ingredientId+'\" data-position=\"'+ingredient.position+'\" data-title=\"'+ingredient.title+'\">'+ingredient.title+'</a></li>');

                                $('.underUl li a').each(function(){
                                    var idOfCategory = $(this).attr('data-id');
                                    idOfCategory = parseInt(idOfCategory);
                                    if(idOfCategory == ingredientId){
                                        var options = ingredient.option;
                                        for(var i2=0; i2<options.length; i2++){
                                            var oneOption = options[i2];
                                            $(this).append('<span class=\"additionalParam\" data-pizza_id=\"'+oneOption.pizza_id+'\" data-price=\"'+oneOption.price+'\" data-max_quantity="'+oneOption.max_quantity+'" data-weight=\"'+oneOption.weight+'\"></span>');
                                        }
                                    }
                                });
                            }
                        }
                    });
            }
        };
        pizzaQuery.foundation(pizzaQuery.pizza, $('.foundation .fundUl'));
        pizzaQuery.drawСategoryMenu(pizzaQuery.categories, $('.ingredientMenu'));

        $('.fundUl').one('click', function(){
            $('.ingredientMenu li').show(100);
        });

        $('.foundation').one('click', function(){
            $('.fundUl').show(100);
        });
        var myBool = false;

        $('.foundation .fundUl li a').each(function(){
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
                <ul class="ingredientMenu">
                    <li class="foundation">
                        <a href="#">Основа</a>
                        <ul class="fundUl"></ul>
                    </li>
                    {{--@foreach ($jsonMenu as $category)--}}
                    {{--<li>--}}
                        {{--<a href="#">{{ $category->title }}</a>--}}
                        {{--<ul>--}}
                            {{--@foreach ($category->ingredients as $ingredient)--}}
                                {{--<li>--}}
                                    {{--<p>{{ $ingredient->title }}</p>--}}
                                    {{--@foreach($ingredient->options as $option)--}}
                                        {{--<p>{{ $option }}</p>--}}
                                    {{--@endforeach--}}
                                {{--</li>--}}
                            {{--@endforeach--}}
                        {{--</ul>--}}
                    {{--</li>--}}
                    {{--@endforeach--}}
                </ul>
            </div>
        </div>
    </div>
</div>