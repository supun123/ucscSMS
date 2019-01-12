@extends('layouts.app')

@section('title','Role')

@section('styles')

@endsection

@section('top-links')

@endsection

@section('page-header','User Role Management')

@section('page-link')
    <a href="{{url('/user/roles')}}">Roles</a>
@endsection

@section('content')
    <div class="col col-sm-6 col-md-offset-3">

        @include('layouts.messages.success')
        @include('layouts.messages.error')

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Updating {{$module->name}} module's permissions assigned to {{$role->name}}</h3>
                <a href="{{url('/user/roles')}}" class="btn btn-primary pull-right">Back</a>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <div class="box-body">

                <div class="row">
                    <div class="col-lg-12">
                        {!! Form::open(['method' => 'patch','action'=>'RoleController@updatePermissionsByModule']) !!}

                        {{Form::hidden('role_id', $role->id)}}

                        {{Form::hidden('module_id', $module->id)}}

                        <div class="col-md-12">
                            <p class="lead">Select permissions for {{$role->name}}</p>

                            <div class="table-responsive">
                                <table class="table">
                                    <tbody id="tblPermissions">
                                    @foreach($module->permissions as $permission)
                                        <div class="hidden">{{$a = 0}}</div>
                                        @foreach($permissions as $per)
                                            <div class="hidden">{{$permission->name == $per->name ? $a=1:''}} </div>
                                        @endforeach
                                        <tr>
                                            <th>{{$permission->name}}</th>
                                            <td><input type='checkbox' name='permission_ids[]' {{$a?'checked':''}} value='{{$permission->id}}'></td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>



                        <div class="form-group col-md-12 ">
                            {{Form::submit('Update Privileges', ['class'=>'btn btn-success pull-right'])}}
                        </div>

                        {!! Form::close() !!}
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>

    <script>
        $(function () {
            $('#cmbModule').on('change',function () {
                var url = $( "#cmbModule").find("option:selected").attr('url');
                $.ajax({
                    method:'GET',
                    url:url,
                    success: function (data) {
                        console.log(data);
                        var html = '';
                        $(data).each(function (index,a) {
                            html+=  "<tr>\n" +
                                    "<th style=\"width:50%\">"+a.name+"</th>\n" +
                                    "<td>"+"<input type='checkbox' name='permission_ids[]' value='"+a.id+"'>"+"</td>\n" +
                                    "</tr>";
                        });
                        $('#tblPermissions').html(html);
                    },
                    error: function (data) {
                        console.log(data);
                    }
                })
            })
        })
    </script>
@endsection