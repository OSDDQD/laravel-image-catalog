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
            <div class="panel-heading"><strong>{{ Lang::get('client.password_reset') }}</strong></div>
            <div class="panel-body">
                {{ $errors->first('userdata', '<div class="bg-danger alert-danger text-center alert">:message</div>') }}
                @if (Session::has('error'))
                  <h3 class="bg-danger alert-danger text-center alert" style="margin-top: 0;">{{ Lang::get('forms.messages.password_reminder_invalid_data') . '<br> ' . trans(Session::get('reason')) }}</h3>
                @elseif (Session::has('success'))
                  <h3 class="bg-success alert-success text-center alert" style="margin-top: 0;">{{ Lang::get('forms.messages.password_reminder_email_sent') }}</h3>
                @endif
                {{ Form::open(array('route' => 'password.request')) }}
                    <div class="input-group" style="margin-bottom:5px;">
                        {{ Form::email('email', '', ['class' => 'form-control', 'placeholder' => Lang::get('fields.email')]) }}
                        <span class="input-group-addon"><i class="fa fa-user fa-fw"></i></span>
                        {{ $errors->first('username', '<div class="help-block has-error">:message</div>')}}
                    </div>
                    {{ Form::submit(Lang::get('buttons.submit'), ['class' => 'btn btn-success btn-md btn-block']) }}
                {{ Form::close() }}
            </div>
        </div>
    </div>
</body>
</html>