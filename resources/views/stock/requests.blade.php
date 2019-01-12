@extends('layouts.app')

@section('title','Stock Requests')

@section('styles')
    <link rel="stylesheet" href="{{asset('plugins/datatables/dataTables.bootstrap4.css')}}">
    <style>
        #qun{
            width: 60px;
        }
    </style>
@endsection

@section('header')
    <i class="fa fa-list-ol"></i> Stock Requests
@endsection

<?PHP
$canApproveStockRequest = Auth::user()->canApproveStockRequest();
?>

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    @if($canApproveStockRequest)
                        <li class="active"><a href="#activity" data-toggle="tab" aria-expanded="true">Pending <span class="label label-warning">{{count($requests)}}</span></a></li>
                        <li class=""><a href="#timeline" data-toggle="tab" aria-expanded="false">Approved <span class="label label-success">{{count($approvedRequests)}}</span></a></li>
                    @else
                    <li class="active"><a href="#timeline" data-toggle="tab" aria-expanded="true">Approved <span class="label label-success">{{count($approvedRequests)}}</span></a></li>
                    @endif
                </ul>
                <div class="tab-content">
                    @if($canApproveStockRequest)
                        <div class="tab-pane active" id="activity">

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
                                            <td style="min-width:20px;max-width: 20px">
                                                <a data-toggle="modal" data-target="#modal{{$request->id}}" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                            @if($requests)
                                @foreach($requests as $request)
                                    <div class="modal fade" id="modal{{$request->id}}" style="display: none;">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">×</span></button>
                                                    <h4 class="modal-title">Stock Request</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <h5>Requested By : {{$request->requestedBy->initials.' '.$request->requestedBy->last_name}}</h5>
                                                            <h5>Requested Date : {{$request->date->toDayDateTimeString()}}</h5>
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
                                                                {!! Form::open(['action' => 'StockRequestController@approve','method'=>'POST']) !!}
                                                                @if($request->items)
                                                                    <input class="form-group" type="hidden" name="request_id" value="{{$request->id}}" size="4" required>
                                                                    @foreach($request->items as $item)
                                                                        <tr>
                                                                            <td><img height="30px" src="{{$item->product->image_url?asset($item->product->image_url):asset('/img/productx50.bmp')}}" alt=""></td>
                                                                            <td>{{$item->product->code}}</td>
                                                                            <td>{{$item->product->name}}</td>
                                                                            <td>{{$item->product->subCategory->category->name}}</td>
                                                                            <td>{{$item->product->subCategory->name}}</td>
                                                                            <td style="min-width:5px;max-width: 5px">
                                                                                <input class="form-group" type="hidden" name="items[{{$item->product->id}}][product_id]" value="{{$item->product->id}}" size="4" required>
                                                                                <input width="10px" class="form-group" type="number" name="items[{{$item->product->id}}][quantity]" value="{{$item->quantity}}" size="2" id="qun" required>
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                @endif
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    {!! Form::submit('Approve',['class'=>'btn btn-success pull-left','name'=>'approve']) !!}
                                                    {!! Form::submit('Deny',['class'=>'btn btn-danger pull-left','name'=>'deny']) !!}
                                                    {!! Form::close() !!}
                                                </div>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    @endif
                <!-- /.tab-pane -->
                    <div class="tab-pane {{!$canApproveStockRequest?'active':''}}" id="timeline">
                        <table class="table" id="tblApprovedRequests">
                            <thead >
                            <tr>
                                <th >Request Number</th>
                                <th >Requested By</th>
                                <th >Requested Date</th>
                                <th >Status</th>
                                <th style="min-width:20px;max-width: 20px">View</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($approvedRequests)
                                @foreach($approvedRequests as $request)
                                    <tr>
                                        <td>{{$request->stock_request_number?$request->stock_request_number:''}}</td>
                                        <td>{{
                                            $request->requestedBy?$request->requestedBy->initials.' '.
                                            $request->requestedBy->last_name:''}}
                                        </td>
                                        <td>{{$request->date?$request->date:''}}</td>
                                        <td>
                                            @if($request->updated_at && !$request->completed_at)
                                                <span class="label label-default">partially Completed</span>
                                            @elseif($request->completed_at)
                                                <span class="label label-success">Completed</span>
                                            @else
                                                <span class="label label-warning">Not Received</span>
                                            @endif
                                        </td>
                                        <td style="min-width:20px;max-width: 20px">
                                            <a data-toggle="modal" data-target="#modalApproved{{$request->id}}" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                        @if($approvedRequests)
                            @foreach($approvedRequests as $request)
                                <div class="modal fade" id="modalApproved{{$request->id}}" style="display: none;">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">×</span></button>
                                                <h4 class="modal-title">Stock Request</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <h5>Requested No : {{$request->stock_request_number?$request->stock_request_number:''}}</h5>
                                                        <h5>Requested By : {{$request->requestedBy->initials.' '.$request->requestedBy->last_name}}</h5>
                                                        <h5>Requested Date : {{$request->date->toDayDateTimeString()}}</h5>
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
                                                            {!! Form::open(['action' => 'StockRequestController@approve','method'=>'POST']) !!}
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
                                                <a href="{{url('/stock/request/'.$request->id.'/download')}}" class="btn btn-success pull-left">Print</a>
                                                {!! Form::close() !!}
                                            </div>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
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