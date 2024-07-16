<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>

    <!-- Google Font: Source Sans Pro -->

    <!-- Font Awesome -->
    <link rel="stylesheet" href="adminlte/plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="adminlte/dist/css/adminlte.min.css">
</head>

<body class="hold-transition login-page" style="background-image: url(/prueba_fondo_login3.jpg); background-size: 1515px;background-position: 25% 20%;">




    <div class="login-box" style="width: 25rem;" >
        <div class="login-logo">


            {{--  <br>
            <a><b style="color: white;">Ingresar</b></a>  --}}
        </div>
        <!-- /.login-logo -->
        <div class="card" >
            <div class="card-body login-card-body" style="border-radius: 10%;">

                <div class="col-xs-1" align="center">
                    <!--img class="animation__wobble" src="/logocaptis.png" alt="AdminLTELogo" height="80" width="90" -->
                    <img class="animation__wobble" src="/adminlte/dist/img/acopio2.png" alt="AdminLTELogo" height="50" width="150">
                </div>
                <hr>
                {{--  <p class="login-box-msg">Ingresar</p>  --}}
                <h3 align="center">Ingresar</h3>


                <form action="{{route('login')}}" role="form" method="POST">
                    {{ csrf_field() }}
                    <div class="input-group{{ $errors->has('email') ? ' has-error' : ''}} has-feedback mb-3">
                        <input type="email" name="email" value="{{ old('email')}}" required autofocus class="form-control"  placeholder="Correo">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                        @if($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="input-group{{ $errors->has('password') ? ' has-error' : ''}} has-feedback mb-3">
                        <input type="password" name="password" class="form-control"  placeholder="Contraseña" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        @if($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="row">

                        <!-- /.col -->


                        {{--  <div class="col-8">

                        </div>  --}}
                        <div class="col-12" align="center">
                            <button type="submit" class="btn btn-primary btn-block" >Entrar</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!--div class="col-xs-1" align="center" style="padding-top: 2%">
        <img src="/logos_instituciones.png" alt="AdminLTELogo" height="75%" >
    </div -->
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="adminlte/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="adminlte/dist/js/adminlte.min.js"></script>
    <script>
        //history.forward();
    </script>
</body>



</html>
