@extends('layouts.app')

@section('title','Stores')

@section('styles')
    <link rel="stylesheet" href="{{asset('plugins/datatables/dataTables.bootstrap4.css')}}">
    <link rel="stylesheet" href="{{asset('js/print/print.min.css')}}">
    <script src="{{asset('js/print/print.min.js')}}"></script>
@endsection


@section('header')
    <i class="fa fa-align-justify"></i> Stores
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary direct-chat direct-chat-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Products</h3>

                    <div class="box-tools pull-right">
                        <a href="{{URL::previous() }}" class="btn btn-primary btn-sm pull-right"> <i class="fa fa-angle-left"> </i> Back</a>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="col-md-12">
                        <table class="table" id="tblSupplier">
                            <thead >
                            <tr>
                                <th >Product ID</th>
                                <th >Stock Number</th>
                                <th >Product Name</th>
                                <th >Product Category</th>
                                <th >Quantity</th>
                                <th style="min-width: 20px; min-height: 20px"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($products)
                                @foreach($products as $product)
                                    <tr style="background-color:
                                    @if($product->quantity===0)
                                            #ff6266
                                    @elseif($product->quantity<=$product->product->critical_reorder_level)
                                            #ffb9bc
                                    @elseif($product->quantity<=$product->product->reorder_level)
                                            #FFA07A
                                    @endif
                                            ">
                                        <td>{{$product?$product->product->code:''}}</td>
                                        <td>{{$product?$product->stock->stock_number:''}}</td>
                                        <td>{{$product?$product->product->name:''}}</td>
                                        <td>{{$product?$product->product->subCategory->name:''}}</td>
                                        <td>{{$product?$product->quantity:''}}</td>
                                        <td>
                                            <a data-toggle="modal" data-target="#modalApproved{{$product->id}}" class="btn btn-primary btn-xs"><i class="fa fa-eye"></i> Stocks</a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                        @if($products)
                            @foreach($products as $product)
                                <div class="modal fade" id="modalApproved{{$product->id}}" style="display: none;">
                                    <div class="modal-dialog modal-md">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">×</span></button>
                                                <h4 class="modal-title">Stocks</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row" id="modalContent{{$product->id}}">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <table>
                                                                <tr>
                                                                    <td width="30%">
                                                                        <img src="{{asset($product->product->image_url)}}" alt="" style="padding-right: 20px">
                                                                    </td>
                                                                    <td width="70%">
                                                                        <h5>Product Code :{{$product->product->code}}</h5>
                                                                        <h5>Product Name : {{$product->product->name}}</h5>
                                                                        <h5>Product Category : {{$product->product->subCategory->name.' - '.$product->product->subCategory->category->name}}</h5>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                        <hr>
                                                        <h4>Stocks</h4>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <table class="table" id="tblProduct">
                                                            <thead >
                                                            <tr>
                                                                <td>Stock Number</td>
                                                                <td>Quantity</td>
                                                                <td>Unit Price(Rs)</td>
                                                                <td>tax(Rs)</td>
                                                                <td>Unit Price+Tax(Rs)</td>
                                                                <td>Total(Rs)</td>
                                                            </tr>
                                                            {{--<tr>--}}
                                                            {{--<th style="width: 15em" >Price+Tax=Total</th>--}}
                                                            {{--<th >Total (Rs.)</th>--}}
                                                            {{--</tr>--}}
                                                            </thead>
                                                            <tbody>
                                                            <?PHP
                                                            $stores = \App\Models\Inventory::where('product_id','=',$product->product->id)->where('quantity','!=',0)->get();
                                                            ?>
                                                            @if($stores)
                                                                @foreach($stores as $store)
                                                                    <?php
                                                                    $item = \App\Models\StockItem::where('stock_id','=',$store->stock->id)->first();
                                                                    ?>
                                                                    <tr>
                                                                        <td>{{$store->stock->stock_number}}</td>
                                                                        <td>{{$store->quantity}}</td>
                                                                        <td>{{number_format($item->unit_price,2)}}</td>
                                                                        <td>{{number_format($item->tax,2)}}</td>
                                                                        <td>{{number_format($item->unit_price+$item->tax,2)}}</td>
                                                                        <td>{{number_format(($item->unit_price+$item->tax)*$store->quantity,2)}}</td>
                                                                    </tr>
                                                                @endforeach
                                                            @endif
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-primary" onclick="printJS('modalContent{{$product->id}}', 'html')">
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
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{asset('plugins/datatables/dataTables.bootstrap4.js')}}"></script>
    <script>
        $(document).ready(function() {
            $('#tblSupplier').dataTable({
                responsive :true
            });
        } );
    </script>
@endsection