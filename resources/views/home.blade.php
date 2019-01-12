@extends('layouts.app')
@section('title','Home')

@section('styles')
    <style>
        .b-home {
            background: #3498db;
            background-image: -webkit-linear-gradient(top, #3498db, #2980b9);
            background-image: -moz-linear-gradient(top, #3498db, #2980b9);
            background-image: -ms-linear-gradient(top, #3498db, #2980b9);
            background-image: -o-linear-gradient(top, #3498db, #2980b9);
            background-image: linear-gradient(to bottom, #3498db, #2980b9);
            -webkit-border-radius: 4;
            -moz-border-radius: 4;
            border-radius: 4px;
            font-family: Arial;
            color: #ffffff;
            font-size: 24px;
            padding: 23px;
            text-decoration: none;
            margin-top: 10px;
        }

        .b-home:hover {
            background: #3cb0fd;
            background-image: -webkit-linear-gradient(top, #3cb0fd, #3498db);
            background-image: -moz-linear-gradient(top, #3cb0fd, #3498db);
            background-image: -ms-linear-gradient(top, #3cb0fd, #3498db);
            background-image: -o-linear-gradient(top, #3cb0fd, #3498db);
            background-image: linear-gradient(to bottom, #3cb0fd, #3498db);
            text-decoration: none;
            margin-top: 10px;
        }
    </style>
@endsection
@section('content')
    <div class="login-logo">
        <i class=" 	fa fa-building fa-x"></i>
        <a href="{{route('home')}}"><b> STORES MANAGEMENT SYSTEM FOR</b><br> <b> I3CUBES PVT. LTD.</b></a>
    </div>
    {{--@if(!$errors->isEmpty())--}}
    {{--@foreach($errors->all() as $error)--}}

    {{--<div class="alert alert-danger" role="alert">--}}
    {{--<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>--}}
    {{--<strong>Error!</strong> {{ $error }}--}}
    {{--</div>--}}
    {{--@endforeach--}}

    {{--@endif--}}
    {{--<div class="row">--}}
    {{--<div class="col-md-12">--}}
    {{--<h1 class="text center">Dashboard</h1>--}}
    {{--</div>--}}
    {{--</div>--}}
    <!-- Small boxes (User details) -->
    <div class="row">
        <?php
        $canViewUser = Auth::user()->canViewUser();
        $canEditUser = Auth::user()->canEditUser();
        $canCreateUser = Auth::user()->canCreateUser();
        ?>
        <div class="col-md-3">
            @if($canViewUser)
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>{{$usersCount}}</h3>

                        <p>Users</p>
                    </div>
                    @if($canEditUser)
                        <div class="icon">
                            <a href= "{{url('/user/create/select')}}"><i class="ion ion-person-add"></i></a>
                        </div>
                    @endif
                    <a href="{{url('/user')}}" class="small-box-footer">
                        More info <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            @endif

        </div>
    <?php
    $canViewProduct = Auth::user()->canViewProduct();
    $canEditProduct = Auth::user()->canEditProduct();
    $canCreateProduct = Auth::user()->canCreateProduct();
    ?>
    <!-- Small boxes (Product details) -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            @if($canViewProduct)
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>{{$productCount}}</h3>

                        <p>Products</p>
                    </div>
                    @if($canEditProduct)
                        <div class="icon">
                            <a href="{{url('/product/create')}}"><i class="fa fa-shopping-cart"></i></a>
                        </div>
                    @endif
                    <a href="{{url('/product')}}" class="small-box-footer">
                        More info <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            @endif
        </div>
    <?php
    $canViewEmployee = Auth::user()->canViewEmployee();
    $canEditEmployee = Auth::user()->canEditEmployee();
    $canCreateEmployee = Auth::user()->canCreateEmployee();
    ?>
    <!-- Small boxes (Employee details) -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            @if($canViewEmployee)
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>{{$employeeCount}}</h3>

                        <p>Employee</p>
                    </div>
                    @if($canEditEmployee)
                        <div class="icon">
                            <a href="{{url('/employee/create')}}"><i class="fa fa-user"></i></a>
                        </div>
                    @endif
                    <a href="{{url('/employee')}}" class="small-box-footer">
                        More info <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            @endif
        </div>
    <?php
    $canViewSupplier = Auth::user()->canViewSupplier();
    $canEditSupplier = Auth::user()->canEditSupplier();
    $canCreateSupplier = Auth::user()->canCreateSupplier();
    ?>
    <!-- Small boxes (Supplier details) -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            @if($canViewSupplier)
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>{{$supplierCount}}</h3>

                        <p>Supplire</p>
                    </div>
                    @if($canEditSupplier)
                        <div class="icon">
                            <a href="{{url('/supplier/create')}}"><i class="fa fa-users"></i></a>
                        </div>
                    @endif
                    <a href="{{url('/supplier')}}" class="small-box-footer">
                        More info <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            @endif
        </div>

    </div>
    <!-- table details -->
    <?php
    $canViewInventory = Auth::user()->canViewInventory();
    ?>
    @if($canViewInventory)
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Critical Reorder Level Product</h3>

                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tr>
                                <th>Product Code</th>
                                <th>Stock Number</th>
                                <th>Product Name</th>
                                <th>Subcategory Name</th>
                                <th>Quantity</th>
                            </tr>
                            @if($products)
                                @foreach($products as $product)
                                    @if($product->quantity<=$product->product->critical_reorder_level)
                                        <tr bgcolor="#FF3399">
                                            <td>{{$product?$product->product->code:''}}</td>
                                            <td>{{$product?$product->stock->stock_number:''}}</td>
                                            <td>{{$product?$product->product->name:''}}</td>
                                            <td>{{$product?$product->product->subCategory->name:''}}</td>
                                            <td>{{$product?$product->quantity:''}}</td>
                                            {{--<td>--}}
                                            {{--<a data-toggle="modal" data-target="#modalApproved{{$product->id}}" class="btn btn-primary btn-xs"><i class="fa fa-eye"></i> Stocks</a>--}}
                                            {{--</td>--}}
                                        </tr>

                                    @elseif($product->quantity===0)
                                        <tr>
                                            <td>{{$product?$product->product->code:''}}</td>
                                            <td>{{$product?$product->stock->stock_number:''}}</td>
                                            <td>{{$product?$product->product->name:''}}</td>
                                            <td>{{$product?$product->product->subCategory->name:''}}</td>
                                            <td>{{$product?$product->quantity:''}}</td>
                                            {{--<td>--}}
                                            {{--<a data-toggle="modal" data-target="#modalApproved{{$product->id}}" class="btn btn-primary btn-xs"><i class="fa fa-eye"></i> Stocks</a>--}}
                                            {{--</td>--}}
                                        </tr>

                                    @endif
                                @endforeach
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif

@endsection
