<!DOCTYPE html>
<html>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<head>

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>


<style>
    body {
        margin: 0;
        padding: 0;
        background-color: #5e72e4;
        height: 100vh;
    }
    #login .container #login-row #login-column #login-box {
        margin-top: 200px;
        max-width: 600px;
        height: 220px;
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
</style>
</head>



<body>
<div id="login">

    <div class="container">
        <div id="login-row" class="row justify-content-center align-items-center">
            <div id="login-column" class="col-md-6">
                <div id="login-box" class="col-md-12">
                    <form id="login-form" class="form" action="{{route('customerlogin')}}" method="post">
                        <h3 class="text-center text-primary"> <img class="display-4 mt-2" src="{{asset('logos/Logo REVER.png')}}" alt="logo" width="100px"></h3>
                        <div class="form-group">
                            <label for="username" class="text-info">Enter Shop Url:</label><br>
                            <input type="text" name="shopurl" id="username" class="form-control">
                        </div>

                        <div class="form-group">
                            <input type="submit" style="float: right" name="submit" class="btn btn-primary btn-md" value="submit">
                        </div>



                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>

