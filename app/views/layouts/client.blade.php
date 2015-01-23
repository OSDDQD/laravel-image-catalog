@section('header')
<!DOCTYPE html>
<html lang="{{ App::getLocale() }}">
<head>
    <meta charset="utf-8">
    <title>{{ Config::get('app.site_title') }}</title>
    <link type="text/css" href="/assets/css/client/style.css" rel="stylesheet">
    <link rel="alternate" type="application/rss+xml" title="{{ Lang::get('client.rss.title') }}" href="{{ URL::Route('rss', ['locale' => App::getLocale()]) }}">
    <script src="/assets/js/client/jquery-2.1.1.js"></script>
    <script src="/assets/js/client/js.js"></script>
    <script src="/assets/js/client/jquery.aw-showcase.js"></script><!--slider-->
    <script src="/assets/js/client/carousel.js"></script><!--slider-->
@show
</head>
<body>

@yield('body')

@section('footer')
<section class="brown">
    <div class="middle">
        @include('layouts.partials.footer_menu')
        <aside class="brownBlockRight">
            @if (isset($footerAddress))
                <p>{{ Lang::get('client.footer.address') }}:</p>
                <p>{{ $footerAddress }}</p>
            @endif
            @if (isset($footerPhones))
                <p>{{ Lang::get('client.footer.phones') }}:</p>
                @foreach($footerPhones as $phone)
                    <span>{{ trim($phone) }}</span>
                @endforeach
            @endif
            @if (isset($footerSchedule))
                <p>{{ Lang::get('client.footer.schedule') }}:</p>
                {{ $footerSchedule }}
            @endif
        </aside>
        <div class="clear"></div>
    </div>
</section>
<footer>
    <div class="middle">
        <div class="dynamic-dimension">{{ Lang::get('client.developed_and_supported', ['companyname' => '<a href="http://2d.uz">“Dynamic Dimesion”</a>']) }}</div>

        @include('layouts.partials.social')
        <div class="footBlockOne">
            <p>{{ Lang::get('client.footer.all_rights_reserved') }}</p>
            <p>{{ Lang::get('client.footer.service_providers') }}</p>
            <p>{{ Lang::get('client.footer.license') }}</p>
        </div>
        <div class="clear"></div>
    </div>
</footer>
@show
</body>
</html>