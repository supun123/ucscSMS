@extends('layouts.app')

@section('title','Employee')

@section('styles')

@endsection

@section('header')
    <i class="fa fa-refresh"></i> Manage Product Subcategorys
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6 col-md-offset-3">

            @include('layouts.messages.success')

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Edit Product Subcategory</h3>
                    <div class="box-tools pull-right">
                        <a href="{{url('/productSubCategory')}}" class="btn btn-primary btn-sm pull-right"> <i class="fa fa-plus"> </i> New Product Subcategory</a>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                   <div class="col-md-5">
                       {!! Form::model($productSubCategory,['action' => ['ProductSubCategoryController@update',$productSubCategory->id],'method'=>'PATCH']) !!}
                       <div class="form-group {{$errors->has('product_category_id')?'has-error':''}}">
                           <label for="product_category_id">Product Subcategory</label>
                           {!! Form::select('product_category_id', $productCategorys, null,['placeholder'=>'Select a designation','class'=>'form-control form-control-sm']) !!}
                           <span class="help-block">{{$errors->first('product_category_id')?$errors->first('product_category_id'):''}}</span>
                       </div>
                       <div class="form-group {{$errors->has('name')?'has-error':''}}">
                           <label for="name">Product Subcategory Name</label>
                           {!! Form::text('name', null,['placeholder'=>'Product Subcategory','class'=>'form-control form-control-sm']) !!}
                           <span class="help-block">{{$errors->first('name')?$errors->first('name'):''}}</span>
                       </div>
                   </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer clearfix">

                    {!! Form::submit('Update',['class'=>'btn btn-primary btn-sm']) !!}
                    {!! Form::Reset('Clear',['class'=>'btn btn-warning btn-sm']) !!}

                    {!! Form::close() !!}
                </div>
                <!-- /.box-footer -->

                <div class="box-header with-border">
                    <h3 class="box-title">Current Product Sub Categorys</h3>
                </div>

                <div class="box-body">
                    <div class="col-md-12">
                        <table class="table" id="tblProductSubCategory">
                            <thead >
                            <tr>
                                <th>Name</th>
                                <th >Edit</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($productSubCategorys)
                                @foreach($productSubCategorys as $productSubCategory)
                                    <tr>
                                        <td>{{$productSubCategory->name}}</td>
                                        <td>
                                            <a href="{{url('/productSubCategory/'.$productSubCategory->id.'/edit')}}" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a>
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