@extends('layouts.app')

@section('title','User')

@section('top-links')

@endsection

@section('styles')
    <link rel="stylesheet" href="{{asset('plugins/datatables/dataTables.bootstrap4.css')}}">
@endsection

@section('header')
    <i class="fa fa-user"></i> Users
@endsection

@section('page-link')
    <a href="{{url('/user')}}"> User</a>
@endsection
<?PHP
$canEditUser = Auth::user()->canEditUser();
?>
@section('content')
    <div class="row">

        <div class="col-md-12">

            <!-- general form elements -->
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Users List</h3>
                </div>
                <!-- /.card-header -->
                <div class="box-body">

                    <table class="table" id="tblUsers">
                        <thead class="thead-light">
                        <tr>
                            <th width="50px" scope="col"></th>
                            <th scope="col">Employee ID</th>
                            <th scope="col">User Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Role</th>
                            <th scope="col">Status</th>
                            @if($canEditUser)
                                <th scope="col" style="width: 20px"></th>
                            @endif
                        </tr>
                        </thead>
                        <tbody>
                        @if($users)
                            @foreach($users as $user)
                                <tr>
                                    <td >
                                        <img height="30px" src="{{$user->employee->img_url?asset($user->employee->img_url):asset('/img/user/malex50.jpg')}}" alt="">
                                        {{--<img height="30px" src="{{$user->employee?$user->employee->img_url:asset('/img/user/male.jpg')}}" alt="">--}}
                                    </td>
                                    <td>{{$user->employee?$user->employee->emp_id:''}}</td>
                                    <td>{{$user->user_name?$user->user_name:$user->user_name}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>{{$user->role?$user->role->name:''}}</td>
                                    <td>
                                        @if($user->is_active)
                                            @if($user->is_active=='1')
                                                {!! '<span class="badge bg-green">Active</span>' !!}
                                            @else
                                                {!! '<span class="badge bg-yellow">Not Active</span>' !!}
                                            @endif
                                        @endif
                                    </td>
                                    @if($canEditUser)
                                        <td style="width: 20px">
                                            <a href="{{url('/user/'.$user->id.'/edit')}}" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">

                </div>
            </div>
            <!-- /.card -->
        </div>

    </div>
@endsection

@section('scripts')
    <script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('plugins/datatables/dataTables.bootstrap4.js')}}"></script>
    <script>
        $(document).ready(function() {


            // // Setup - add a text input to each footer cell
            // $('#tblUsers tfoot th').each( function () {
            //     var title = $(this).text();
            //     $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
            // } );

            // DataTable
            var table = $('#tblUsers').DataTable();
            //
            // // Apply the search
            // table.columns().every( function () {
            //     var that = this;
            //
            //     $( 'input', this.footer() ).on( 'keyup change', function () {
            //         if ( that.search() !== this.value ) {
            //             that
            //                 .search( this.value )
            //                 .draw();
            //         }
            //     } );
            // } );
        } );
    </script>
@endsection