@extends('layouts.app')

@section('title','Employee')

@section('styles')

@endsection

@section('top-links')
    <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
        <a href="index3.html" class="nav-link">Home</a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
    </li>
@endsection

@section('page-header')
    <i class="fa fa-user"></i> View Employee
@endsection

@section('page-link')
    <a href="{{url('/employee')}}">Employee</a> / <a href="{{url('/employee/'.$employee->id.'/show')}}">View Employee</a>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">

        @include('layouts.messages.success')
        @include('layouts.messages.error')

            <!-- general form elements -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Employee Data Form</h3>
                </div>


                <!-- /.card-header -->
                <!-- form start -->
                {!! Form::model($employee,['action' => ['EmployeeController@update',$employee->id],'method'=>'PATCH','files'=>true]) !!}
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <img src="{{$employee->img_url?asset($employee->img_url):asset('img/user.png')}}" alt="" class="img-rounded img-thumbnail" id="imgUser">
                                <br>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-md-6">

                                <div class="form-group">
                                    <label for="id">Employee ID</label>
                                    {!! Form::text('id', null,['placeholder'=>'20180724001','class'=>'form-control','readonly']) !!}
                                </div>
                                <div class="form-group">
                                    <label for="id">Title</label>
                                    {!! Form::select('title_id', $titles, null,['placeholder'=>'Select a title','class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    <label for="initials">Initials</label>
                                    {!! Form::text('initials', null,['placeholder'=>'Initials','class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    <label for="last_name">Last Name</label>
                                    {!! Form::text('last_name', null,['placeholder'=>'Last Name','class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    <label for="full_name">Full Name</label>
                                    {!! Form::text('full_name', null,['placeholder'=>'Full Name','class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    <label for="date_of_birth">Date of Birth</label>
                                    {!! Form::date('date_of_birth', $employee->date_of_birth,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    <label for="nic">NIC Number</label>
                                    {!! Form::text('nic', null,['placeholder'=>'1234567890V','class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    <label for="gender_id">Gender</label>
                                    {!! Form::select('gender_id', $genders, null,['placeholder'=>'Select a gender','class'=>'form-control']) !!}
                                </div>

                            </div>

                            <div class="col-md-6">

                                <div class="form-group">
                                    <label for="marital_status_id">Marital Status</label>
                                    {!! Form::select('marital_status_id', $maritalStatusList, null,['placeholder'=>'Select a gender','class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    <label for="mobile">Mobile Number</label>
                                    {!! Form::text('mobile', null,['placeholder'=>'0711234567','class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    <label for="mobile">Land Line Number</label>
                                    {!! Form::text('land', null,['placeholder'=>'0332212345','class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    <label for="email">Email address</label>
                                    {!! Form::text('email', null,['placeholder'=>'example@xyz.com','class'=>'form-control','type'=>'email']) !!}
                                </div>
                                <div class="form-group">
                                    <label for="designation_id">Designation</label>
                                    {!! Form::select('designation_id', $designations, null,['placeholder'=>'Select a designation','class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    <label for="date_of_join">Date of Join</label>
                                    {!! Form::date('date_of_join', $employee->date_of_join,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    {!! Form::textarea('address', null,['placeholder'=>'','class'=>'form-control','rows'=>'4']) !!}
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <a href="{{url('/employee/'.$employee->id.'/edit')}}" class="btn btn-primary pull-right">Edit</a>
                    </div>
                {!! Form::close() !!}
            </div>
            <!-- /.card -->
        </div>
    </div>

@endsection

@section('scripts')
    <script>

    </script>
@endsection