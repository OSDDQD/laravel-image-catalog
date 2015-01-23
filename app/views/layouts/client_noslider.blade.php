@extends('layouts.client')

@section('body')
    <header>
		<div class="middle">
			<nav class="menu">
				@include('layouts.partials.top_menu')
			</nav>
			<div class="personalCabinetAndSearch">
			    @include('layouts.partials.search_form')
				<a href="#" class="cabinet">{{ Lang::get('client.menu.cabinet') }}</a>
				<div class="lightbox-login">
				    <div class="login-box">
				        <span class="x"></span>
                        <h1>{{ Lang::get('client.cabinet.opening_header') }}</h1>
                        <div class="box-content">
                            <p>{{ Lang::get('client.cabinet.opening_text') }}</p>
                            <a href="https://cab.soho.uz/" class="jump">{{ Lang::get('buttons.jump') }}</a>
                        </div>
				    </div>
				</div>
			</div>
			<div class="clear"></div>
		</div>
	</header>
	<section class="lightGradient">
		<div class="middle">
			<div class="logotip">
				@include('layouts.partials.language_switcher')
				<div class="logo">
					<a href="{{ URL::Route('home') }}"></a>
				</div>
			</div>
			@yield('top_slider')
		</div>
	</section>

	@yield('services_menu')

	<section class="darkGray">
		<div class="middle">
			<article class="darkGrayArticle">
                @yield('content')
            </article>
            <aside class="darkGrayAside">
                <h2>актуально</h2>
                {{--<ul class="payment">--}}
                    {{--<li class="sidebar-1"><a href="#">Способы оплаты</a></li>--}}
                    {{--<li class="sidebar-2"><a href="#">Частые вопросы</a></li>--}}
                {{--</ul>--}}
                @include('layouts.partials.sidebar_menu')
                <div class="referenceMaterials">
                    <a href="#">{{ Lang::get('client.menu.reference_materials') }}</a>
                </div>
                @include('layouts.partials.currencies')
            </aside>
            <div class="clear"></div>
        </div>
    </section>

    @yield('news_slider')
    
@stop
