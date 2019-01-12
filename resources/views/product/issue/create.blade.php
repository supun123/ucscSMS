@extends('layouts.app')

@section('title','Issue Products')

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
    <i class="fa fa-list"></i> Issue Products
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">

            @include('layouts.messages.success')
            @include('layouts.messages.error')

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Product Issue Form</h3>

                    <div class="box-tools pull-right">
                        <a href="{{URL::previous() }}" class="btn btn-primary btn-sm pull-right"> <i class="fa fa-angle-left"> </i> Back</a>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    {!! Form::open(['action' => 'ProductIssueController@store','method'=>'POST']) !!}
                    <div class="col-md-12">
                        <div class="row">
                            Request Number : {{$request->product_request_number}}
                            <input type="hidden" name="request_id" value="{{$request->id}}">
                        </div>
                        <div class="row border-bottom">
                            <div class="col-md-3">
                                <div class="row">
                                    Requested By : {{$request->requestedBy->initials.' '.$request->requestedBy->last_name}}
                                </div>
                                <div class="row">
                                    Approved By : {{$request->approvedBy->initials.' '.$request->approvedBy->last_name}}
                                </div>
                                <div class="row">
                                    Confirmed By : {{$request->confirmedBy->initials.' '.$request->confirmedBy->last_name}}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="row">
                                    {{$request->requested_at->toDayDateTimeString()}}
                                </div>
                                <div class="row">
                                    {{$request->approved_at->toDayDateTimeString()}}
                                </div>
                                <div class="row">
                                    {{$request->confirmed_at->toDayDateTimeString()}}
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
                                            </tr>
                                            <tr>
                                                <th style="width: 5em">Requested</th>
                                                <th style="width: 10em" >Received (Old | New)</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if($request->items)
                                                @foreach($request->items as $item)
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
                                                                <input name="items[{{$item->product->id}}][product_request_items_id]" type="hidden" size="4" value="{{$item->id}}">
                                                                <input id="{{$item->product->id}}txtOldQuantity" proId="{{$item->product->id}}" style="width: 4em" type="text" size="4" value="{{$item->received_quantity}}" required readonly>
                                                                <input id="{{$item->product->id}}txtQuantity" proId="{{$item->product->id}}" style="width: 4em" name="items[{{$item->product->id}}][quantity]" max="{{$item->quantity-$item->received_quantity}}" type="number" size="4" value="0" min="0" required placeholder="quantity" class="txtPrices">
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