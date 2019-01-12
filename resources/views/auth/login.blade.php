<!DOCTYPE html>
<html lang="en">
<head>
    <title>I3cubes pvt Ltd</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="{{asset('img/login/images/icons/i3cubes.ico')}}"/>
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('vendor/login/vendor/bootstrap/css/bootstrap.min.css')}}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('fonts/login/fonts/font-awesome-4.7.0/css/font-awesome.min.css')}}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('vendor/login/vendor/animate/animate.css')}}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('vendor/login/vendor/css-hamburgers/hamburgers.min.css')}}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('vendor/login/vendor/select2/select2.min.css')}}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('css/login/css/util.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/login/css/main.css')}}">
    <!--===============================================================================================-->
    <style>
        .wrap-login100 {
            padding: 50px 50px 50px 50px;
            width: 750px;
        }

        .login100-form-btn {
            background: #00BFFF
        }
    </style>
</head>
<body>

<div class="limiter">
    <div class="container-login100">

        <div class="wrap-login100">
            @if ($errors->has('email'))
                <div class="text text-danger">

                        <span class="help-block">
                            <strong class="text-xs">{{ $errors->first('email') }}</strong>
                        </span>
                </div>
            @endif
            <div class="login100-pic js-tilt" data-tilt>
                <img src="{{asset('img/login/images/img-01.png')}}" alt="IMG">
            </div>

            <form class="login100-form validate-form" method="POST" action="{{ route('login') }}">
                {{ csrf_field() }}
                <span class="login100-form-title">

                       <b>Login</b>

					</span>

                <div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@i3cubes.com" {{ $errors->has('email') ? ' has-error' : '' }}>
                    <input class="input100" type="text" name="email" placeholder="Email">

                    <span class="focus-input100"></span>
                    <span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
                </div>
                <div class="wrap-input100 validate-input" data-validate = "Password is required" {{ $errors->has('password') ? ' has-error' : '' }}>
                    <input class="input100" type="password" name="password" placeholder="Password">

                    <span class="focus-input100"></span>
                    <span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
                    </span>
                </div>

                <div class="container-login100-form-btn">
                    <button class="login100-form-btn" type="submit">
                        Login
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>



<!--===============================================================================================-->
<script src="{{asset('vendor/login/vendor/jquery/jquery-3.2.1.min.js')}}"></script>
<!--===============================================================================================-->
<script src="{{asset('vendor/login/vendor/bootstrap/js/popper.js')}}"></script>
<script src="{{asset('vendor/login/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
<!--===============================================================================================-->
<script src="{{asset('vendor/login/vendor/select2/select2.min.js')}}"></script>
<!--===============================================================================================-->
<script src="{{asset('vendor/login/vendor/tilt/tilt.jquery.min.js')}}"></script>
<script >
    $('.js-tilt').tilt({
        scale: 1.1
    })
</script>
<!--===============================================================================================-->
<script src="{{asset('js/login/js/main.js')}}"></script>

</body>
</html>