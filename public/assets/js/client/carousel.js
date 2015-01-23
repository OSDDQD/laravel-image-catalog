/* developed by http://www.yanajy.com */

$(document).ready(function(){

	$(".b-carousel-button-right").click(function(){ // при клике на правую кнопку запускаем следующую функцию:
		$(".h-carousel-items").animate({left: "-330px"}, 200); // производим анимацию: блок с набором картинок уедет влево на 330 пикселя (это ширина одного прокручиваемого элемента) за 200 милисекунд.
		setTimeout(function () { // устанавливаем задержку времени перед выполнением следующих функций. Задержка нужна, т.к. эти ффункции должны запуститься только после завершения анимации.
			$(".h-carousel-items .b-carousel-block").eq(0).clone().appendTo(".h-carousel-items"); // выбираем первый элемент, создаём его копию и помещаем в конец карусели
			$(".h-carousel-items .b-carousel-block").eq(0).remove(); // удаляем первый элемент карусели		
			$(".h-carousel-items").css({"left":"0px"}); // возвращаем исходное смещение набора набора элементов карусели
		}, 300);
	});
	
	$(".b-carousel-button-left").click(function(){ // при клике на левую кнопку выполняем следующую функцию:		
		$(".h-carousel-items .b-carousel-block").eq(-1).clone().prependTo(".h-carousel-items"); // выбираем последний элемент набора, создаём его копию и помещаем в начало набора	
		$(".h-carousel-items").css({"left":"-330px"}); // устанавливаем смещение набора -330		
		$(".h-carousel-items").animate({left: "0px"}, 200); // за 200 милисекунд набор элементов плавно переместится в исходную нулевую точку
		$(".h-carousel-items .b-carousel-block").eq(-1).remove(); // выбираем последний элемент карусели и удаляем его
	});
	
});