@extends('layouts.app')

@section('title','New Stock Request')

@section('styles')
    <style>
        .border-bottom{
            margin-bottom: 10px;
        }
        .shadow-danger{
            -webkit-box-shadow: 0px 7px 14px -10px rgba(255,94,94,1);
            -moz-box-shadow: 0px 7px 14px -10px rgba(255,94,94,1);
            box-shadow: 0px 7px 14px -10px rgba(255,94,94,1);
        }
    </style>
@endsection

@section('header')
    <i class="fa fa-cubes"></i> New Stock Request
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">

            @include('layouts.messages.success')

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Stock Request Form</h3>

                    <div class="box-tools pull-right">
                        <a href="{{URL::previous() }}" class="btn btn-primary btn-sm pull-right"> <i class="fa fa-angle-left"> </i> Back</a>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    {!! Form::open(['action' => 'StockRequestController@store','method'=>'POST']) !!}
                    <div class="col-md-12">
                        <div class="row border-bottom">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group {{$errors->has('stock_request_number')?'has-error':''}}">
                                            <label for="stock_request_number">Stock Request Number</label>
                                            {!! Form::text('stock_request_number', $stockReqNumber ,['placeholder'=>'SRN0001','class'=>'form-control form-control-sm','required']) !!}
                                            <span class="help-block">{{$errors->first('stock_request_number')?$errors->first('stock_request_number'):''}}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group {{$errors->has('date')?'has-error':''}}">
                                            <label for="date">Date</label>
                                            {!! Form::text('date', \Carbon\Carbon::now()->toDateString(),['placeholder'=>'Product Date','class'=>'form-control form-control-sm','readonly']) !!}
                                            <span class="help-block">{{$errors->first('date')?$errors->first('date'):''}}</span>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">

                                <span class="help-block"> Select products and enter quantity.</span>
                                <div class="box border-left ui-widget-shadow {{$errors->first('items')?'box-danger':''}}">
                                    <div class="box-header">
                                        <h3 class="box-title">Products list </h3>
                                        <a data-toggle="modal" data-target="#modal-default" class="btn btn-info btn-xs pull-right"><i class="fa fa-plus"></i> Select Products</a>
                                        <span class="help-block"><p style="color:#dd4b39">{{$errors->first('items')?$errors->first('items'):''}}</p></span>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body table-responsive no-padding">
                                        <table class="table table-hover table-small">
                                            <tbody >
                                            <tr id="tblRequestedProducts">
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Quantity</th>
                                                <th style="min-width:10px;max-width: 10px">Remove</th>
                                            </tr>
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
                    {!! Form::submit('Add',['class'=>'btn btn-primary']) !!}
                    {!! Form::Reset('Clear',['class'=>'btn btn-warning']) !!}

                    {!! Form::close() !!}
                </div>
                <!-- /.box-footer -->
            </div>
            <div class="modal fade" id="modal-default" style="display: none;">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span></button>
                            <h4 class="modal-title">Product List</h4>
                        <br>
                            <button class="btn btn-primary pull-right" id="btnAddReorderItems">Reorder Level</button>
                            <br>
                            <br>
                            <button class="btn btn-primary pull-right" id="btnAddCriticalReorderItems">Critical Reorder Level</button>
                        </div>
                        <div class="modal-body">
                            <table class="table" id="tblProduct">
                                <thead >
                                <tr>
                                    <th width="30px" >Image</th>
                                    <th >code</th>
                                    <th >Name</th>
                                    <th >Category</th>
                                    <th >Sub Category</th>
                                    <th >Type</th>
                                    <th style="min-width:10px;max-width: 10px"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($products)
                                    @foreach($products as $product)
                                        <?PHP
                                        $inventorys = \App\Models\Inventory::where('product_id','=',$product->id)->get();
                                        $sum = 0;
                                        foreach ($inventorys as $inventory){
                                            $sum+=$inventory->quantity;
                                        }
                                        ?>
                                        <tr style="background-color:
                                        @if($sum===0)
                                                #ff6266
                                        @elseif($sum<=$product->critical_reorder_level)
                                                #ffb9bc
                                        @elseif($sum<=$product->reorder_level)
                                                #FFA07A
                                        @endif
                                                " class="{{($sum!==0)&&$sum<=$product->reorder_level?'reorderItems':''}} {{($sum!==0)&&$sum<=$product->critical_reorder_level?'criticalreorderItems':''}}"
                                            proId="{{$product->id}}"
                                            color="@if($sum===0)
                                                    {{'#ff6266'}}
                                                        @elseif($sum<=$product->critical_reorder_level)
                                                    {{'#ffb9bc'}}
                                                        @elseif($sum<=$product->reorder_level)
                                                    {{'#FFA07A'}}
                                               @endif">
                                            <td >
                                                {{--                                        <img height="50px" src="{{$employee->img_url?$employee->img_url:asset('/img/user.png')}}" alt="">--}}
                                                <img height="30px" src="{{$product->image_url?asset($product->image_url):asset('/img/productx50.bmp')}}" alt="">
                                            </td>
                                            <td>{{$product->code}}</td>
                                            <td>{{$product->name}}</td>
                                            <td>{{$product->subCategory->name}}</td>
                                            <td>{{$product->subCategory->category->name}}</td>
                                            <td>{{$product->type->name}}</td>
                                            <td>
                                                <a id="btnAddToProduct{{$product->id}}" productId="{{$product->id}}" productCode="{{$product->code}}"  name="{{$product->name}}" class="btn btn-primary btn-xs btnAddProduct"><i class="fa fa-angle-right"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button>

                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
        </div>
        @endsection

        @section('scripts')
            <script src="{{asset('plugins/datatables/dataTables.bootstrap4.js')}}"></script>
            <script>
                $(function () {
                    var table = $('#tblProduct').DataTable({
                        responsive :true,
                        paginate:false
                    });

                    $('.btnAddProduct').on('click',function () {
                        var productId = this.id;
                        var button = $('#'+productId);
                        var productCode = button.attr('productCode');
                        var proId = button.attr('productId');
                        var productName = this.name;
                        var tr = "\n" +
                            "<tr id='tra"+productId+"' >\n" +
                            "  <td>"+productCode+"<input class='hidden' name='items["+proId+"][product_id]' value='"+proId+"'/></td>\n" +
                            "  <td>"+productName+"</td>\n" +
                            "  <td>\n" +
                            "    <input type=\"number\" value=\"0\" min=\"0\" step=\"1\" name=\"items["+proId+"][quantity]\" type=\"text\" required class=\"form-control-xs\" size=\"3\">\n" +
                            "  </td>\n" +
                            "<td><a id='a"+productId+"' productId='"+proId+"' class='btn btn-warning btn-xs btnRemoveItem'><i class='fa fa-minus'></i></a></td>" +
                            "</tr>";
                        $('#tblRequestedProducts').after(tr);
                        var color = button.closest('tr').attr('color');
                        button.hide();
                        button.closest('tr').css("background-color","#ffddcf");
                        $('.btnRemoveItem').on('click',function (e) {

                            table.search( '' ).draw();

                            $('input[type=search]').val('').change();
                            var selectedItemId = $(this).attr('id');
                            var proId = $(this).attr('productId');
                            $('#tr'+selectedItemId).html('');
                            var addButton =  $('#btnAddToProduct'+proId);
                            addButton.show();
                            addButton.closest('tr').css("background-color",color);
                        })
                    });

                    $('#btnAddReorderItems').on('click',function () {
                        var reorderItems = $('.reorderItems');

                        $.each(reorderItems, function (key, value) {
                            var code = value.cells[1].firstChild.data;
                            var name = value.cells[2].firstChild.data;
                            var prodId = value.attributes.proId.nodeValue;
                            var color = value.attributes.color.nodeValue;

                            var productId = prodId;
                            var button = $('#btnAddToProduct'+productId);
                            var productCode = code;
                            var proId = prodId;
                            var productName = name;
                            var tr = "\n" +
                                "<tr id='tra"+productId+"' >\n" +
                                "  <td>"+productCode+"<input class='hidden' name='items["+proId+"][product_id]' value='"+proId+"'/></td>\n" +
                                "  <td>"+productName+"</td>\n" +
                                "  <td>\n" +
                                "    <input type=\"number\" value=\"0\" min=\"0\" step=\"1\" name=\"items["+proId+"][quantity]\" type=\"text\" required class=\"form-control-xs\" size=\"3\">\n" +
                                "  </td>\n" +
                                "<td><a id='a"+productId+"' productId='"+proId+"' class='btn btn-warning btn-xs btnRemoveItem'><i class='fa fa-minus'></i></a></td>" +
                                "</tr>";
                            $('#tblRequestedProducts').after(tr);
                            button.hide();
                            $('#btnAddReorderItems').hide();
                            button.closest('tr').css("background-color","#ffddcf");
                            $('.btnRemoveItem').on('click',function (e) {

                                table.search( '' ).draw();

                                $('input[type=search]').val('').change();
                                var selectedItemId = $(this).attr('id');
                                var proId = $(this).attr('productId');
                                $('#tr'+selectedItemId).html('');
                                var addButton =  $('#btnAddToProduct'+proId);
                                addButton.show();
                                addButton.closest('tr').css("background-color",color);
                            })
                        })
                    });

//                    Crtical reorder item
                    $('#btnAddCriticalReorderItems').on('click',function () {
                        console.log('dds');
                        var reorderItems = $('.criticalreorderItems');

                        $.each(reorderItems, function (key, value) {
                            var code = value.cells[1].firstChild.data;
                            var name = value.cells[2].firstChild.data;
                            var prodId = value.attributes.proId.nodeValue;
                            var color = value.attributes.color.nodeValue;

                            var productId = prodId;
                            var button = $('#btnAddToProduct'+productId);
                            var productCode = code;
                            var proId = prodId;
                            var productName = name;
                            var tr = "\n" +
                                "<tr id='tra"+productId+"' >\n" +
                                "  <td>"+productCode+"<input class='hidden' name='items["+proId+"][product_id]' value='"+proId+"'/></td>\n" +
                                "  <td>"+productName+"</td>\n" +
                                "  <td>\n" +
                                "    <input type=\"number\" value=\"0\" min=\"0\" step=\"1\" name=\"items["+proId+"][quantity]\" type=\"text\" required class=\"form-control-xs\" size=\"3\">\n" +
                                "  </td>\n" +
                                "<td><a id='a"+productId+"' productId='"+proId+"' class='btn btn-warning btn-xs btnRemoveItem'><i class='fa fa-minus'></i></a></td>" +
                                "</tr>";
                            $('#tblRequestedProducts').after(tr);
                            button.hide();
                            $('#btnAddCriticalReorderItems').hide();
                            button.closest('tr').css("background-color","#ffddcf");
                            $('.btnRemoveItem').on('click',function (e) {

                                table.search( '' ).draw();

                                $('input[type=search]').val('').change();
                                var selectedItemId = $(this).attr('id');
                                var proId = $(this).attr('productId');
                                $('#tr'+selectedItemId).html('');
                                var addButton =  $('#btnAddToProduct'+proId);
                                addButton.show();
                                addButton.closest('tr').css("background-color",color);
                            })
                        })
                    });


                })
            </script>
@endsection