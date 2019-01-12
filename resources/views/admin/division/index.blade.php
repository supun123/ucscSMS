@extends('layouts.app')

@section('title','New Division')

@section('styles')

@endsection

@section('header')
    <i class="fa fa-university"></i> Manage Division
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6 col-md-offset-3">

            @include('layouts.messages.success')

            <div class="box box-primary">
                <div class="box-header with-border">
                    {{--<h3 class="box-title">New Division</h3>--}}
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                   <div class="col-md-5">
                       {!! Form::open(['action' => 'DivisionController@store','method'=>'POST']) !!}
                       <div class="form-group {{$errors->has('head_employee_id')?'has-error':''}}">
                           <label for="head_employee_id">Divisional Head</label>
                           {!! Form::select('head_employee_id', $employees, null,['placeholder'=>'Select a Employee','class'=>'form-control form-control-sm']) !!}
                           <span class="help-block">{{$errors->first('head_employee_id')?$errors->first('head_employee_id'):''}}</span>
                       </div>
                       <div class="form-group {{$errors->has('name')?'has-error':''}}">
                           <label for="name">Division Name</label>
                           {!! Form::text('name', null,['placeholder'=>'Division Name','class'=>'form-control form-control-sm']) !!}
                           <span class="help-block">{{$errors->first('name')?$errors->first('name'):''}}</span>
                       </div>
                   </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer clearfix">

                    {!! Form::submit('Save',['class'=>'btn btn-primary btn-sm']) !!}
                    {!! Form::Reset('Clear',['class'=>'btn btn-warning btn-sm']) !!}

                    {!! Form::close() !!}
                </div>
                <!-- /.box-footer -->

                <div class="box-header with-border">
                    <h3 class="box-title">Current Divisions</h3>
                </div>

                <div class="box-body">
                    <div class="col-md-12">
                        <table class="table" id="tblDivision">
                            <thead >
                            <tr>
                                <th>Name</th>
                                <th >Edit</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($divisions)
                                @foreach($divisions as $division)
                                    <tr>
                                        <td>{{$division->name}}</td>
                                        <td>
                                            <a href="{{url('/division/'.$division->id.'/edit')}}" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
@endsection

@section('scripts')


@endsection