<!DOCTYPE html>
<html lang="{{ App::getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/favicon.ico">
    <title>{{ Config::get('app.site_title') }} Control Panel</title>
    <link href="/assets/css/admin.css" rel="stylesheet">
    <script src="/assets/js/global/jquery-1.11.1.min.js"></script>
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="/assets/js/manager/html5shiv.min.js"></script>
    <script src="/assets/js/manager/respond.min.js"></script>
    <![endif]-->
</head>
<body>

<div class="container vcenter" style="width: 450px;">
    <div class="panel panel-default" style="margin:auto;">
        <div class="panel-heading"><strong>{{ Lang::get('forms.headers.sign_in') }}</strong></div>
        <div class="panel-body">
            {{ $errors->first('userdata', '<div class="bg-danger alert-danger text-center alert">:message</div>') }}
            {{ Form::open(['route' => 'sessions.store']) }}
            <div class="input-group" style="margin-bottom:5px;">
                {{ Form::text('login', '', ['class' => 'form-control', 'placeholder' => Lang::get('forms.labels.login_or_email')]) }}
                <span class="input-group-addon"><i class="fa fa-user fa-fw"></i></span>
                {{ $errors->first('username', '<div class="help-block has-error">:message</div>')}}
            </div>
            <div class="input-group">
                {{ Form::password('password', ['class' => 'form-control', 'placeholder' => Lang::get('forms.labels.password')]) }}
                <span class="input-group-addon"><i class="fa fa-lock fa-fw"></i></span>
                {{ $errors->first('password', '<div class="help-block has-error">:message</div>')}}
            </div>
            <br>
            {{ Form::label('remember-me', Lang::get('forms.labels.remember_me')) }}
            {{ Form::checkbox('remember-me') }}
            {{ Form::submit(Lang::get('buttons.sign_in'), ['class' => 'btn btn-success btn-md btn-block']) }}
            {{ Form::close() }}
            {{--<div class="panel-footer">--}}
                {{--<a href="{{ URL::Route('users.registration') }}">{{ Lang::get('forms.labels.registration') }}</a>--}}
            {{--</div>--}}
            <div class="panel-footer">
                <a href="{{ URL::Route('password.remind') }}">{{ Lang::get('forms.labels.forgot_password') }}</a>
            </div>
        </div>
    </div>
</div>

</body>
</html>