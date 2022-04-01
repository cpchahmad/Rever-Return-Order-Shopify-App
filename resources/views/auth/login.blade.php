<html>
<head>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!------ Include the above in your HEAD tag ---------->



    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #5e72e4;
            height: 100vh;
        }
        #login .container #login-row #login-column #login-box {
            margin-top: 120px;
            max-width: 600px;
            height: 320px;
            border: 1px solid #9C9C9C;
            background-color: #EAEAEA;
        }
        #login .container #login-row #login-column #login-box #login-form {
            padding: 20px;
        }
        #login .container #login-row #login-column #login-box #login-form #register-link {
            margin-top: -85px;
        }

        .btn-primary{
            background-color:#5e72e4 !important; ;
        }
        .text-primary{
            color:#5e72e4 !important; ;
        }
    </style>
</head>
<body>
<div id="login">
    <h3 class="text-center text-white pt-5"></h3>
    <div class="container">
        <div id="login-row" class="row justify-content-center align-items-center">
            <div id="login-column" class="col-md-6">
                <div id="login-box" class="col-md-12">
                    <form id="login-form" class="form" action="{{ route('login') }}" method="post">
                        @csrf
                        <h3 class="text-center text-primary"> <img class="display-4 mt-3" src="{{asset('logos/Logo REVER.png')}}" alt="logo" width="100px"></h3>
                        <div class="form-group">
                            <label for="username" class="text-info">Email:</label><br>
                            <input id="email" type="email"   class="form-control @error('email') is-invalid @enderror"  value="{{ old('email') }}" required autocomplete="email"name="email">
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password" class="text-info">Password:</label><br>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            {{--                            <label for="remember-me" class="text-info"><span>Remember me</span> <span><input id="remember-me" name="remember-me" type="checkbox"></span></label><br>--}}
                            <input type="submit" name="submit" class="btn btn-primary btn-md" value="submit" style="float: right">
                        </div>
                        {{--                        <div id="register-link" class="text-right">--}}
                        {{--                            <a href="#" class="text-info">Register here</a>--}}
                        {{--                        </div>--}}
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>

</html>
