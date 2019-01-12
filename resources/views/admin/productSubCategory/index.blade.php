@extends('layouts.app')

@section('title','ProductCategory')

@section('styles')

@endsection

@section('header')
    <i class="fa fa-user"></i> Manage Product Categories
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6 col-md-offset-3">

            @include('layouts.messages.success')

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">New Product Category</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                   <div class="col-md-5">
                       {!! Form::open(['action' => 'ProductSubCategoryController@store','method'=>'POST']) !!}
                       <div class="form-group {{$errors->has('product_category_id')?'has-error':''}}">
                           <label for="product_category_id">Product Category</label>
                           {!! Form::select('product_category_id', $productCategorys, null,['placeholder'=>'Select a Product Category','class'=>'form-control form-control-sm']) !!}
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

                    {!! Form::submit('Save',['class'=>'btn btn-primary btn-sm']) !!}
                    {!! Form::Reset('Clear',['class'=>'btn btn-warning btn-sm']) !!}

                    {!! Form::close() !!}
                </div>
                <!-- /.box-footer -->

                <div class="box-header with-border">
                    <h3 class="box-title">Current ProductCategorys</h3>
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