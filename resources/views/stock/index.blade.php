@extends('layouts.app')

@section('title','Stocks')

@section('styles')
    <link rel="stylesheet" href="{{asset('plugins/datatables/dataTables.bootstrap4.css')}}">
@endsection


@section('header')
    <i class="fa fa-cubes"></i> Stocks
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-success direct-chat direct-chat-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Stocks List</h3>

                    <div class="box-tools pull-right">
                        <a href="{{url('/stock/create')}}" class="btn btn-primary btn-sm pull-right"> <i class="fa fa-plus"> </i> New Stock</a>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="col-md-12">
                        <table class="table" id="tblSupplier">
                            <thead >
                            <tr>
                                <th >Request Number</th>
                                <th >Stock Number</th>
                                <th >Invoice Number</th>
                                <th >Supplier</th>
                                <th >Date</th>
                                <th style="min-width: 20px; min-height: 20px"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($stocks)
                                @foreach($stocks as $stock)
                                    <tr>
                                        <td>{{$stock->stockRequest?$stock->stockRequest->stock_request_number:''}}</td>
                                        <td>{{$stock->stock_number?$stock->stock_number:''}}</td>
                                        <td>{{$stock->invoice_number?$stock->invoice_number:''}}</td>
                                        <td>{{$stock->supplier->company_name?$stock->supplier->company_name:''}}</td>
                                        <td>{{$stock->date?$stock->date->toDateString():''}}</td>
                                        <td>
                                            <a data-toggle="modal" data-target="#modalApproved{{$stock->id}}" class="btn btn-primary btn-xs"><i class="fa fa-eye"></i> Products</a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                        @if($stocks)
                            @foreach($stocks as $stock)
                                <div class="modal fade" id="modalApproved{{$stock->id}}" style="display: none;">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">×</span></button>
                                                <h4 class="modal-title">Stock Items</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <h5>Stock Number : {{$stock->stock_number }}</h5>
                                                                <h5>Invoice Number : {{$stock->invoice_number}}</h5>
                                                                <h5>Request Number : {{$stock->stockRequest->stock_request_number}}</h5>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <h5>Received Date : {{$stock->date->toDateString()}}</h5>
                                                                <h5>Supplier Name : {{$stock->supplier->company_name}}</h5>
                                                                <h5>Entered By : {{$stock->createdBy->initials.' '.$stock->createdBy->last_name}}</h5>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <h4>Received Products</h4>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <table class="table" id="tblProduct">
                                                            <thead >
                                                            <tr>
                                                                <th rowspan="2" width="30px">Image</th>
                                                                <th rowspan="2">code</th>
                                                                <th rowspan="2">Name</th>
                                                                <th rowspan="2">Sub Category</th>
                                                                <th rowspan="2">Quantity</th>
                                                                <th style="width: 15em">Unit Price (Rs.)</th>
                                                            </tr>
                                                            <tr>
                                                                <th style="width: 15em" >Price+Tax=Total</th>
                                                                <th >Total (Rs.)</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @if($stock->items)
                                                                @foreach($stock->items as $item)
                                                                    <tr>
                                                                        <td><img height="30px" src="{{$item->stockRequestItem->product->image_url?asset($item->stockRequestItem->product->image_url):asset('/img/productx50.bmp')}}" alt=""></td>
                                                                        <td>{{$item->stockRequestItem->product->code}}</td>
                                                                        <td>{{$item->stockRequestItem->product->name}}</td>
                                                                        <td>{{$item->stockRequestItem->product->subCategory->category->name}}</td>
                                                                        <td>{{$item->quantity}}</td>
                                                                        <td>{{number_format($item->unit_price,2,'.',',')}} + {{number_format($item->tax,2,'.',',')}} = {{number_format($item->unit_price+$item->tax,2,'.',',')}}</td>
                                                                        <td>{{number_format($item->quantity*($item->unit_price+$item->tax), 2, ',', '.')}}</td>
                                                                    </tr>
                                                                @endforeach
                                                            @endif
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <a href="{{url('/stock/request/'.$stock->id.'/download')}}" class="btn btn-success pull-left">Print</a>
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
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{asset('js/datatables.min.js')}}"></script>
    <script>
        $(document).ready(function() {
            $('#tblSupplier').dataTable({
                responsive :true
            });
        } );
    </script>
@endsection