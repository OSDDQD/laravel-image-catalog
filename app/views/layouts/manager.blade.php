<!DOCTYPE html>
<html lang="{{ App::getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>{{ Config::get('app.site_title') }} Control Panel</title>
    <link href="/assets/css/admin.css" rel="stylesheet">
    <script src="/assets/js/client/jquery-1.11.2.min.js"></script>
    <script src="/assets/js/client/jquery-ui/jquery-ui.min.js"></script>
    <script src="/assets/js/manager/plugins/morris/raphael.min.js"></script>
    <script src="/assets/js/manager/plugins/morris/morris.min.js"></script>
    <script src="/assets/js/manager/plugins/damnUploader/interface.js"></script>
    <script src="/assets/js/manager/plugins/damnUploader/uploader-setup.js"></script>
    <script src="/assets/js/manager/plugins/damnUploader/jquery.damnUploader.js"></script>
    <script src="/packages/barryvdh/laravel-elfinder/js/elfinder.min.js"></script>
    <script src="/assets/js/manager/tinymce/tinymce.min.js"></script>
    <script src="/assets/js/manager/main.js"></script>
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="/assets/js/manager/html5shiv.min.js"></script>
    <script src="/assets/js/manager/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div id="wrapper">

<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="{{ URL::Route('manager.home') }}">{{ Config::get('app.site_title') }}</a>
    </div>
    <!-- Top Menu Items -->
    <ul class="nav navbar-right top-nav">
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> {{ Auth::getUser()->displayname }} <b class="caret"></b></a>
            <ul class="dropdown-menu">
                <li>
                    <a href="{{ URL::Route('manager.users.edit', ['id' => Auth::user()->id]) }}"><i class="fa fa-fw fa-gear"></i> {{ Lang::get('manager.menu.profile') }}</a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="{{ URL::Route('home') }}"><i class="fa fa-fw fa-sitemap"></i> {{ Lang::get('manager.menu.site') }}</a>
                </li>
                <li>
                    <a href="{{ URL::Route('users.logout') }}"><i class="fa fa-fw fa-sign-out"></i> {{ Lang::get('manager.menu.logout') }}</a>
                </li>
            </ul>
        </li>
    </ul>
    <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
    <div class="collapse navbar-collapse navbar-ex1-collapse">
        @if (Menu::getCollection()->has('ManagerSidebarMenu'))
        {{ Menu::get('ManagerSidebarMenu')->asUl(['class' => 'nav navbar-nav side-nav']) }}
        @endif
    </div>
    <!-- /.navbar-collapse -->
</nav>

<div id="page-wrapper">

<div class="container-fluid">

<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            @yield('page-header')
        </h1>
    </div>
</div>
<!-- /.row -->

<div class="row">
    <div class="col-lg-12">
        @yield('toolbar')
    </div>
</div>
<!-- /.row -->

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            {{--<div class="panel-heading">--}}
                {{--<h3 class="panel-title"><i class="fa fa-bar-chart-o fa-table"></i> Area Chart</h3>--}}
            {{--</div>--}}
            <div class="panel-body">
                @if (Session::has('manager_error_message'))
                    <div class="bg-danger alert-danger text-center alert">{{ Session::get('manager_error_message') }}</div>
                @endif
                @if (Session::has('manager_success_message'))
                    <div class="bg-success alert-success text-center alert">{{ Session::get('manager_success_message') }}</div>
                @endif
                @yield('content')
            </div>
        </div>
    </div>
</div>
<!-- /.row-->

</div>
<!-- /.container-fluid -->

</div>
<!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

    <script src="/assets/js/manager/bootstrap.min.js"></script>
    <script src="/assets/js/manager/ie10-viewport-bug-workaround.js"></script>
</body>
</html>
