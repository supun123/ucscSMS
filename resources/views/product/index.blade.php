@extends('layouts.app')

@section('title','Products')

@section('styles')
    <link rel="stylesheet" href="{{asset('plugins/datatables/dataTables.bootstrap4.css')}}">
@endsection


@section('header')
    <i class="fa fa-cart-arrow-down"></i> View, Edit, Delete Products
@endsection
<?PHP
$canCreateProduct = Auth::user()->canCreateProduct();
$canEditProduct = Auth::user()->canEditProduct();
?>
@section('content')
    <div class="row">
        <div class="col-md-12">

            <div class="box box-success direct-chat direct-chat-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Products List</h3>
                    @if($canCreateProduct)
                        <div class="box-tools pull-right">
                            <a href="{{url('/product/create')}}" class="btn btn-primary btn-sm pull-right"> <i class="fa fa-plus"> </i> New Product</a>
                        </div>
                    @endif
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="col-md-12">
                        <table class="table" id="tblProduct">
                            <thead >
                            <tr>
                                <th width="30px" >Image</th>
                                <th >code</th>
                                <th >Name</th>
                                <th >Category</th>
                                <th >Sub Category</th>
                                <th >Type</th>
                                <th >Status</th>
                                @if($canEditProduct)
                                    <th style="min-width:20px;max-width: 20px">Action</th>
                                @endif
                            </tr>
                            </thead>
                            <tbody>
                            @if($products)
                                @foreach($products as $product)
                                    <tr>
                                        <td >
                                            {{--                                        <img height="50px" src="{{$employee->img_url?$employee->img_url:asset('/img/user.png')}}" alt="">--}}
                                            <img height="30px" src="{{$product->image_url?$product->image_url:asset('/img/productx50.bmp')}}" alt="">
                                        </td>
                                        <td>{{$product->code}}</td>
                                        <td>{{$product->name}}</td>
                                        <td>{{$product->subCategory->name}}</td>
                                        <td>{{$product->subCategory->category->name}}</td>
                                        <td>{{$product->type->name}}</td>
                                        <td>
                                            @if($product->status->name === 'Active')
                                                <span class="label label-success">Active</span>
                                            @elseif($product->status->name === 'Discontinued')
                                                <span class="label label-warning">Discontinued</span>
                                            @endif
                                        </td>
                                        @if($canEditProduct)
                                            <td>
                                                <a href="{{url('/product/'.$product->id.'/edit')}}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                            <tfoot >
                            <tr>
                                <th width="30px" >Image</th>
                                <th >code</th>
                                <th >Name</th>
                                <th >Category</th>
                                <th >Sub Category</th>
                                <th >Type</th>
                                <th >Status</th>
                                @if($canEditProduct)
                                    <th style="min-width:20px;max-width: 20px">Action</th>
                                @endif
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <!--/.direct-chat -->
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{asset('plugins/datatables/dataTables.bootstrap4.js')}}"></script>
    <script src={{asset('js/export/buttons.flash.min.js')}}></script>
    <script src={{asset('js/export/buttons.html5.min.js')}}></script>
    <script src={{asset('js/export/buttons.print.min.js')}}></script>
    <script src={{asset('js/export/dataTables.buttons.min.js')}}></script>
    <script src={{asset('js/export/jszip.min.js')}}></script>
    <script src={{asset('js/export/pdfmake.min.js')}}></script>
    <script src={{asset('js/export/vfs_fonts.js')}}></script>
    <script src={{asset('js/export/buttons.colVis.min.js')}}></script>

    <script>
        $(document).ready(function() {
            $('#tblProduct').dataTable({
                'scrollX':true,
                'paging'      : true,
                'lengthChange': true,
                'searching'   : true,
                'ordering'    : true,
                'info'        : true,
                'autoWidth'   : false,
                "order": [[ 2, "desc" ]],
                dom: 'lBfrtip',
                buttons: [
                    'copy','csv',
                    {
                        extend: 'excelHtml5',
                        messageTop: 'Stores Management System - Products Report',
                        title:'Products Report '+'{{\Carbon\Carbon::now()}}'
                    }, {
                        extend: 'pdfHtml5',
                        orientation: 'portrait',
                        pageSize: 'A4',
                        messageTop: 'Stores Management System - Products Report',
                        title:'Products Report '+'{{\Carbon\Carbon::now()}}'
                    }, {
                        extend: 'print'
                    }
                ],
                initComplete: function () {

                    $('.buttons-pdf').html('<text class="btn btn-danger btn-xs"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF</text>');
                    $('.buttons-excel').html('<text class="btn btn-success btn-xs"><i class="fa fa-file-excel-o" aria-hidden="true"></i> EXCEL</text>');
                    $('.buttons-print').html('<text class="btn btn-primary btn-xs"><i class="fa fa-print" aria-hidden="true"></i> PRINT</text>');
                    $('.buttons-csv').html('<text class="btn btn-warning btn-xs"><i class="fa fa-file" aria-hidden="true"></i> CSV</text>');
                    $('.buttons-copy').html('<text class="btn btn-default btn-xs"><i class="fa fa-copy" aria-hidden="true"></i> COPY</text>');
                    $('.buttons-pdf').parent().prepend('<h4 class="text-dark"><i class="glyphicon glyphicon-export"></i> Export To</h4>');


                    this.api().columns().every( function () {
                        var column = this;
                        if (column.header().firstChild.data === 'Image'||
                            column.header().firstChild.data === 'Action'){
                            return;
                        }
                        var select = $('<select><option value=""></option></select>')
                            .appendTo( $(column.footer()).empty() )
                            .on( 'change', function () {
                                var val = $.fn.dataTable.util.escapeRegex(
                                    $(this).val()
                                );

                                column
                                    .search( val ? '^'+val+'$' : '', true, false )
                                    .draw();
                            } );

                        column.data().unique().sort().each( function ( d, j ) {
                            select.append( '<option value="'+d+'">'+d+'</option>' )
                        } );
                    } );
                }
            });
        } );
    </script>
@endsection