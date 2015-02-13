@extends('layouts.client')

@section('body')
    <header>
		    <h1 class="logo">
		        <a href="{{ URL::Route('home') }}">{{ Config::get('app.site_title') }}</a>
		    </h1>
			<nav class="topMenu">
			    <div class="wrapper">
			        @include('layouts.partials.top_menu')
			    </div>
			</nav>
			<div class="userPart">
			     <div class="wrapper">
                    @if (isset($footerPhones))
                    <div class="left">
                        <div class="block phone">
                           <h3>
                               {{ Lang::get('client.sell_by_phone') }}
                           </h3>
                           @foreach($footerPhones as $phone)
                           <span>{{ trim($phone) }}</span>
                           @endforeach
                        </div>
                    </div>
                    @endif
			        @include('pizza.pizzas.partials.cart')
			    </div>
			</div>
			<div class="preNav"></div>
			<nav class="mainMenu">
			    <div class="wrapper">
			        @include('layouts.partials.main_menu')
			    </div>
			</nav>
	</header>

    @yield('top_slider')

	<section class="mainContent">
	    <div class="wrapper">
	        @yield('content')
	    </div>
	</section>

@stop
