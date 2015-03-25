<script>
    var data = {{ $json }};
    var options = {{ $options }};
    //console.log(options);

    var pizza = {};
    pizza.check = {
        'base': [],
        'ing': []
    };
    pizza.plate = [];
    pizza.arr = []; //конечный массив для отправки на сервер

    pizza.findPartial = function(a, s){
        for(var i2=0; i2<a.length; ++i2)
            if(a[i2].indexOf(s) >= 0 )
                return i2;
        return -1;
    };

    pizza.tpl = function(obj, id, title, prise, weight, type){
        var tpl;
        if(type == 'base'){
            tpl = '' +
                '<li id=\"'+type+'\" data-type=\"'+type+'\" data-title=\"'+title+'\" data-id=\"'+id+'\" data-price=\"'+prise+'\" data-weight=\"'+weight+'\">' +
                    '<span>'+title+'</span>' +
                    '<span>Цена: '+prise+'</span>' +
                    '<span>Вес: '+weight+'</span>' +
                    '<span class=\"x\">X</span>' +
                '</li>';
            $('#list ul').html(tpl);
        }
        if(type == 'ingredient'){
            tpl = '' +
                '<li data-type=\"'+type+'\" data-title=\"'+title+'\" data-id=\"'+id+'\" data-price=\"'+prise+'\" data-weight=\"'+weight+'\">' +
                    '<span>'+title+'</span>' +
                    '<span>Цена: '+prise+'</span>' +
                    '<span>Вес: '+weight+'</span>' +
                    '<span class=\"x\">X</span>' +
                '</li>';
            $('#list ul').append(tpl);
        }
    };

    jQuery(window).load(function() {

        $(".categories ul > li").click(function (e) { // binding onclick
            if ($(this).hasClass('selected')) {
                $(".categories ul > li > .submenu ul").slideUp(100); // hiding popups
                $(".categories ul li.selected").removeClass("selected");
            } else {
                $(".categories ul > li > .submenu ul").slideUp(100); // hiding popups
                $(".categories ul li.selected").removeClass("selected");

                if ($(this).find(".submenu ul").length) {
                    $(this).addClass("selected"); // display popup
                    $(this).find(".submenu ul").slideDown(200);
                }
            }
            e.stopPropagation();
        });

        $("body").click(function () { // binding onclick to body
            $(".categories ul li.selected .submenu ul").slideUp(100); // hiding popups
            $(".categories ul li.selected").removeClass("selected");
        });

        //JewTA
        $('.categories ul .category:first-child').addClass('first');

        $('.first .submenu ul li a').each(function(){
            $(this).on('click', function(){
                var fdataId = $(this).attr('data-id');
                var fdataTitle = $(this).attr('data-title');
                var fdataImg = $(this).attr('data-image');
                var fdataBase = $(this).attr('data-base');
                var fdataSize = $(this).attr('data-size');
                var fdataMaxWeight = $(this).attr('data-max-weight');
                var fdataPrice = $(this).attr('data-price');

                $('.presentation').html('<img src=\"'+fdataImg+'\">');

                if(pizza.plate.length > 0){ //проверка чтобы не было в массиве двух основ
                    pizza.plate.pop();
                    pizza.check.base.pop();
                }

                pizza.check.base.push({"id" : fdataId, 'title': fdataTitle, 'data-size': fdataSize, 'price': fdataPrice, 'max_weight': fdataMaxWeight, 'base': fdataBase});
                pizza.plate.push({"id" : fdataId, 'size': fdataSize, 'price': fdataPrice, 'max_weight': fdataMaxWeight});
                //console.log(pizza.check.base[0]);

                pizza.tpl($('#list ul'), pizza.check.base[0].id, pizza.check.base[0].title, pizza.check.base[0].price, pizza.check.base[0].max_weight, 'base'); //шаблон для добавления основы в правый блок
            });
        });

        var countW = 0; //счетчик считает вес

        $('.categories .category').not('.first').children('.submenu').find('a').each(function(){
            $(this).on('click', function(){
                if(pizza.check.base.length > 0){ //Проверка. Нельзя выбрать ингредиент пока не выберешь основу
                    var dataId = $(this).attr('data-id'); //id ингредиента
                    var dataTitle = $(this).attr('data-title'); //id ингредиента

                    for(var one in options){
                        var option = options[one];
                        if(option.ingredient_id == dataId){ //Проверка. относится ли свойство ингредиента к этой опции
                            var checkId = pizza.check.base[0].id;
                            var pizzaId = option.pizza_id;

                            if(pizzaId == checkId){ //Проверка. Совпадает ли свойство с пиццой
                                var maxQuantity = option.max_quantity; //максимальное количество ингредиентов

                                pizza.check.ing.push({'id': dataId, 'count': 0});
                                for(var a in pizza.check.ing){
                                    var oneing = pizza.check.ing[a];
                                    if(oneing.id == dataId){
                                        oneing.count++;
//                                        console.log('сработал счетчик');
//                                        console.log(pizza.check.ing);
                                    }
                                }

                                var price = option.price; //цена ингредиента
                                var weight = option.weight; //вес игредиента
                                weight = parseInt(weight);
                                var maxWeight = pizza.check.base[0].max_weight; //максимальный вес пиццы
                                maxWeight = parseInt(maxWeight);

                                countW += Number(weight); //Добавляем вес до предела
//pizza.check[0].count <= maxQuantity &&
                                if(countW <= maxWeight){
                                    pizza.plate.push({'id': dataId, 'title': dataTitle, 'price': price, 'weight': weight});
                                    console.log(pizza.plate);
                                    $(this).attr({
                                        'data-price': price,
                                        'data-weight': weight
                                    });

                                    var dataPrice = $(this).attr('data-price');
                                    var dataWeight = $(this).attr('data-weight');

                                    pizza.tpl($('#list ul'), dataId, dataTitle, dataPrice, dataWeight, 'ingredient'); //шаблон для добавления ингредиентов в правый блок
                                }
                                else{
//                                    if(pizza.check[0].count >= maxQuantity){
//                                        alert('Вы достилги лимита для данного ингредиента');
//                                    }

                                    if(countW >= maxWeight){
                                        alert('Вы достигли лимита по весу пиццы');
                                    }
                                }
                            }
                        }
                    }
                }
                else{
                    alert('Выберите основу');
                }
            });
        });

        $('.sendTotal').on('click', function(e){
            e.preventDefault();


            $('#list ul li').each(function(){
                var id = $(this).attr('data-id');
                var title = $(this).attr('data-title');
                var price = $(this).attr('data-price');
                var weight = $(this).attr('data-weight');
                var type = $(this).attr('data-type');
                pizza.arr.push({'id': id, 'title': title, 'price': price, 'weight': weight, 'type': type});
                console.log(pizza.arr);
            });

            if(pizza.arr.length == 0){
                alert('вы не чего не выбрали');
            }
        });
    });
</script>