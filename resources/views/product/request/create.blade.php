@extends('layouts.app')

@section('title','New Product Request')

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
    <i class="fa fa-gg"></i> New Product Request
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">

            @include('layouts.messages.success')

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Product Request Form</h3>

                    <div class="box-tools pull-right">
                        <a data-toggle="modal" data-target="#modal-default" class="btn btn-info btn-xs pull-right"><i class="fa fa-plus"></i> Select Products</a>
                    </div>
                    <span class="help-block"><p style="color:#dd4b39">{{$errors->first('items')?$errors->first('items'):''}}</p></span>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    {!! Form::open(['action' => 'ProductRequestController@store','method'=>'POST']) !!}

                    <table class="table table-hover table-small">
                        <tbody >
                        <tr id="tblRequestedProducts">
                            <th>Product Code</th>
                            <th>Name</th>
                            <th>Quantity</th>
                            <th style="min-width:10px;max-width: 10px">Remove</th>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
                <div class="box-footer clearfix">
                    <div class="button-bar pull-right">
                        {!! Form::submit('Send Request',['class'=>'btn btn-primary']) !!}
                        {!! Form::Reset('Clear',['class'=>'btn btn-warning']) !!}
                    </div>

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
                        </div>
                        <div class="modal-body">
                            <table class="table" style="width:100%" id="tblProduct">
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
                                        <tr>
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

                                <tfoot>
                                    <tr>
                                        <th>Code</th>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>Sub Category</th>
                                        <th>Type</th>
                                    </tr>
                                </tfoot>
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

	<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
	<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
            <script src="{{asset('plugins/datatables/dataTables.bootstrap4.js')}}"></script>

            <script>
                $(function () {

                    // Setup - add a text input to each footer cell
                    $('#tblProduct tfoot th').each( function () {
                        var title = $(this).text();
                        $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
                    } );
                    var table = $('#tblProduct').DataTable({
                        responsive :true,
                        paginate:false
                    });

                    // Apply the search
                    table.columns().every( function () {
                        var that = this;
                        $( 'input', this.footer() ).on( 'keyup change', function () {
                            if ( that.search() !== this.value ) {
                                that
                                    .search( this.value )
                                    .draw();
                            }
                        } );
                    } );


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
                            "    <input name=\"items["+proId+"][quantity]\" type=\"number\" value=\"0\" min=\"1\" step=\"1\" type=\"text\" required class=\"form-control-xs\" size=\"3\">\n" +
                            "  </td>\n" +
                            "<td><a id='a"+productId+"' productId='"+proId+"' class='btn btn-warning btn-xs btnRemoveItem'><i class='fa fa-minus'></i></a></td>" +
                            "</tr>";
                        $('#tblRequestedProducts').after(tr);
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
                            addButton.closest('tr').css("background-color","transparent");
                        })


                    })

                })
            </script>
@endsection
