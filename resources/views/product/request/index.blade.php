@extends('layouts.app')

@section('title','Products Requests')

@section('styles')
    <link rel="stylesheet" href="{{asset('plugins/datatables/dataTables.bootstrap4.css')}}">
    <link rel="stylesheet" href="{{asset('js/print/print.min.css')}}">
    <script src="{{asset('js/print/print.min.js')}}"></script>
@endsection


@section('header')
    <i class="fa fa-list-ol"></i> Products Requests
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">

            @include('layouts.messages.success')

            <div class="box box-success direct-chat direct-chat-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Requests List</h3>

                    <div class="box-tools pull-right">
                        <a href="{{url('/product/request')}}" class="btn btn-primary btn-sm pull-right"> <i class="fa fa-plus"> </i> New Request</a>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="col-md-12">
                        <table class="table" id="tblProduct">
                            <thead >
                            <tr>
                                <th width="30px" >Request Number</th>
                                <th >Requested By (Division)</th>
                                <th >Requested at</th>
                                <th >Status</th>
                                <th style="min-width:20px;max-width: 20px"></th>
                            </tr>
                            </thead>
                            <tbody>

                            @if($requests)
                                @foreach($requests as $request)
                                    <tr>
                                        <td>{{$request->product_request_number?$request->product_request_number:''}}</td>
                                        <td>{{$request->requestedBy?$request->requestedBy->initials.' '.
                                        $request->requestedBy->last_name.' ( '.
                                        $request->requestedBy->division->name.' )':''}}</td>
                                        <td>{{$request->requested_at?$request->requested_at->toDayDateTimeString():''}}</td>
                                        <td>
                                            @if($request->completed_at)
                                                <span class="label label-success">Completed</span>
                                            @elseif($request->last_issued_at)
                                                <span class="label label-default">Partially Completed</span>
                                            @elseif($request->confirmed_at)
                                                <span class="label label-primary">Confirmed</span>
                                            @elseif($request->approved_at)
                                                <span class="label label-info">Approved</span>
                                            @elseif($request->requested_at)
                                                <span class="label label-warning">Pending</span>
                                            @endif
                                        </td>
                                        <td><a data-toggle="modal" data-target="#modalApproved{{$request->id}}" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></a></td>
                                    </tr>
                                @endforeach
                            @endif

                            </tbody>
                        </table>

                        @if($requests)
                            @foreach($requests as $request)
                                <div class="modal fade" id="modalApproved{{$request->id}}" style="display: none;" >
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">

                                            <div class="modal-body" id="modalContent{{$request->id}}">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Product Request</h4>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <h5>Requested By : {{$request->requestedBy->initials.' '.$request->requestedBy->last_name}}</h5>
                                                        <h5>Requested Date : {{$request->requested_at->toDayDateTimeString()}}</h5>
                                                        <hr>
                                                        <h5>Division : {{$request->requestedBy->division->name}}</h5>
                                                        <h5>Head of the division : {{$request->requestedBy->division->head->shortName}}</h5>
                                                        <hr>
                                                        <h4>Requested Products</h4>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <table class="table" id="tblProduct">
                                                            <thead >
                                                            <tr>
                                                                <th width="30px" >Image</th>
                                                                <th >code</th>
                                                                <th >Name</th>
                                                                <th >Category</th>
                                                                <th >Subcategory</th>
                                                                <th >Quantity</th>
                                                                <th style="min-width:10px;max-width: 10px"></th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @if($request->items)
                                                                <input class="form-group" type="hidden" name="request_id" value="{{$request->id}}" size="4" required>
                                                                @foreach($request->items as $item)
                                                                    <tr>
                                                                        <td><img height="30px" src="{{$item->product->image_url?asset($item->product->image_url):asset('/img/productx50.bmp')}}" alt=""></td>
                                                                        <td>{{$item->product->code}}</td>
                                                                        <td>{{$item->product->name}}</td>
                                                                        <td>{{$item->product->subCategory->category->name}}</td>
                                                                        <td>{{$item->product->subCategory->name}}</td>
                                                                        <td>{{$item->quantity}}</td>
                                                                    </tr>
                                                                @endforeach
                                                            @endif
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <a data-toggle="modal" data-target="#modalApproved{{$request->id}}" class="btn btn-default btnOK">OK</a>

                                                <button type="button" class="btn btn-primary" onclick="printJS('modalContent{{$request->id}}', 'html')">
                                                    <i class="fa fa-print"></i> Print
                                                </button>
                                            </div>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
            <!--/.direct-chat -->
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{asset('plugins/datatables/dataTables.bootstrap4.js')}}"></script>
    <script>
        $(document).ready(function() {
            $('#tblProduct').dataTable({
                responsive :true
            });
        } );


    </script>
@endsection