@extends('layouts.app')

@section('title','Employee')

@section('styles')

@endsection

@section('header')
    <i class="fa fa-user"></i> Employee Profile
@endsection

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-md-3">

                <!-- Profile Image -->
                <div class="box box-primary">
                    <div class="box-body box-profile">
                        <img class="profile-user-img img-responsive img-circle" src="{{$employee->img_url?asset($employee->img_url):asset('img/user.png')}}" alt="User profile picture">

                        <h3 class="profile-username text-center">{{$employee->shortName}}</h3>

                        <p class="text-muted text-center">{{$employee->designation->name}}</p>

                        <ul class="list-group list-group-unbordered">
                            <li class="list-group-item">
                                <b>Email</b> <a class="pull-right">{{$employee->email}}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Mobile Number</b> <a class="pull-right">{{$employee->mobile}}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Land Line Number</b> <a class="pull-right">{{$employee->land}}</a>
                            </li>
                        </ul>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
            <div class="col-md-6">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#activity" data-toggle="tab">Employee</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="active tab-pane" id="activity">
                            <!-- Post -->
                            <div class="post">
                                <div class="user-block">
                                    <img class="img-circle img-bordered-sm" src="{{$employee->img_url?asset($employee->img_url):asset('img/user.png')}}" alt="user image">
                                    <span class="username">
                                        <a href="#">{{$employee->title->name.' '.$employee->full_name}}</a>
                                    </span>
                                    <span class="description">Joined date - {{$employee->date_of_join->toDateString()}}</span>
                                    <h5>Date Of Birth - {{$employee->date_of_birth->toDateString()}}</h5>
                                    <h5>NIC Number - {{$employee->nic}}</h5>
                                    <h5>Gender - {{$employee->gender->name}}</h5>
                                    <h5>Marital Status - {{$employee->marital_status->name}}</h5>
                                    <h5>Address - {{$employee->address}}</h5>
                                    <h5>Division - {{$employee->division->name}}</h5>
                                    <h5>Designation - {{$employee->designation->name}}</h5>
                                    <h5>Date Of Join - {{$employee->date_of_join->toDateString()}}</h5>
                                </div>
                            </div>
                        </div>
                        <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div>
                <!-- /.nav-tabs-custom -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
@endsection

@section('scripts')

@endsection