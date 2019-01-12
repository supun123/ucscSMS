@extends('layouts.app')

@section('title','Department Bill')

@section('styles')

@endsection


@section('header')
    <i class="fa fa-user"></i> Department Bill
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6 col-md-offset-3">

            @include('layouts.messages.success')

            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">Select a department and select date range</h3>
                </div>
                <div class="box-body">
                    {!! Form::open(['action' => 'ReportController@generateDepartmentBill','method'=>'POST']) !!}
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group {{$errors->has('division_id')?'has-error':''}}">
                                <label for="division_id">Division</label>
                                {!! Form::select('division_id', $divisions, null,['placeholder'=>'Select a division','class'=>'form-control form-control-sm']) !!}
                                <span class="help-block">{{$errors->first('division_id')?$errors->first('division_id'):''}}</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group {{$errors->has('start_date')?'has-error':''}}">
                                <label for="start_date">Start Date</label>
                                {!! Form::date('start_date', null,['class'=>'form-control form-control-sm']) !!}
                                <span class="help-block">{{$errors->first('start_date')?$errors->first('start_date'):''}}</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group {{$errors->has('end_date')?'has-error':''}}">
                                <label for="end_date">End Date</label>
                                {!! Form::date('end_date', null,['class'=>'form-control form-control-sm']) !!}
                                <span class="help-block">{{$errors->first('end_date')?$errors->first('end_date'):''}}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="box-footer clearfix">
                    {!! Form::submit('Save',['class'=>'btn btn-primary']) !!}
                    {!! Form::Reset('Clear',['class'=>'btn btn-warning']) !!}

                    {!! Form::close() !!}
                </div>
                <!-- /.box-footer -->
            </div>
        </div>
    </div>
@endsection

@section('scripts')

@endsection