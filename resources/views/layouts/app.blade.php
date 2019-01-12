<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="{{asset('bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('bower_components/font-awesome/css/font-awesome.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{asset('bower_components/Ionicons/css/ionicons.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('dist/css/AdminLTE.min.css')}}">
    <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
          page. However, you can choose any other skin. Make sure you
          apply the skin class to the body tag so the changes take effect. -->
    <link rel="stylesheet" href="{{asset('dist/css/skins/skin-blue.min.css')}}">

    <link rel="stylesheet" href="{{asset('css/jquery-confirm.css')}}">

    <link rel="stylesheet" href="{{asset('css/toastr.min.css')}}">

    <link rel="stylesheet" href="{{asset('css/datatables.min.css')}}">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

    @yield('styles')

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        input[type="date"].form-control, input[type="time"].form-control, input[type="datetime-local"].form-control, input[type="month"].form-control {
            line-height: 18px;
        }
    </style>
</head>
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <!-- Main Header -->
    <header class="main-header">

        <!-- Logo -->
        <a href="{{url('home')}}" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><img height="50px" width="50px" src="{{asset('/img/logo.png')}}" alt=""></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><img width="200px" height="40px" src="{{asset('/img/logo_new.png')}}" alt=""></span>
        </a>

        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <!-- Tasks Menu -->
                    <li class="dropdown user user-menu">
                        <!-- Menu Toggle Button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <!-- The user image in the navbar-->
                            <img src="{{Auth::user()?asset(Auth::user()->employee->img_url):'img/user/malex50.jpg'}}" class="user-image" alt="User Image">
                            <!-- hidden-xs hides the username on small devices so only the image appears. -->
                            <span class="hidden-xs">{{Auth::user()?Auth::user()->user_name:''}}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- The user image in the menu -->
                            <li class="user-header">
                                <img src="{{Auth::user()?asset(Auth::user()->employee->img_url):'img/user/malex50.jpg'}}" class="img-circle" alt="User Image">

                                <p>
                                    {{Auth::user()?Auth::user()->role->name:''}}
                                </p>
                                <p>
                                    {{Auth::user()?Auth::user()->employee->division->name:''}} - {{Auth::user()?Auth::user()->employee->designation->name:''}}
                                </p>
                                <p class="text-aqua">Member Since - {{Auth::user()->created_at->toDateString()}}</p>
                            </li>
                            <!-- Menu Body -->
                            <li class="user-body">
                                <!-- /.row -->
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="{{url('/employee/'.Auth::user()->employee->id.'/show')}}" class="btn btn-primary btn-flat">My Profile</a>
                                </div>
                                <div class="pull-right">
                                    <a href="{{ route('logout') }}" class="btn btn-default btn-flat"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        Sign out
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
    <?PHP
    $canViewUser = Auth::user()->canViewUser();
    $canEditUser = Auth::user()->canEditUser();
    $canCreateUser = Auth::user()->canCreateUser();
    $canViewEmployee = Auth::user()->canViewEmployee();
    $canEditEmployee = Auth::user()->canEditEmployee();
    $canCreateEmployee = Auth::user()->canCreateEmployee();
    $canDeleteEmployee = Auth::user()->canDeleteEmployee();
    $canViewRole = Auth::user()->canViewRole();
    $canEditRole = Auth::user()->canEditRole();
    $canCreateRole = Auth::user()->canCreateRole();
    $canDeleteRole = Auth::user()->canDeleteRole();
    $canViewLog = Auth::user()->canViewLog();
    $canViewSupplier = Auth::user()->canViewSupplier();
    $canEditSupplier = Auth::user()->canEditSupplier();
    $canCreateSupplier = Auth::user()->canCreateSupplier();
    $canViewProduct = Auth::user()->canViewProduct();
    $canEditProduct = Auth::user()->canEditProduct();
    $canCreateProduct = Auth::user()->canCreateProduct();
    $canApproveProductRequest = Auth::user()->canApproveProductRequest();
    $canConfirmProductRequest = Auth::user()->canConfirmProductRequest();
    $canIssueProducts = Auth::user()->canIssueProducts();
    $canViewProductRequest = Auth::user()->canViewProductRequest();
    $canCreateProductRequest = Auth::user()->canCreateProductRequest();
    $canCreateStock = Auth::user()->canCreateStock();
    $canViewStock = Auth::user()->canViewStock();
    $canApproveStockRequest = Auth::user()->canApproveStockRequest();
    $canCreateStockRequest = Auth::user()->canCreateStockRequest();
    $canViewStockRequest = Auth::user()->canViewStockRequest();
    $canDownloadStockRequest = Auth::user()->canDownloadStockRequest();
    $canViewInventory = Auth::user()->canViewInventory();
    $canAdmin = Auth::user()->canAdmin();
    ?>
    <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">

            <!-- Sidebar user panel (optional) -->
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="{{Auth::user()?asset(Auth::user()->employee->img_url):asset('img/user/malex50.jpg')}}" class="img-circle" alt="User Image">
                </div>
                <div class="pull-left info">
                    <p>{{Auth::user()?Auth::user()->user_name:''}}</p>
                    <!-- Status -->
                    <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                </div>
            </div>


            <!-- Sidebar Menu -->
            <ul class="sidebar-menu" data-widget="tree">

                <li class="header">MENU</li>

                <li class="{{url()->current() == url('/home')?'active':''}}"><a href="{{url('/home')}}"><i class="fa fa-home"></i> <span>HOME</span></a></li>
                @if($canViewLog)
                    <li class="{{url()->current() == url('/log')?'active':''}}"><a href="{{url('/log')}}"><i class="fa fa-history"></i> <span>LOG</span></a></li>
                @endif
                @if($canAdmin)
                    <li class="{{url()->current() == url('/admin')?'active':''}}"><a href="{{url('/admin')}}"><i class="fa fa-wrench"></i> <span>ADMIN</span></a></li>
                @endif
                @if($canViewEmployee || $canEditEmployee || $canDeleteEmployee || $canCreateEmployee)
                    <li class="treeview
                        {{url()->current() == url('/employee') ||
                         url()->current() == url('/employee/create') ?'active':''}}
                            ">
                        <a href="#"><i class="fa fa-user-md"></i> <span>EMPLOYEE</span>
                            <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>

                        </span>
                        </a>
                        <ul class="treeview-menu">
                            @if($canViewEmployee)
                                <li class="{{url()->current() == url('/employee')?'active':''}}"><a href="{{url('/employee')}}"><i class="fa fa-eye"></i> <span>VIEW EMPLOYEES</span></a></li>
                            @endif
                            @if($canCreateEmployee)
                                <li class="{{url()->current() == url('/employee/create')?'active':''}}"><a href="{{url('/employee/create')}}"><i class="fa fa-plus"></i> <span>NEW EMPLOYEE</span></a></li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if($canEditUser || $canViewUser || $canCreateUser)
                    <li class="treeview
                        {{url()->current() == url('/user') ||
                         url()->current() == url('/user/create/select') ?'active':''}}
                            ">
                        <a href="#"><i class="fa fa-user"></i> <span>USER</span>
                            <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>

                        </span>
                        </a>
                        <ul class="treeview-menu">
                            @if($canViewUser)
                                <li class="{{url()->current() == url('/user')?'active':''}}"><a href="{{url('/user')}}"><i class="fa fa-eye"></i> <span>VIEW USER</span></a></li>
                            @endif
                            @if($canCreateUser)
                                <li class="{{url()->current() == url('/user/create/select')?'active':''}}"><a href="{{url('/user/create/select')}}"><i class="fa fa-plus"></i> <span>NEW USER</span></a></li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if($canViewRole || $canEditRole || $canDeleteRole || $canCreateRole)
                    <li class="treeview
                        {{url()->current() == url('/user/roles') ||
                         url()->current() == url('/role/create') ?'active':''}}
                            ">
                        <a href="#"><i class="fa fa-object-group"></i> <span>ROLE</span>
                            <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>

                        </span>
                        </a>
                        <ul class="treeview-menu">
                            @if($canViewRole)
                                <li class="{{url()->current() == url('/user/roles')?'active':''}}"><a href="{{url('/user/roles')}}"><i class="fa fa-eye"></i> <span>VIEW ROLES</span></a></li>
                            @endif
                            @if($canCreateRole)
                                <li class="{{url()->current() == url('/role/create')?'active':''}}"><a href="{{url('/role/create')}}"><i class="fa fa-plus"></i> <span>NEW ROLE</span></a></li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if($canViewSupplier || $canEditSupplier || $canCreateSupplier)
                    <li class="treeview
                        {{url()->current() == url('/supplier') ||
                         url()->current() == url('/supplier/create') ?'active':''}}
                            ">
                        <a href="#"><i class="fa fa-suitcase"></i> <span>SUPPLIER</span>
                            <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>

                        </span>
                        </a>
                        <ul class="treeview-menu">
                            @if($canViewSupplier)
                                <li class="{{url()->current() == url('/supplier')?'active':''}}"><a href="{{url('/supplier')}}"><i class="fa fa-eye"></i> <span>VIEW SUPPLIERS</span></a></li>
                            @endif
                            @if($canCreateSupplier)
                                <li class="{{url()->current() == url('/supplier/create')?'active':''}}"><a href="{{url('/supplier/create')}}"><i class="fa fa-plus"></i> <span>NEW SUPPLIER</span></a></li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if($canCreateProduct ||
                    $canViewProduct ||
                    $canEditProduct ||
                    $canCreateProductRequest ||
                    $canViewProductRequest ||
                    $canApproveProductRequest ||
                    $canConfirmProductRequest ||
                    $canIssueProducts
                    )
                    <li class="treeview
                        {{url()->current() == url('/product') ||
                         url()->current() == url('/product/create') ?'active':''||
                         url()->current() == url('/product/request') ?'active':''||
                         url()->current() == url('/product/requests') ?'active':''||
                         url()->current() == url('/product/issue/select') ?'active':''
                         }}
                            ">
                        <a href="#"><i class="fa fa-shopping-cart"></i> <span>PRODUCT</span>
                            <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>

                        </span>
                        </a>
                        <ul class="treeview-menu">
                            @if($canViewProduct)
                                <li class="{{url()->current() == url('/product')?'active':''}}"><a href="{{url('/product')}}"><i class="fa fa-eye"></i> <span>VIEW PRODUCTS</span></a></li>
                            @endif
                            @if($canCreateProduct)
                                <li class="{{url()->current() == url('/product/create')?'active':''}}"><a href="{{url('/product/create')}}"><i class="fa fa-plus"></i> <span>NEW PRODUCT</span></a></li>
                            @endif
                            @if($canCreateProductRequest)
                                <li class="{{url()->current() == url('/product/request')?'active':''}}"><a href="{{url('/product/request')}}"><i class="fa fa-plus-square"></i> <span>REQUEST PRODUCTS</span></a></li>
                            @endif
                            @if($canViewProductRequest)
                                <li class="{{url()->current() == url('/product/requests')?'active':''}}"><a href="{{url('/product/requests')}}"><i class="fa fa-bullseye"></i> <span>VIEW PRODUCT REQUESTS</span></a></li>
                            @endif
                            @if($canApproveProductRequest)
                                <li class="{{url()->current() == url('/product/requests/approve')?'active':''}}"><a href="{{url('/product/requests/approve')}}"><i class="fa fa-plus-square-o"></i> <span>APPROVE PRODUCT REQUESTS</span></a></li>
                            @endif
                            @if($canConfirmProductRequest)
                                <li class="{{url()->current() == url('/product/requests/confirm')?'active':''}}"><a href="{{url('/product/requests/confirm')}}"><i class="fa fa-check-square"></i> <span>CONFIRM PRODUCT REQUESTS</span></a></li>
                            @endif
                            @if($canIssueProducts)
                                <li class="{{url()->current() == url('/product/issue/select')?'active':''}}"><a href="{{url('/product/issue/select')}}"><i class="fa fa-minus-square"></i> <span>ISSUE PRODUCTS</span></a></li>
                            @endif
                            @if($canViewProductRequest)
                                <li class="{{url()->current() == url('/department_bill')?'active':''}}"><a href="{{url('/department_bill')}}"><i class="fa fa-area-chart"></i> <span>DEPARTMENT BILL</span></a></li>
                            @endif
                                @if($canViewProductRequest)
                                    <li class="{{url()->current() == url('/product_analysing')?'active':''}}"><a href="{{url('/product_analysing')}}"><i class="fa fa-area-chart"></i> <span>PRODUCT ANALYSING</span></a></li>
                                @endif
                        </ul>
                    </li>
                @endif
                @if($canCreateStock || $canViewStock || $canCreateStockRequest || $canViewStockRequest || $canApproveStockRequest || $canDownloadStockRequest)
                    <li class="treeview
                        {{url()->current() == url('/stock') ||
                         url()->current() == url('/stock/request/create') ?'active':''||
                         url()->current() == url('/stock/requests') ?'active':''||
                         url()->current() == url('/stock/create') ?'active':''
                         }}
                            ">
                        <a href="#"><i class="fa fa-bar-chart"></i> <span>STOCK</span>
                            <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>

                        </span>
                        </a>
                        <ul class="treeview-menu">
                            @if($canViewStock)
                                <li class="{{url()->current() == url('/stock')?'active':''}}"><a href="{{url('/stock')}}"><i class="fa fa-eye"></i> <span>VIEW STOCKS</span></a></li>
                            @endif
                            @if($canCreateStock)
                                <li class="{{url()->current() == url('/stock/create')?'active':''}}"><a href="{{url('/stock/create')}}"><i class="fa fa-plus"></i> <span>ADD NEW STOCK</span></a></li>
                            @endif
                            @if($canCreateStockRequest)
                                <li class="{{url()->current() == url('/stock/request/create')?'active':''}}"><a href="{{url('/stock/request/create')}}"><i class="fa fa-plus-square-o"></i> <span>NEW STOCK REQUEST</span></a></li>
                            @endif
                            @if($canViewStockRequest || $canDownloadStockRequest)
                                <li class="{{url()->current() == url('/stock/requests')?'active':''}}"><a href="{{url('/stock/requests')}}"><i class="fa fa-bullseye"></i> <span>VIEW STOCK REQUESTS</span></a></li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if($canViewInventory)
                    <li class="{{url()->current() == url('/inventory')?'active':''}}"><a href="{{url('/inventory')}}"><i class="fa fa-align-justify"></i> <span>STORES</span></a></li>
                @endif
            </ul>
            <!-- /.sidebar-menu -->
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                @yield('header')
                <small>@yield('description')</small>
            </h1>
        </section>

        <!-- Main content -->
        <section class="content container-fluid">

            @yield('content')

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Main Footer -->
    <footer class="main-footer">
        <!-- To the right -->
        <div class="pull-right hidden-xs">
            Stores Management System
        </div>
        <!-- Default to the left -->
        <strong>Copyright &copy; 2018 <a href="http://www.i3cubes.com/" target="_blank">i3Cubes</a>.</strong> All rights reserved.
    </footer>

    <!-- /.control-sidebar -->

</div>
<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 3 -->
<script src="{{asset('bower_components/jquery/dist/jquery.min.js')}}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{asset('bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('dist/js/adminlte.min.js')}}"></script>

<script src="{{asset('js/jquery-confirm.min.js')}}"></script>

<script src="{{asset('js/toastr.min.js')}}"></script>

<script src="{{asset('js/datatables.min.js')}}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>


<script>
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-bottom-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "3000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
</script>
@if(session('success'))
    <script>
        toastr.success("{{session('success')}}", 'Success !')
    </script>
@endif
@yield('scripts')
</body>
</html>