@extends('layouts.app')

@section('title','Employee')

@section('styles')
    <link rel="stylesheet" href="{{asset('plugins/datatables/dataTables.bootstrap4.css')}}">
@endsection

@section('top-links')

@endsection

@section('header')
    <i class="fa fa-user"></i> Employee List
@endsection

@section('page-link')
    <a href="{{url('/user/')}}">User</a> /
    <a href="{{url('/user/create/select')}}">Create</a>
@endsection

@section('content')
    <div class="row">

        <div class="col-md-12">

        @include('layouts.messages.success')
        @include('layouts.messages.error')

            <!-- general form elements -->
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Employee List</h3>
                    <p>Select a employee to create new user account</p>
                </div>
                <!-- /.box-header -->
                <div class="box-body">

                    <table class="table" id="tblEmployee">
                        <thead class="thead-light">
                        <tr>
                            <th width="30px" scope="col"></th>
                            <th scope="col">id</th>
                            <th scope="col">Name</th>
                            <th scope="col">Gender</th>
                            <th scope="col">Designation</th>
                            <th scope="col" width="30px"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($employees)
                            @foreach($employees as $employee)
                                <tr>
                                    <td>
                                        <img height="30px" src="{{$employee->img_url?asset($employee->img_url):asset('/img/user.png')}}" alt="">
                                        {{--<img height="30px" src="{{asset('/img/user/male.jpg')}}" alt="">--}}
                                    </td>
                                    <td>{{$employee->emp_id}}</td>
                                    <td>{{$employee->title->name.' '.$employee->initials.' '.$employee->last_name}}</td>
                                    <td>{{$employee->gender->name}}</td>
                                    <td>{{$employee->designation->name}}</td>
                                    <td>
                                        <a href="{{url('/user/'.$employee->id.'/create/')}}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                        <tfoot>
                        <tr>
                            <th width="50px" scope="col"></th>
                            <th scope="col">id</th>
                            <th scope="col">Name</th>
                            <th scope="col">Gender</th>
                            <th scope="col">Designation</th>
                            <th scope="col" width="50px"></th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
                <!-- /.box-body -->

                <div class="box-footer">

                </div>
            </div>
            <!-- /.box -->
        </div>

    </div>
@endsection

@section('scripts')
    <script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('plugins/datatables/dataTables.bootstrap4.js')}}"></script>
    <script>
        $(document).ready(function() {
            $('#tblEmployee').DataTable({"pagingType": "full_numbers",
                "paging": true,
            });
        } );
    </script>
@endsection