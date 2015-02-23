@section('header')
<!DOCTYPE html>
<html lang="{{ App::getLocale() }}">
<head>
    <meta charset="utf-8">
    <title>{{ Config::get('app.site_title') }} {{ isset($pageTitle) ? $pageTitle : '' }}</title>
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
<footer>
    <div class="wrapper">
        <section class="top">
            <div class="payServices">
                <img src="/assets/img/client/mbank.png" />
                <img src="/assets/img/client/click.png" />
            </div>
        </section>
        <section class="bottom">
            <section>
                <div class="copyright">
                    {{ Lang::get('client.footer.all_rights_reserved', ['year' => date('Y')]) }}
                </div>
            </section>
            <section>
                <div class="counter">
                    <img src="/assets/img/client/counter.png" />
                </div>
            </section>
            <section>
               <div class="dd">
                    {{ Lang::get('client.developed_and_supported', ['companyname' => '<a href="http://2d.uz">“Dynamic Dimesion”</a>']) }}
                </div>
            </section>
        </section>
    </div>
</footer>
@show
</body>
</html>