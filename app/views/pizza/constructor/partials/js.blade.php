<script>
    var data = {{ $json }};
    var options = {{ $options }};
    console.log(data);

    var pizza = {};
    pizza.check = [];
    pizza.plate = [];


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
                    pizza.check.pop();
                }

                pizza.check.push({"id" : fdataId, 'data-size': fdataSize, 'price': fdataPrice, 'weight': fdataMaxWeight});
                pizza.plate.push({"id" : fdataId, 'data-size': fdataSize, 'price': fdataPrice, 'weight': fdataMaxWeight});

                console.log(pizza.plate);
                console.log(pizza.check);

            });
        });

        $('.categories .category').not('.first').children('.submenu').find('a').each(function(){

            $(this).on('click', function(){
                var dataId = $(this).attr('data-id');
                console.log(dataId);
            });
        });

    });

</script>