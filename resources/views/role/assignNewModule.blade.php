@extends('layouts.app')

@section('title','Role')

@section('styles')

@endsection

@section('top-links')

@endsection

@section('header')
    User Role Management
@endsection

@section('page-link')
    <a href="{{url('/user/roles')}}">Roles</a>
@endsection

@section('content')

    <div class="row justify-content-center">

        <div class="col-md-6 col-md-offset-3">
        @include('layouts.messages.error')
        @include('layouts.messages.success')
            <!-- general form elements -->
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Assigning new user module to {{$role->name}}</h3>
                    <a href="{{url('/user/roles')}}" class="btn btn-sm btn-primary pull-right">Back</a>
                </div>
                <!-- /.box-header -->
                <div class="box-body">

                    <div class="row">
                        <div class="col-md-12">
                            {!! Form::open(['method' => 'post','action'=>'RoleController@storeNewModule']) !!}

                            {{Form::hidden('role_id', $role->id)}}

                            <div class="form-group col-md-6">
                                <label for="module_id">Module</label>
                                <select class="form-control form-control-sm" required="" name="module_id" id="cmbModule">
                                    <option selected="selected" value="" url="{{url('/user/role/module/0/permissions')}}">Select a Module</option>
                                    @if($modules)
                                        @foreach($modules as $module)
                                            <option value="{{$module->id}}" url="{{url('/user/role/module/'.$module->id.'/permissions')}}" >{{$module->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <div class="col-md-12">
                                <p class="lead">Select permissions for {{$role->name}}</p>

                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <tbody id="tblPermissions">
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="form-group col-md-12 ">
                                {{Form::submit('Add Module', ['class'=>'btn btn-sm btn-success pull-right'])}}
                            </div>

                            {!! Form::close() !!}
                        </div>
                    </div>
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
                        var html = '';
                        $(data).each(function (index,a) {
                            html+=  "<tr>\n" +
                                    "<th style=\"width:50%\">"+a.name+"</th>\n" +
                                    "<td>"+"<input type='checkbox' name='permission_ids[]' class='form-control-sm' value='"+a.id+"'>"+"</td>\n" +
                                    "</tr>";
                        });
                        $('#tblPermissions').html(html);
                    },
                    error: function (data) {
                        $('#tblPermissions').html(data.responseText);
                    }
                })
            })
        })
    </script>
@endsection