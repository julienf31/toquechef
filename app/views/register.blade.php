<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ Config::get('params.appName') }} - Inscription</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/font-awesome/css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('plugins/Ionicons/css/ionicons.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('css/AdminLTE.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/animate.css') }}">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <style></style>
</head>
<body class="hold-transition register-page">
<div class="register-box">
    <div class="register-logo">
        <a href="{{ route('home') }}"><b>Toque</b>Chef</a>
    </div>
    @if($errors)
        {{ $errors->first() }}
    @endif
    <div class="register-box-body">
        <p class="login-box-msg">Créer un compte</p>

        {{ Form::open(array('url' => '/register')) }}

        <div class="form-group has-feedback {{ $errors->has('lastname') ? 'has-error' : ''}}">
            <input type="text" class="form-control" name="lastname" placeholder="Nom"
                   value="{{ Input::old('lastname') }}">
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
            @if($errors->has('lastname'))
                <span class="help-block">{{ $errors->first('lastname') }}</span>
            @endif
        </div>
        <div class="form-group has-feedback {{ $errors->has('firstname') ? 'has-error' : ''}}">
            <input type="text" class="form-control" name="firstname" placeholder="Prénom"
                   value="{{ Input::old('firstname') }}">
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
            @if($errors->has('firstname'))
                <span class="help-block">{{ $errors->first('firstname') }}</span>
            @endif
        </div>
        <div class="form-group has-feedback {{ $errors->has('email') ? 'has-error' : ''}}">
            <input type="email" class="form-control" name="email" placeholder="Email" value="{{ Input::old('email') }}">
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            @if($errors->has('email'))
                <span class="help-block">{{ $errors->first('email') }}</span>
            @endif
        </div>
        <div class="form-group has-feedback {{ $errors->has('password') ? 'has-error' : ''}}">
            <input type="password" class="form-control" name="password" placeholder="Mot de passe">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            @if($errors->has('password'))
                <span class="help-block">{{ $errors->first('password') }}</span>
            @endif
        </div>
        <div class="form-group has-feedback {{ $errors->has('passwordRepeat') ? 'has-error' : ''}}">
            <input type="password" class="form-control" name="passwordRepeat" placeholder="Répetez le mot de passe">
            <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
            @if($errors->has('passwordRepeat'))
                <span class="help-block">{{ $errors->first('passwordRepeat') }}</span>
            @endif
        </div>
        <div class="row">
            <div class="col-xs-4 pull-right">
                <button type="submit" class="btn btn-primary btn-block btn-flat">Inscription</button>
            </div>
        </div>
        {{ Form::close() }}

        <a href="{{ route('login') }}" class="text-center">J'ai déja un compte</a>
    </div>
</div>

<!-- jQuery 3 -->
<script src="{{ asset('plugins/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/bootstrap-notify.min.js') }}"></script>

<script type="text/javascript">
    @if (Session::has('danger-notif'))
    $.notify({
        // options
        message: '{{ Session::get('danger-notif') }}',
        icon: 'fa fa-warning',
    }, {
        // settings
        type: 'danger',
        animate: {
            enter: 'animated fadeInDown',
            exit: 'animated fadeOutUp'
        }

    });
    @endif
</script>


</body>
</html>