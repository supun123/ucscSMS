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
    <i class="fa fa-user"></i> Edit Employee
@endsection

@section('page-link')
    <a href="{{url('/employee')}}">Employee</a> / <a href="{{url('/employee/'.$employee->id.'/edit')}}">Edit Employee</a>
@endsection

@section('header')
    <i class="fa fa-refresh"></i> Edit Employee
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8 col-md-offset-2">

        @include('layouts.messages.success')

            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">Employee Data Form</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                {!! Form::model($employee,['action' => ['EmployeeController@update',$employee->id],'method'=>'PATCH','files'=>true]) !!}
                    <div class="box-body">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <img height="100px" width="100px" src="{{$employee->img_url?asset($employee->img_url):asset('/img/user/malex50.jpg')}}" alt="" class="img-rounded img-thumbnail" id="imgUser">
                                    <div class="form-group {{$errors->has('image')?'has-error':''}}">
                                        <label for="exampleInputFile">Profile Image</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" name="image" class="custom-file-input" id="imgUserInput">
                                            </div>
                                        </div>
                                        <span class="help-block">{{$errors->first('image')?$errors->first('image'):''}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-md-6">

                                    <div class="form-group {{$errors->has('emp_id')?'has-error':''}}">
                                        <label for="emp_id">Employee ID</label>
                                        {!! Form::text('emp_id', null,['placeholder'=>'20180724001','class'=>'form-control form-control-sm','readonly']) !!}
                                        <span class="help-block">{{$errors->first('emp_id')?$errors->first('emp_id'):''}}</span>
                                    </div>
                                    <div class="form-group {{$errors->has('title_id')?'has-error':''}}">
                                        <label for="id">Title</label>
                                        {!! Form::select('title_id', $titles, null,['placeholder'=>'Select a title','class'=>'form-control form-control-sm']) !!}
                                        <span class="help-block">{{$errors->first('title_id')?$errors->first('title_id'):''}}</span>
                                    </div>
                                    <div class="form-group {{$errors->has('initials')?'has-error':''}}">
                                        <label for="initials">Initials</label>
                                        {!! Form::text('initials', null,['placeholder'=>'Initials','class'=>'form-control form-control-sm']) !!}
                                        <span class="help-block">{{$errors->first('initials')?$errors->first('initials'):''}}</span>
                                    </div>
                                    <div class="form-group {{$errors->has('last_name')?'has-error':''}}">
                                        <label for="last_name">Last Name</label>
                                        {!! Form::text('last_name', null,['placeholder'=>'Last Name','class'=>'form-control form-control-sm']) !!}
                                        <span class="help-block">{{$errors->first('last_name')?$errors->first('last_name'):''}}</span>
                                    </div>
                                    <div class="form-group {{$errors->has('full_name')?'has-error':''}}">
                                        <label for="full_name">Full Name</label>
                                        {!! Form::text('full_name', null,['placeholder'=>'Full Name','class'=>'form-control form-control-sm']) !!}
                                        <span class="help-block">{{$errors->first('full_name')?$errors->first('full_name'):''}}</span>
                                    </div>
                                    <div class="form-group {{$errors->has('date_of_birth')?'has-error':''}}">
                                        <label for="date_of_birth">Date of Birth</label>
                                        {!! Form::date('date_of_birth', $employee->date_of_birth,['class'=>'form-control form-control-sm']) !!}
                                        <span class="help-block">{{$errors->first('date_of_birth')?$errors->first('date_of_birth'):''}}</span>
                                    </div>
                                    <div class="form-group {{$errors->has('nic')?'has-error':''}}">
                                        <label for="nic">NIC Number</label>
                                        {!! Form::text('nic', null,['placeholder'=>'1234567890V','class'=>'form-control form-control-sm']) !!}
                                        <span class="help-block">{{$errors->first('nic')?$errors->first('nic'):''}}</span>
                                    </div>
                                    <div class="form-group {{$errors->has('gender_id')?'has-error':''}}">
                                        <label for="gender_id">Gender</label>
                                        {!! Form::select('gender_id', $genders, null,['placeholder'=>'Select a gender','class'=>'form-control form-control-sm']) !!}
                                        <span class="help-block">{{$errors->first('gender_id')?$errors->first('gender_id'):''}}</span>
                                    </div>

                                </div>

                                <div class="col-md-6">

                                    <div class="form-group {{$errors->has('marital_status_id')?'has-error':''}}">
                                        <label for="marital_status_id">Marital Status</label>
                                        {!! Form::select('marital_status_id', $maritalStatusList, null,['placeholder'=>'Select a gender','class'=>'form-control form-control-sm']) !!}
                                        <span class="help-block">{{$errors->first('marital_status_id')?$errors->first('marital_status_id'):''}}</span>
                                    </div>
                                    <div class="form-group {{$errors->has('mobile')?'has-error':''}}">
                                        <label for="mobile">Mobile Number</label>
                                        {!! Form::text('mobile', null,['placeholder'=>'0711234567','class'=>'form-control form-control-sm']) !!}
                                        <span class="help-block">{{$errors->first('mobile')?$errors->first('mobile'):''}}</span>
                                    </div>
                                    <div class="form-group {{$errors->has('land')?'has-error':''}}">
                                        <label for="land">Land Line Number</label>
                                        {!! Form::text('land', null,['placeholder'=>'0332212345','class'=>'form-control form-control-sm']) !!}
                                        <span class="help-block">{{$errors->first('land')?$errors->first('land'):''}}</span>
                                    </div>
                                    <div class="form-group {{$errors->has('email')?'has-error':''}}">
                                        <label for="email">Email address</label>
                                        {!! Form::text('email', null,['placeholder'=>'example@xyz.com','class'=>'form-control form-control-sm','type'=>'email']) !!}
                                        <span class="help-block">{{$errors->first('email')?$errors->first('email'):''}}</span>
                                    </div>
                                    <div class="form-group {{$errors->has('division_id')?'has-error':''}}">
                                        <label for="division_id">Division</label>
                                        {!! Form::select('division_id', $divisions, null,['placeholder'=>'Select a division','class'=>'form-control form-control-sm']) !!}
                                        <span class="help-block">{{$errors->first('division_id')?$errors->first('division_id'):''}}</span>
                                    </div>
                                    <div class="form-group {{$errors->has('designation_id')?'has-error':''}}">
                                        <label for="designation_id">Designation</label>
                                        {!! Form::select('designation_id', $designations, null,['placeholder'=>'Select a designation','class'=>'form-control form-control-sm']) !!}
                                        <span class="help-block">{{$errors->first('designation_id')?$errors->first('designation_id'):''}}</span>
                                    </div>

                                    <div class="form-group {{$errors->has('date_of_join')?'has-error':''}}">
                                        <label for="date_of_join">Date of Join</label>
                                        {!! Form::date('date_of_join', $employee->date_of_join,['class'=>'form-control form-control-sm']) !!}
                                        <span class="help-block">{{$errors->first('date_of_join')?$errors->first('date_of_join'):''}}</span>
                                    </div>
                                    <div class="form-group {{$errors->has('address')?'has-error':''}}">
                                        <label for="address">Address</label>
                                        {!! Form::textarea('address', null,['placeholder'=>'','class'=>'form-control form-control-sm','rows'=>'4']) !!}
                                        <span class="help-block">{{$errors->first('address')?$errors->first('address'):''}}</span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="box-footer">
                        {!! Form::submit('Update',['class'=>'btn btn-primary']) !!}
                        {!! Form::reset('Clear',['class'=>'btn btn-warning']) !!}
                    </div>
                {!! Form::close() !!}
            </div>
            <!-- /.card -->
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#imgUser').attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
        $(function () {
            $('#imgUserInput').change(function () {
                readURL(this);
            })
        });
    </script>
@endsection