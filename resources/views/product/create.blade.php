@extends('layouts.app')

@section('title','New Product')

@section('styles')

@endsection

@section('header')
    <i class="fa fa-cart-plus"></i> Add new product
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            @include('layouts.messages.success')

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Product Data Form</h3>

                    <div class="box-tools pull-right">
                        <a href="{{URL::previous() }}" class="btn btn-primary btn-sm pull-right"> <i class="fa fa-angle-left"> </i> Back</a>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    {!! Form::open(['action' => 'ProductController@store','method'=>'POST','files'=>true]) !!}

                    <div class="row">
                        <div class="col-md-6">
                            <img height="100px" width="100px" src="{{asset('/img/productx50.bmp')}}" alt="" class="img-rounded img-thumbnail" id="imgUser">
                            <div class="form-group {{$errors->has('image')?'has-error':''}}">
                                <label for="exampleInputFile">Product Image</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" name="image" class="custom-file-input" id="imgUserInput">
                                    </div>
                                </div>
                                <span class="help-block">{{$errors->first('image')?$errors->first('image'):''}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group {{$errors->has('name')?'has-error':''}}">
                                <label for="name">Product Name</label>
                                {!! Form::text('name', null,['placeholder'=>'Product Name','class'=>'form-control form-control-sm']) !!}
                                <span class="help-block">{{$errors->first('name')?$errors->first('name'):''}}</span>
                            </div>
                            <div class="form-group {{$errors->has('code')?'has-error':''}}">
                                <label for="code">Product Code</label>
                                {!! Form::text('code', null,['placeholder'=>'CON-STA-001','class'=>'form-control form-control-sm']) !!}
                                <span class="help-block">{{$errors->first('code')?$errors->first('code'):''}}</span>
                            </div>
                            <div class="form-group {{$errors->has('product_type_id')?'has-error':''}}">
                                <label for="product_type_id">Product Type</label>
                                {!! Form::select('product_type_id', $types, null,['placeholder'=>'Select a product type','class'=>'form-control form-control-sm','id'=>'cmbProductType']) !!}
                                <span class="help-block">{{$errors->first('product_type_id')?$errors->first('product_type_id'):''}}</span>
                            </div>
                            <div class="form-group {{$errors->has('asset_code')?'has-error':''}}" id="txtAssetCode">
                                <label for="asset_code">Asset Code</label>
                                {!! Form::text('asset_code', null,['placeholder'=>'ASS/2018-03/001','class'=>'form-control form-control-sm']) !!}
                                <span class="help-block">{{$errors->first('asset_code')?$errors->first('asset_code'):''}}</span>
                            </div>
                            <div class="form-group {{$errors->has('barcode')?'has-error':''}}">
                                <label for="barcode">Bar Code</label>
                                {!! Form::text('barcode', null,['placeholder'=>'00111','class'=>'form-control form-control-sm']) !!}
                                <span class="help-block">{{$errors->first('barcode')?$errors->first('barcode'):''}}</span>
                            </div>
                            <div class="form-group {{$errors->has('description')?'has-error':''}}">
                                <label for="description">Description</label>
                                {!! Form::textarea('description', null,['placeholder'=>'Description','class'=>'form-control form-control-sm','rows'=>2]) !!}
                                <span class="help-block">{{$errors->first('description')?$errors->first('description'):''}}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group {{$errors->has('reorder_level')?'has-error':''}}">
                                <label for="reorder_level">Reorder Level</label>
                                {!! Form::text('reorder_level', null,['placeholder'=>'10','class'=>'form-control form-control-sm','id'=>'txtReorderLevel']) !!}
                                <span id="txtReorderLevelError" class="help-block">{{$errors->first('reorder_level')?$errors->first('reorder_level'):''}}</span>
                            </div>
                            <div class="form-group {{$errors->has('critical_reorder_level')?'has-error':''}}">
                                <label for="critical_reorder_level">Critical Reorder Level</label>
                                {!! Form::text('critical_reorder_level', null,['placeholder'=>'5','class'=>'form-control form-control-sm','id'=>'txtCriticalReorderLevel']) !!}
                                <span id="txtCriticalReorderLevelError" class="help-block">{{$errors->first('critical_reorder_level')?$errors->first('critical_reorder_level'):''}}</span>
                            </div>
                            <div class="form-group {{$errors->has('product_category_id')?'has-error':''}}">
                                <label for="id">Category</label>
                                {!! Form::select('product_category_id', $categories, null,['placeholder'=>'Select a category', 'id'=>'cmbCategories', 'class'=>'form-control form-control-sm']) !!}
                                <span class="help-block">{{$errors->first('product_category_id')?$errors->first('product_category_id'):''}}</span>
                            </div>
                            <div class="form-group {{$errors->has('product_sub_category_id')?'has-error':''}}">
                                <label for="id">Subcategory</label>
                                {!! Form::select('product_sub_category_id', $subCategories, null,['placeholder'=>'Select a subcategory','class'=>'form-control form-control-sm', 'id'=>'cmbSubCategory']) !!}
                                <span class="help-block">{{$errors->first('product_sub_category_id')?$errors->first('product_sub_category_id'):''}}</span>
                            </div>
                            <div class="form-group {{$errors->has('product_status_id')?'has-error':''}}">
                                <label for="product_status_id">Product Status</label>
                                {!! Form::select('product_status_id', $status, null,['placeholder'=>'Select a product status','class'=>'form-control form-control-sm']) !!}
                                <span class="help-block">{{$errors->first('product_status_id')?$errors->first('product_status_id'):''}}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer clearfix">
                    {!! Form::submit('Save',['class'=>'btn btn-primary']) !!}
                    {!! Form::Reset('Clear',['class'=>'btn btn-warning']) !!}

                    {!! Form::close() !!}
                </div>
                <!-- /.box-footer -->
            </div>

    </div>
@endsection

@section('scripts')
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#imgUser').attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
        $(function () {
            $('#imgUserInput').change(function () {
                readURL(this);
            })
        });

        $(function () {
            $('#cmbCategories').on('change',function (e) {
               var catId = $('#cmbCategories').find(":selected").val();
               if (catId !== '') {
                   var url = '{{url('')}}/product/category/'+catId+'/sub_categories';

                   $.ajax({
                       method:"GET",
                       url:url,
                       success:function (data) {
                           var options = '<option>Select a subcategory</option>';
                           $.each( data, function( key, value ) {
                               options+="<option value='"+value.id+"'>"+value.name+"</option>";
                           });
                           $('#cmbSubCategory').html(options);
                       },
                       error:function (data) {
                           $('#cmbSubCategory').html("<option>Error loading subcategories</option>");
                       }
                   })
               }

            });

            $('#cmbSubCategory').on('change',function (e) {
                var subCatId = $('#cmbSubCategory').find(":selected").val();
                if (subCatId !== '') {
                    var url = '{{url('')}}/product/sub_category/'+subCatId+'/category';

                    $.ajax({
                        method:"GET",
                        url:url,
                        success:function (data) {
                            console.log(data.id);
                            $("#cmbCategories").val(data.id);
                        },
                        error:function (data) {
                            $('#cmbCategories').html("<option>Error selecting category</option>");
                        }
                    })
                }else {
                    $("#cmbCategories").val("");
                }

            })
        });

        $(function () {
            $('#txtReorderLevel').on('keyup',function () {

                var reorderLevel = parseInt((this).value);
                console.log(reorderLevel);
                var criticalReorderLevel = parseInt($('#txtCriticalReorderLevel').val());
                console.log(criticalReorderLevel);

                if (criticalReorderLevel!==''&&reorderLevel!==''&&reorderLevel<=criticalReorderLevel) {
                    $('#txtReorderLevelError').html("<p class='text-danger'>Reorder Level must grater than Critical Reorder Level</p>")
                }else {
                    $('#txtReorderLevelError').html('');
                    $('#txtCriticalReorderLevelError').html('');
                }

            });

            $('#txtCriticalReorderLevel').on('keyup',function () {

                var criticalReorderLevel= parseInt((this).value);
                var reorderLevel = parseInt($('#txtReorderLevel').val());

                if (criticalReorderLevel!==''&&reorderLevel!==''&&reorderLevel<=criticalReorderLevel) {
                    $('#txtCriticalReorderLevelError').html("<p class='text-danger'>Critical Reorder Level must less than Reorder Level</p>")
                }else {
                    $('#txtCriticalReorderLevelError').html('');
                    $('#txtReorderLevelError').html('');
                }

            });

            $('#txtAssetCode').hide();
            $('#cmbProductType').on('change',function () {
               var selectedVal = $(this).find(":selected").val();
               console.log(selectedVal);
               if (selectedVal == 2){
                   $('#txtAssetCode').show(200);
               }else {
                   $('#txtAssetCode').hide(200);
               }
            });
        })
    </script>
@endsection