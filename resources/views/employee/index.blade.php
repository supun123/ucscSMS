@extends('layouts.app')

@section('title','Employee')

@section('styles')
    <link rel="stylesheet" href="{{asset('plugins/datatables/dataTables.bootstrap4.css')}}">
@endsection


@section('header')
    <i class="fa fa-gear"></i> View, Edit, Delete Employees
@endsection
<?PHP
$canEditEmployee = Auth::user()->canEditEmployee();
$canViewEmployee = Auth::user()->canViewEmployee();
$canDeleteEmployee = Auth::user()->canDeleteEmployee();
?>
@section('content')
    <div class="row">
        <div class="col-md-12">

            <div class="box box-success direct-chat direct-chat-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Employee List</h3>

                    @if(Auth::user()->canCreateEmployee())
                        <div class="box-tools pull-right">
                            <a href="{{url('/employee/create')}}" class="btn btn-primary btn-sm pull-right"> <i class="fa fa-plus"> </i> New Employee</a>
                        </div>
                    @endif
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="col-md-12">
                        <table class="table" id="tblEmployee">
                            <thead >
                            <tr>
                                <th width="30px" >Photo</th>
                                <th >id</th>
                                <th >Name</th>
                                <th >Gender</th>
                                <th >Designation</th>
                                @if($canEditEmployee || $canDeleteEmployee)
                                    <th style="min-width:80px;max-width: 80px"></th>
                                @endif
                            </tr>
                            </thead>
                            <tbody>
                            @if($employees)
                                @foreach($employees as $employee)
                                    <tr>
                                        <td >
                                            <img height="30px" src="{{$employee->img_url?$employee->img_url:asset('/img/user/malex50.jpg')}}" alt="">
                                        </td>
                                        <td>{{$employee->emp_id}}</td>
                                        <td>{{$employee->title->name.' '.$employee->initials.' '.$employee->last_name}}</td>
                                        <td>{{$employee->gender->name}}</td>
                                        <td>{{$employee->designation->name}}</td>
                                        @if($canEditEmployee || $canDeleteEmployee)
                                            <td>
                                                @if($canEditEmployee)
                                                    <a href="{{url('/employee/'.$employee->id.'/edit')}}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                                                @endif
                                                @if($canDeleteEmployee)
                                                    <a type="button" class="btn btn-sm btn-danger btnDelete" id="{{$employee->id}}"><i class="fa fa-trash"></i></a>
                                                    <form id="{{$employee->id}}delete-form" action="{{ route('employee.destroy',$employee->id) }}" method="POST" style="display: none;">
                                                        {{ csrf_field() }}
                                                        {{ method_field('DELETE') }}
                                                    </form>
                                                @endif
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                            <tfoot >
                            <tr>
                                <th width="30px" ></th>
                                <th >id</th>
                                <th >Name</th>
                                <th >Gender</th>
                                <th >Designation</th>
                                @if($canEditEmployee || $canDeleteEmployee)
                                    <th style="min-width:80px;max-width: 80px"></th>
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
            $('#tblEmployee').dataTable({
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
                        messageTop: 'Stores Management System - Employee Report',
                        title:'Employee Report '+'{{\Carbon\Carbon::now()}}'
                    }, {
                        extend: 'pdfHtml5',
                        orientation: 'portrait',
                        pageSize: 'A4',
                        messageTop: 'Stores Management System - Employee Report',
                        title:'Employee Report '+'{{\Carbon\Carbon::now()}}'
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
                        if (counter++ == 0 || counter++ == 10){
                            return;
                        }
                        var column = this;
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

                    $('.btnDelete').on('click',function (e) {
                        var form = $('#'+$(this).attr('id')+'delete-form');
                        $.confirm({
                            title: 'Confirmation!',
                            content: "<span class='text-small'>Are you sure you want to delete this academic year ?",
                            buttons: {
                                formSubmit: {
                                    text: 'Confirm',
                                    btnClass: 'btn-red',
                                    action: function () {
                                        form.submit();
                                    }
                                },
                                cancel: function () {
                                    //close
                                },
                            }
                        });
                    });
                }
            });
        } );
    </script>

@endsection