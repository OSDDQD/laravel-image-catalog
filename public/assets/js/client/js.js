$(document).ready(function(){
    var win = document.location.href; //URL страницы
    //menu
    var allLiMenu = $('.menu').children('ul').children('li');
    var liUlLis;
    for(var i1=0; i1<allLiMenu.length; i1++){
        var liMenu = allLiMenu.eq(i1);
        var liUl = liMenu.children('ul');
        liUl.children('li:last').children().addClass('noBottom');
        liUlLis = liUl.children('li');
        for(var i2 = 0; i2 < liUlLis.length; i2++){
            var liUlLione = liUlLis.eq(i2);
            liUlLione.has('ul').addClass('font-left');
            liUlLione.children('ul').children('li:last').children().addClass('noBottom');
        }
    }

    //cabinet
    $('.cabinet').on('click', function(){
        $('.lightbox-login').fadeIn();
    });
    $('.x').on('click', function(){
        $('.lightbox-login').fadeOut();
    });

	//search
	$('.searchSub').on('mouseover', function(){
		$('.searchFormBlock').fadeIn();
	});
    $('.search-class').on('blur', function(e){
        console.log(e.type);
        var placeholder = $(this).attr('placeholder');
        var val = $(this).val();
        if(val != ""){
            return false;
        }
        else{
            $('.searchFormBlock').fadeOut();
        }
    });
	$('.services').children('.servicesBlock:last').addClass('reset');
	
	//slider
	$("#showcase").awShowcase({
		content_width:			940,
		content_height:			350,
		fit_to_parent:			false,
		auto:					true,
		interval:				5000,
		continuous:				true,
		loading:				true,
		tooltip_width:			200,
		tooltip_icon_width:		32,
		tooltip_icon_height:	32,
		tooltip_offsetx:		18,
		tooltip_offsety:		0,
		arrows:					true,
		buttons:				true,
		btn_numbers:			false,
		keybord_keys:			true,
		mousetrace:				false, /* Trace x and y coordinates for the mouse */
		pauseonover:			true,
		stoponclick:			false,
		transition:				'hslide', /* hslide/vslide/fade */
		transition_delay:		0,
		transition_speed:		500,
		show_caption:			'onload', /* onload/onhover/show */
		thumbnails:				false,
		thumbnails_position:	'outside-last', /* outside-last/outside-first/inside-last/inside-first */
		thumbnails_direction:	'vertical', /* vertical/horizontal */
		thumbnails_slidex:		1, /* 0 = auto / 1 = slide one thumbnail / 2 = slide two thumbnails / etc. */
		dynamic_height:			false, /* For dynamic height to work in webkit you need to set the width and height of images in the source. Usually works to only set the dimension of the first slide in the showcase. */
		speed_change:			true, /* Set to true to prevent users from swithing more then one slide at once. */
		viewline:				false, /* If set to true content_width, thumbnails, transition and dynamic_height will be disabled. As for dynamic height you need to set the width and height of images in the source. */
		custom_function:		null /* Define a custom function that runs on content change */
	});

    //navigation
    var allNavA = $('.navigation nav a');
    for(var navI=0; navI<allNavA.length; navI++){
        var navA = allNavA.eq(navI);
        var navHref = navA.attr('href');
        if(win == navHref){
            navA.addClass('myActive');
            allNavA.eq(0).css('color', '#fff');
        }
    }
    //indent for menu item before logo
    $(".mainMenu ul li:nth-child(3)").addClass("indent");
});