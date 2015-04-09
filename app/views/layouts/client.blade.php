@section('header')
<!DOCTYPE html>
<html lang="{{ App::getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="robots" content="noindex, nofollow">
    <title>{{ Config::get('app.site_title') }} {{ isset($pageTitle) ? $pageTitle : '' }}</title>
    <!-- favicon -->
    <link rel="icon" type="image/png" href="/assets/img/favicon.png">

    <!-- Bootstrap core CSS -->
    <link href="/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap theme -->
    <link href="/assets/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet">
    <!-- vegas bg -->
    <link href="/assets/js/vegas/jquery.vegas.min.css" rel="stylesheet">
    <!-- owl carousel css -->
    <link href="/assets/js/owl-carousel/owl.carousel.css" rel="stylesheet">
    <link href="/assets/js/owl-carousel/owl.theme.css" rel="stylesheet">
    <link href="/assets/js/owl-carousel/owl.transitions.css" rel="stylesheet">
    <!-- intro animations -->
    <link href="/assets/js/wow/animate.css" rel="stylesheet">
    <!-- font awesome -->
    <link href="/assets/css/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- lightbox -->
    <link href="/assets/js/lightbox/css/lightbox.css" rel="stylesheet">

    <!-- styles for this template -->
    <link href="/assets/css/client/styles.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>
@show

<body data-default-background-img="assets/img/client/default_bg.jpg" data-overlay="true" data-overlay-opacity="0.35">

<!-- Outer Container -->
<div id="outer-container">

    <!-- Left Sidebar -->
    <section id="left-sidebar">

        <div class="logo">
            <a href="{{ URL::Route('home') }}#intro" class="link-scroll"><img src="/assets/img/logo.png" alt="{{ Config::get('app.site_title') }}"></a>
        </div><!-- .logo -->

        <!-- Menu Icon for smaller viewports -->
        <div id="mobile-menu-icon" class="visible-xs" onClick="toggle_main_menu();"><span class="glyphicon glyphicon-th"></span></div>

        @include('layouts.partials.menu')

    </section><!-- #left-sidebar -->
    <!-- end: Left Sidebar -->

    <section id="main-content" class="clearfix">
        @yield('content')
    </section><!-- #main-content -->

@section('footer')
    <!-- Footer -->
    <section id="footer">

        <!-- Go to Top -->
        <div id="go-to-top" onclick="scroll_to_top();"><span class="icon glyphicon glyphicon-chevron-up"></span></div>

        @include('layouts.partials.social')

    </section>
    <!-- end: Footer -->

</div><!-- #outer-container -->
<!-- end: Outer Container -->

<!-- Modal -->
<div class="modal fade" id="common-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <div class="modal-body clearfix">
            </div><!-- .modal-body -->
        </div><!-- .modal-content -->
    </div><!-- .modal-dialog -->
</div><!-- .modal -->
@show
    <!-- Javascripts
================================================== -->

<!-- Jquery and Bootstrap JS -->
<script src="/assets/js/client/jquery-1.11.2.min.js"></script>
<script src="/assets/bootstrap/js/bootstrap.min.js"></script>

<!-- Easing - for transitions and effects -->
<script src="/assets/js/client/jquery.easing.1.3.js"></script>

<!-- background image strech script -->
<script src="/assets/js/vegas/jquery.vegas.min.js"></script>

<!-- detect mobile browsers -->
<script src="assets/js/client/detectmobilebrowser.js"></script>

<!-- detect scrolling -->
<script src="/assets/js/client/jquery.scrollstop.min.js"></script>

<!-- owl carousel js -->
<script src="/assets/js/owl-carousel/owl.carousel.min.js"></script>

<!-- lightbox js -->
<script src="/assets/js/lightbox/js/lightbox.min.js"></script>

<!-- intro animations -->
<script src="/assets/js/wow/wow.min.js"></script>

<!-- responsive videos -->
<script src="/assets/js/client/jquery.fitvids.js"></script>

<!-- Custom functions for this theme -->
<script src="/assets/js/client/functions.min.js"></script>
<script src="/assets/js/client/initialise-functions.js"></script>

<!-- IE9 form fields placeholder fix -->
<!--[if lt IE 9]>
<script>contact_form_IE9_placeholder_fix();</script>
<![endif]-->
</body>
</html>