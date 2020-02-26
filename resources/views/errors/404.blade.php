<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="images/favicon.ico">

    <title>Clearpath Orthodontics - 404 Page not found </title>

    <!-- bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{asset('public/assets/vendor_components/bootstrap/dist/css/bootstrap.css')}}">

    <!-- font awesome -->
    <link rel="stylesheet" href="{{asset('public/assets/vendor_components/font-awesome/css/font-awesome.css')}}">

    <!-- ionicons -->
    <link rel="stylesheet" href="{{asset('public/assets/vendor_components/Ionicons/css/ionicons.css')}}">

    <!-- theme style -->
    <link rel="stylesheet" href="{{asset('public/css/master_style.css')}}">

    <!-- mpt_admin skins. choose a skin from the css/skins folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{asset('public/css/skins/_all-skins.css')}}">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- google font -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">

</head>
<body class="hold-transition">
<div class="error-body">
    <div class="error-page">

        <div class="error-content">
            <div class="container">

                <h2 class="headline text-yellow"> 404</h2>

                <h3 class="margin-top-0"><i class="fa fa-warning text-yellow"></i> PAGE NOT FOUND !</h3>

                <p>
                    YOU SEEM TO BE TRYING TO FIND HIS WAY HOME
                </p>
                <div class="text-center">
                    <a href="{{route('dashboard')}}" class="btn btn-info btn-block btn-flat margin-top-10">Back to dashboard</a>
                </div>

            </div>
        </div>
        <!-- /.error-content -->
        <footer class="main-footer">
            Copyright &copy; 2020 <a href="{{route('dashboard')}}">Clearpath Orthodontics</a>. All Rights Reserved.
        </footer>

    </div>
    <!-- /.error-page -->
</div>




<!-- jQuery 3 -->
<script src="{{asset('public/assets/assets/vendor_components/jquery/dist/jquery.min.js')}}"></script>

<!-- Bootstrap 3.3.7 -->
<script src="{{asset('public/assets/assets/vendor_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>


</body>
</html>
