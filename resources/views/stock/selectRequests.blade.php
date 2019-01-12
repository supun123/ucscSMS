@extends('layouts.app')

@section('title','Stock Requests')

@section('styles')
    <link rel="stylesheet" href="{{asset('plugins/datatables/dataTables.bootstrap4.css')}}">
@endsection


@section('header')
    <i class="fa fa-tasks"></i> Stock Requests
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">Select a stock request to add new stock</h3>
                </div>
                <div class="box-body">
                    <table class="table" id="tblSupplier">
                        <thead >
                        <tr>
                            <th >Request Number</th>
                            <th >Requested By</th>
                            <th >Requested Date</th>
                            <th style="min-width:20px;max-width: 20px">View</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($requests)
                            @foreach($requests as $request)
                                <tr>
                                    <td>{{$request->stock_request_number?$request->stock_request_number:''}}</td>
                                    <td>{{
                                            $request->requestedBy?$request->requestedBy->initials.' '.
                                            $request->requestedBy->last_name:''}}
                                    </td>
                                    <td>{{$request->date?$request->date:''}}</td>
                                    <td style="min-width:20px;max-width: 40px">
                                        <a href="{{url('/stock/'.$request->id.'/create/')}}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Add Stock</a>
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
    <script src="{{asset('plugins/datatables/dataTables.bootstrap4.js')}}"></script>
    <script>
        $(document).ready(function() {
            $('#tblSupplier','#tblApprovedRequests').dataTable({
                responsive :true
            });
        } );
    </script>
@endsection