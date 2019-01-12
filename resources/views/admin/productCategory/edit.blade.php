@extends('layouts.app')

@section('title','Edit Product Category')

@section('styles')

@endsection

@section('header')
    <i class="fa fa-refresh"></i> Manage Product Categories
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6 col-md-offset-3">

            @include('layouts.messages.success')

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Edit Product Category</h3>
                    <div class="box-tools pull-right">
                        <a href="{{url('/productCategory')}}" class="btn btn-primary btn-sm pull-right"> <i class="fa fa-plus"> </i> New Product Category</a>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                   <div class="col-md-5">
                       {!! Form::model($productCategory,['action' => ['ProductCategoryController@update',$productCategory->id],'method'=>'PATCH']) !!}
                       <div class="form-group {{$errors->has('name')?'has-error':''}}">
                           <label for="name">Product Category Name</label>
                           {!! Form::text('name', null,['placeholder'=>'Product Category Name','class'=>'form-control form-control-sm']) !!}
                           <span class="help-block">{{$errors->first('name')?$errors->first('name'):''}}</span>
                       </div>
                   </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer clearfix">

                    {!! Form::submit('Update',['class'=>'btn btn-info btn-sm']) !!}
                    {!! Form::Reset('Clear',['class'=>'btn btn-warning btn-sm']) !!}

                    {!! Form::close() !!}
                </div>
                <!-- /.box-footer -->

                <div class="box-header with-border">
                    <h3 class="box-title">Current Product Categories</h3>
                </div>

                <div class="box-body">
                    <div class="col-md-12">
                        <table class="table" id="tblProductCategory">
                            <thead >
                            <tr>
                                <th>Name</th>
                                <th >Edit</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($productCategorys)
                                @foreach($productCategorys as $productCategory)
                                    <tr>
                                        <td>{{$productCategory->name}}</td>
                                        <td>
                                            <a href="{{url('/productCategory/'.$productCategory->id.'/edit')}}" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
@endsection

@section('scripts')


@endsection