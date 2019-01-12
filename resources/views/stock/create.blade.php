@extends('layouts.app')

@section('title','New Stock')

@section('styles')
    <style>
        .border-bottom{
            margin-bottom: 10px;
        }
        .form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control{
            background-color: #f3f6ff;
        }
    </style>
@endsection

@section('header')
    <i class="fa fa-cubes"></i> New Stock
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">

            @include('layouts.messages.success')

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Stock Form</h3>

                    <div class="box-tools pull-right">
                        <a href="{{URL::previous() }}" class="btn btn-primary btn-sm pull-right"> <i class="fa fa-angle-left"> </i> Back</a>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    {!! Form::open(['action' => 'StockController@store','method'=>'POST']) !!}
                    <div class="col-md-12">
                        <div class="row border-bottom">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group {{$errors->has('stock_request_number')?'has-error':''}}">
                                            <label for="stock_request_number">Stock Request Number</label>
                                            {!! Form::text('stock_request_number', $stockRequest->stock_request_number,['placeholder'=>'SRN0001','class'=>'form-control form-control-sm' , 'readonly']) !!}
                                            <span class="help-block">{{$errors->first('stock_request_number')?$errors->first('stock_request_number'):''}}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group {{$errors->has('stock_number')?'has-error':''}}">
                                            <label for="stock_number">Stock Number</label>
                                            {!! Form::text('stock_number', null,['placeholder'=>'SN001','class'=>'form-control form-control-sm','required']) !!}
                                            <span class="help-block">{{$errors->first('stock_number')?$errors->first('stock_number'):''}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group {{$errors->has('invoice_number')?'has-error':''}}">
                                            <label for="invoice_number">Invoice Number</label>
                                            {!! Form::text('invoice_number', null,['placeholder'=>'Invoice number','class'=>'form-control form-control-sm','required']) !!}
                                            <span class="help-block">{{$errors->first('invoice_number')?$errors->first('invoice_number'):''}}</span>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group {{$errors->has('date')?'has-error':''}}">
                                            <label for="date">Stock Received Date</label>
                                            {!! Form::date('date', \Carbon\Carbon::now(),['placeholder'=>'Stock Received Date','class'=>'form-control form-control-sm','required']) !!}
                                            <span class="help-block">{{$errors->first('date')?$errors->first('date'):''}}</span>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group {{$errors->has('supplier_id')?'has-error':''}}">
                                            <label for="supplier_id">Supplier</label>
                                            {!! Form::select('supplier_id', $suppliers,null,['placeholder'=>'Select a supplier','class'=>'form-control form-control-sm','required']) !!}
                                            <span class="help-block">{{$errors->first('supplier_id')?$errors->first('supplier_id'):''}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <span class="help-block">Enter received product quantity for each items</span>
                                <span class="help-block" style="color:#dd4b39">{{$errors->first('request')?$errors->first('request'):''}}</span>
                                <div class="box border-left ui-widget-shadow {{$errors->first('items')?'box-danger':''}}">
                                    <div class="box-header">
                                        <h3 class="box-title">Products list </h3>
                                        <span class="help-block">
                                            <p style="color:#dd4b39">{{$errors->first('items')?$errors->first('items'):''}}</p>
                                        </span>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body table-responsive no-padding">

                                        <table class="table" id="tblProduct">
                                            <thead >
                                            <tr>
                                                <th rowspan="2" width="30px">Image</th>
                                                <th rowspan="2">code</th>
                                                <th rowspan="2">Name</th>
                                                <th rowspan="2">Sub Category</th>
                                                <th colspan="2">Quantity</th>
                                                <th style="width: 15em">Unit Price (Rs.)</th>
                                            </tr>
                                            <tr>
                                                <th style="width: 5em">Requested</th>
                                                <th style="width: 10em" >Received (Old | New)</th>
                                                <th style="width: 15em" >Price/Tax/Total</th>
                                                <th >Total (Rs.)</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if($stockRequest->items)
                                                @foreach($stockRequest->items as $item)
                                                    <tr style="{{$item->received_quantity===$item->quantity?'background-color: #abea94':''}}">
                                                        <td >
                                                            <img height="30px" src="{{$item->product->image_url?asset($item->product->image_url):asset('/img/productx50.bmp')}}" alt="">
                                                        </td>
                                                        <td>{{$item->product->code}}</td>
                                                        <td>{{$item->product->name}}</td>
                                                        <td>{{$item->product->subCategory->category->name}}</td>
                                                        <td>{{$item->quantity}}</td>
                                                        @if($item->received_quantity!==$item->quantity)
                                                            <td>
                                                                <input name="items[{{$item->product->id}}][product_id]" type="hidden" size="4" value="{{$item->product->id}}">
                                                                <input name="items[{{$item->product->id}}][stock_request_items_id]" type="hidden" size="4" value="{{$item->id}}">
                                                                <input id="{{$item->product->id}}txtOldQuantity" proId="{{$item->product->id}}" style="width: 4em" type="text" size="4" value="{{$item->received_quantity}}" required readonly>
                                                                <input id="{{$item->product->id}}txtQuantity" proId="{{$item->product->id}}" style="width: 4em" name="items[{{$item->product->id}}][quantity]" max="{{$item->quantity-$item->received_quantity}}" type="number" size="4" value="0" required placeholder="quantity" class="txtPrices">
                                                            </td>
                                                            <td>
                                                                <input id="{{$item->product->id}}txtUnitPrice" proId="{{$item->product->id}}" style="width: 5em" name="items[{{$item->product->id}}][unit_price]" type="number" value="0.00" min="0.00" step="0.01" max="999999" size="4" placeholder="Unit Price"  class="txtPrices">
                                                                <input id="{{$item->product->id}}txtTax" proId="{{$item->product->id}}" style="width: 5em" name="items[{{$item->product->id}}][tax]" type="number" min="0.00" value="0.00" step="0.01" max="999999" size="4" placeholder="Tax"  class="txtPrices">
                                                                <input id="{{$item->product->id}}txtTotal" proId="{{$item->product->id}}" style="width: 5em" name="items[{{$item->product->id}}][total]" type="text" min="0.00" value="0.00" step="0.01" max="999999" size="4" placeholder="Total"  readonly>
                                                            </td>
                                                            <td>
                                                                <input id="{{$item->product->id}}txtGrandTotal" proId="{{$item->product->id}}" style="width: 5em" name="items[{{$item->product->id}}][grand_total]" type="text" min="0.00" value="0.00" step="0.01" max="999999" size="4" placeholder="Total"  readonly>
                                                            </td>
                                                        @else
                                                            <td>{{$item->received_quantity}}</td>
                                                            <td>N/A</td>
                                                            <td>N/A</td>
                                                        @endif
                                                    </tr>
                                                @endforeach
                                            @endif
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.box-body -->
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.box-body -->
                <div class="box-footer clearfix">
                    {!! Form::submit('Save',['class'=>'btn btn-primary']) !!}
                    {!! Form::Reset('Clear',['class'=>'btn btn-warning']) !!}

                    {!! Form::close() !!}
                </div>
                <!-- /.box-footer -->
            </div>
        </div>
        @endsection

        @section('scripts')
            <script src="{{asset('plugins/datatables/dataTables.bootstrap4.js')}}"></script>
            <script>
                $(function () {
                    var table = $('#tblProduct').DataTable({
                        responsive :true,
                        paginate:false,
                        "searching": false
                    });
                    $('.txtPrices').on('keyup',function (e) {
                        var proId = $(this).attr('proId');
                        var unitPrice = $('#'+proId+'txtUnitPrice').val();
                        var tax = $('#'+proId+'txtTax').val();
                        var quantity = $('#'+proId+'txtQuantity').val();

                        var a = parseFloat(unitPrice) + parseFloat(tax);
                        qt = parseInt(quantity);

                        if (isNaN(a)){
                            $('#'+proId+'txtTotal').val('Not valid');
                        }else {
                            $('#'+proId+'txtTotal').val(a);
                        }

                        if(isNaN(qt)){
                            $('#'+proId+'txtGrandTotal').val('Not valid');
                        }
                        else{
                            $('#'+proId+'txtGrandTotal').val(a*qt);
                        }
                    })
                })
            </script>
@endsection