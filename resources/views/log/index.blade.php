@extends('layouts.app')

@section('title','Activity Log')

@section('styles')
    <link rel="stylesheet" href="{{asset('plugins/datatables/dataTables.bootstrap4.css')}}">
@endsection


@section('header')
    <i class="fa fa-user"></i> View Log
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">

            <div class="box box-success direct-chat direct-chat-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Activity Log</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="col-md-12">
                        <table class="table" id="tblEmployee">
                            <thead >
                            <tr>
                                <th width="10px"><i class="fa fa-eye"></i></th>
                                <th>ID</th>
                                <th>User Name</th>
                                <th>Timestamp</th>
                                <th>Type</th>
                                <th>Message</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($logs)
                                @foreach($logs as $log)
                                    <tr>
                                        <td width="10px"><a href="{{url('/employee/'.$log->user->employee->id.'/show')}}"><i class="fa fa-eye"></i></a></td>
                                        <td>{{$log->user->employee->emp_id}}</td>
                                        <td>{{$log->user->employee->initials.$log->user->employee->last_name}}</td>
                                        <td>{{$log->timestamp}}</td>
                                        <td>{{$log->log_type->name}}</td>
                                        <td>{{$log->message}}</td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                            <tfoot >
                            <tr>
                                <th width="10px"><i class="fa fa-eye"></i></th>
                                <th>ID</th>
                                <th>User Name</th>
                                <th>Timestamp</th>
                                <th>Type</th>in
                                <th>Message</th>
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
            $('#tblEmployee').dataTable({
                'scrollX':true,
                'paging'      : true,
                'lengthChange': true,
                'searching'   : true,
                'ordering'    : true,
                'info'        : true,
                'autoWidth'   : false,
                "order": [[ 3, "desc" ]],
                dom: 'lBfrtip',
                buttons: [
                    'copy','csv',
                    {
                        extend: 'excelHtml5',
                        messageTop: 'Stores Management System - Activity Log',
                        title:'Activity Log '+'{{\Carbon\Carbon::now()}}'
                    }, {
                        extend: 'pdfHtml5',
                        orientation: 'portrait',
                        pageSize: 'A4',
                        messageTop: 'Stores Management System - Activity Log',
                        title:'Activity Log '+'{{\Carbon\Carbon::now()}}'
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

                    var counter = 0;
                    this.api().columns().every( function () {
                        var column = this;
                        if (column.header().firstChild.data === undefined){
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