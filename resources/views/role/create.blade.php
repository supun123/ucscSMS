@extends('layouts.app')

@section('title','Role')

@section('styles')

@endsection

@section('top-links')

@endsection

@section('header')
    Create New Role
@endsection

@section('page-link')
    <a href="{{url('/user/roles')}}">Roles</a> / <a href="{{url('/role/create')}}">Create</a>
@endsection

@section('content')

    <div class="col-md-6 col-md-offset-3">


        @include('layouts.messages.success')

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Creating a role</h3>
                <a href="{{url('/user/roles')}}" class="btn btn-primary pull-right">Back</a>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            {!! Form::open(['method' => 'post','action'=>'RoleController@store','files'=>true]) !!}
            <div class="box-body">

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group {{$errors->has('name')?'has-error':''}}">
                            <label for="name">Role Name</label>
                            {{Form::text('name',null,['class'=>'form-control','placeholder'=>'Role Name'])}}
                            <span class="help-block">{{$errors->first('name')?$errors->first('name'):''}}</span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Module</th>
                                <th>Permissions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($modules as $module)
                                <tr>
                                    <td>{{$module->name}}</td>
                                    <td>|
                                        @foreach($module->permissions as $permission)
                                            <input type='checkbox' name='permissions[{{$module->name}}][]' value='{{$permission->id}}'>
                                            {{$permission->name}}|
                                        @endforeach
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="form-group">
                    <hr>
                    {{Form::submit('SAVE', ['class'=>'btn btn-success'])}}
                    {{Form::reset('RESET', ['class'=>'btn btn-warning'])}}
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection

@section('scripts')

@endsection
