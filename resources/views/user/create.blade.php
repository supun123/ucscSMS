@extends('layouts.app')

@section('title','Employee')

@section('styles')

@endsection

@section('top-links')

@endsection

@section('header')
    <i class="fa fa-user"></i> Create New User Account
@endsection

@section('page-link')
    <a href="{{url('/user/')}}">User</a> /
    <a href="{{url('/user/create/select')}}">Create</a>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-sm-6 col-md-6 col-md-offset-3">

        @include('layouts.messages.success')
        @include('layouts.messages.error')

            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">User Data Form</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                {!! Form::open(['action' => 'UserController@store','method'=>'POST']) !!}
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <img src="{{asset($employee->img_url?$employee->img_url:'/img/user.png')}}" alt="" class="img-rounded img-thumbnail" id="imgUser">
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-md-12">

                                <div class="form-group {{$errors->has('id')?'has-error':''}}">
                                    <label for="id">Employee ID</label>
                                    {!! Form::hidden('id', $employee->id) !!}
                                    {!! Form::text('emp_id', $employee->emp_id,['class'=>'form-control form-control-sm','readonly']) !!}
                                    <span class="help-block">{{$errors->first('id')?$errors->first('id'):''}}</span>
                                </div>
                                <div class="form-group {{$errors->has('user_name')?'has-error':''}}">
                                    <label for="user_name">User Name</label>
                                    {!! Form::text('user_name', null,['placeholder'=>'User Name','class'=>'form-control form-control-sm']) !!}
                                    <span class="help-block">{{$errors->first('user_name')?$errors->first('user_name'):''}}</span>
                                </div>
                                <div class="form-group {{$errors->has('email')?'has-error':''}}">
                                    <label for="email">Email</label>
                                    {!! Form::text('email', $employee->email,['placeholder'=>'Email','class'=>'form-control form-control-sm']) !!}
                                    <span class="help-block">{{$errors->first('email')?$errors->first('email'):''}}</span>
                                </div>
                                <div class="form-group {{$errors->has('password')?'has-error':''}}">
                                    <label for="password">Password</label>
                                    {!! Form::password('password',['class'=>'form-control form-control-sm']) !!}
                                    <span class="help-block">{{$errors->first('password')?$errors->first('password'):''}}</span>
                                </div>
                                <div class="form-group {{$errors->has('password_confirmation')?'has-error':''}}">
                                    <label for="password_confirmation">Password Confirm</label>
                                    {!! Form::password('password_confirmation',['class'=>'form-control form-control-sm']) !!}
                                    <span class="help-block">{{$errors->first('password_confirmation')?$errors->first('password_confirmation'):''}}</span>
                                </div>
                                <div class="form-group {{$errors->has('role_id')?'has-error':''}}">
                                    <label for="role_id">Role</label>
                                    {!! Form::select('role_id', $roles, null,['placeholder'=>'Select a role','class'=>'form-control form-control-sm']) !!}
                                    <span class="help-block">{{$errors->first('role_id')?$errors->first('role_id'):''}}</span>
                                </div>
                                <div class="form-group {{$errors->has('is_active')?'has-error':''}}">
                                    <label for="is_active">Status</label>
                                    {!! Form::select('is_active', [1=>'Active',0=>'Not Active'], null,['placeholder'=>'Select a status','class'=>'form-control form-control-sm']) !!}
                                    <span class="help-block">{{$errors->first('is_active')?$errors->first('is_active'):''}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="box-footer">
                        {!! Form::submit('Save',['class'=>'btn btn-primary']) !!}
                        {!! Form::Reset('Clear',['class'=>'btn btn-warning']) !!}
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