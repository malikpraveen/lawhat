
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" type="image/x-icon" href="{{asset('assets/admin/images/favicon.png')}}">
        <title>lawhat : Admin Panel</title> 
        <meta name="keywords" content="Meen." />
        <meta name="author" content="Meen" />
        <link href="https://www.meen.com.com/admin" rel="canonical" />
        <meta name="Classification" content="meen" />
        <meta name="abstract" content="https://www.meen.com/admin" />
        <meta name="audience" content="All" />
        <meta name="robots" content="index,follow" />
        <meta property="og:locale" content="en_US" />
        <meta property="og:title" content="Meen Admin Panel" /> 
        <meta property="og:url" content="https://www.meen.com/admin" /> 
        <meta property="og:site_name" content="meen" />
        <meta name="googlebot" content="index,follow" />
        <meta name="distribution" content="Global" />
        <meta name="Language" content="en-us" />
        <meta name="doc-type" content="Public" />
        <meta name="site_name" content="meen" />
        <meta name="url" content="https://www.meen.com/admin" />
        <link rel="stylesheet" href="{{asset('assets/admin/css/bootstrap.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets/admin/css/style.css')}}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="{{asset('assets/admin/css/et-line-font/et-line-font.css')}}">
        <link rel="stylesheet" href="{{asset('assets/admin/css/themify-icons/themify-icons.css')}}">
        <link rel="stylesheet" href="{{asset('assets/admin/css/simple-lineicon/simple-line-icons.css')}}">
        <link rel="stylesheet" href="{{asset('assets/admin/plugins/datatables/css/dataTables.bootstrap.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets/admin/css/skins/_all-skins.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets/admin/plugins/formwizard/jquery-steps.css')}}">
        <link rel="stylesheet" href="{{asset('assets/admin/plugins/dropify/dropify.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets/admin/css/font/stylesheet.css')}}">
        <style>
            .text-danger{
                font-size:13px;
            }
        </style>
    </head>

    <body class="login-page sty1">
        @yield('content')
        <script src="{{asset('assets/admin/js/jquery.min.js')}}"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script src="{{asset('assets/admin/js/bootstrap.min.js')}}"></script>
        <script src="{{asset('assets/admin/plugins/jquery-sparklines/jquery.sparkline.min.js')}}"></script>
        <script src="{{asset('assets/admin/plugins/jquery-sparklines/sparkline-int.js')}}"></script>
        <script src="{{asset('assets/admin/plugins/raphael/raphael-min.js')}}"></script>
        <script src="{{asset('assets/admin/lugins/morris/morris.js')}}"></script>
        <script src="{{asset('assets/admin/plugins/functions/dashboard1.js')}}"></script>
        <script src="{{asset('assets/admin/js/demo.js')}}"></script>
    </body>

</html>