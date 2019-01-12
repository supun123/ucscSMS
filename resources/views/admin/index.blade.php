@extends('layouts.app')

@section('title','Employee')

@section('styles')
    <style>
        .table-fixed thead {
            width: 100%;
        }
        .table-fixed tbody {
            height: 250px;
            overflow-y: auto;
            width: 100%;
        }
        .table-fixed thead, .table-fixed tbody, .table-fixed tr, .table-fixed td, .table-fixed th {
            display: block;
        }
        .table-fixed tbody td, .table-fixed thead > tr> th {
            float: left;
            border-bottom-width: 0;
        }
    </style>

@endsection

@section('header')
    <i class="fa fa-cog"></i> Administrator Tools
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-3 col-xs-3">
            <a class="btn btn-block btn-primary btn-lg" href="{{url('division')}}">Division</a>
        </div>
        <div class="col-lg-3 col-xs-3">
            <a class="btn btn-block btn-primary btn-lg" href="{{url('designation')}}">Designation</a>
        </div>
        <div class="col-lg-3 col-xs-3">
            <a class="btn btn-block btn-primary btn-lg" href="{{url('productCategory')}}">Product Category</a>
        </div>
        <div class="col-lg-3 col-xs-3">
            <a class="btn btn-block btn-primary btn-lg" href="{{url('productSubCategory')}}">Product Subcategory</a>
        </div>
    </div>
    <br>
    <br>
    <!-- Activity logs details -->
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Activity Logs</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <table class="table table-fixed">
                        <thead class=".table-fixed thead">
                        <tr>
                            <th class="col-xs-1">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Profile</th>
                            <th class="col-xs-1">ID</th>
                            <th class="col-xs-2">User Name</th>
                            <th class="col-xs-3">Timestamp</th>
                            <th class="col-xs-2">Type</th>
                            <th class="col-xs-3">Message</th>
                        </tr>
                        </thead>
                        <tbody class="table-fixed tbody">
                        @if($logs)
                            @foreach($logs as $log)
                                <tr>
                                    <td class="col-xs-1" width="10px" align="center"><a href="{{url('/employee/'.$log->user->employee->id.'/show')}}"><i class="fa fa-eye"></i></a></td>
                                    <td class="col-xs-1">{{$log->user->employee->emp_id}}</td>
                                    <td class="col-xs-2">{{$log->user->employee->initials.$log->user->employee->last_name}}</td>
                                    <td class="col-xs-3">{{$log->timestamp}}</td>
                                    <td class="col-xs-2">{{$log->log_type->name}}</td>
                                    <td class="col-xs-3">{{$log->message}}</td>
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