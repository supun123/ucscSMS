@extends('layouts.app')

@section('title','Suppliers')

@section('styles')
    <link rel="stylesheet" href="{{asset('plugins/datatables/dataTables.bootstrap4.css')}}">
@endsection


@section('header')
    <i class="fa fa-gear"></i> View, Edit, Delete Suppliers
@endsection
<?PHP
$canCreateSupplier = Auth::user()->canCreateSupplier();
$canEditSupplier = Auth::user()->canEditSupplier();
$canViewSupplier = Auth::user()->canViewSupplier();
?>
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-success direct-chat direct-chat-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Suppliers List</h3>
                    @if($canCreateSupplier)
                        <div class="box-tools pull-right">
                            <a href="{{url('/supplier/create')}}" class="btn btn-primary btn-sm pull-right"> <i class="fa fa-plus"> </i> New Supplier</a>
                        </div>
                    @endif
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="col-md-12">
                        <table class="table" id="tblSupplier">
                            <thead >
                            <tr>
                                <th >Doc No</th>
                                <th >Company Name</th>
                                <th >Business Reg No</th>
                                <th >Phone</th>
                                <th >Email</th>
                                <th >Status</th>
                                @if($canEditSupplier)
                                    <th style="min-width:40px;max-width: 40px">Action</th>
                                @endif
                            </tr>
                            </thead>
                            <tbody>
                            @if($suppliers)
                                @foreach($suppliers as $supplier)
                                    <tr>
                                        <td>{{$supplier->doc_no?$supplier->doc_no:''}}</td>
                                        <td>{{$supplier->company_name?$supplier->company_name:''}}</td>
                                        <td>{{$supplier->business_reg_no?$supplier->business_reg_no:''}}</td>
                                        <td>{{$supplier->phone_1?$supplier->phone_1:''}}</td>
                                        <td>{{$supplier->email?$supplier->email:''}}</td>
                                        <td>
                                            @if($supplier->is_active=='1')
                                                {!! '<span class="badge bg-green">Active</span>' !!}
                                            @else
                                                {!! '<span class="badge bg-yellow">Not Active</span>' !!}
                                            @endif
                                        </td>
                                        @if($canEditSupplier)
                                            <td>
                                                <a href="{{url('/supplier/'.$supplier->id.'/edit')}}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                            <tfoot >
                            <tr>
                                <th >Doc No</th>
                                <th >Company Name</th>
                                <th >Business Reg No</th>
                                <th >Phone</th>
                                <th >Email</th>
                                <th >Status</th>
                                @if($canEditSupplier)
                                    <th style="min-width:40px;max-width: 40px"></th>
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
            $('#tblSupplier').dataTable({
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
                        messageTop: 'Stores Management System - Suppliers Report',
                        title:'Suppliers Report '+'{{\Carbon\Carbon::now()}}'
                    }, {
                        extend: 'pdfHtml5',
                        orientation: 'portrait',
                        pageSize: 'A4',
                        messageTop: 'Stores Management System - Suppliers Report',
                        title:'Suppliers Report '+'{{\Carbon\Carbon::now()}}'
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
                        if (column.header().firstChild.data === 'Action'){
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
    <script>
        $(document).ready(function() {
            $('#tblSupplier').dataTable({
                responsive :true
            });
        } );
        $(function () {
            $('.btnDelete').on('click',function () {
                var id  = this.id;
                $.ajax({
                    method:delete,

                })
            });
        })
    </script>
@endsection