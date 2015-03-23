<script>
    var data = {{ $json }};
    var options = {{ $options }};
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

    });
</script>