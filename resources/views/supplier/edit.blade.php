@extends('layouts.app')

@section('title','Edit Supplier')

@section('styles')

@endsection

@section('header')
    <i class="fa fa-refresh"></i> Edit Supplier
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            @include('layouts.messages.success')

            <div class="box box-primary direct-chat direct-chat-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Supplier Form</h3>

                    <div class="box-tools pull-right">
                        <a href="{{URL::previous() }}" class="btn btn-primary btn-sm pull-right"> <i class="fa fa-angle-left"> </i> Back</a>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="col-md-12">
                        {!! Form::model($supplier,['method' => 'PATCH','action'=>['SupplierController@update',$supplier->id]]) !!}


                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group {{$errors->has('doc_no')?'has-error':''}}">
                                    <label for="doc_no">Document Number</label>
                                    {{Form::text('doc_no', null, ['class'=>'form-control','placeholder'=>'Document Number'])}}
                                    <span class="help-block">{{$errors->first('doc_no')?$errors->first('doc_no'):''}}</span>
                                </div>

                                <div class="form-group {{$errors->has('reciept_no')?'has-error':''}}">
                                    <label for="reciept_no">Receipt Number</label>
                                    {{Form::text('reciept_no', null, ['class'=>'form-control','placeholder'=>'Receipt Number'])}}
                                    <span class="help-block">{{$errors->first('reciept_no')?$errors->first('reciept_no'):''}}</span>
                                </div>

                                <div class="form-group {{$errors->has('company_name')?'has-error':''}}">
                                    <label for="company_name">Company Name</label>
                                    {{Form::text('company_name', null, ['class'=>'form-control','placeholder'=>'Company Name'])}}
                                    <span class="help-block">{{$errors->first('company_name')?$errors->first('company_name'):''}}</span>
                                </div>


                                <div class="form-group {{$errors->has('phone_1')?'has-error':''}}">
                                    <label for="phone_1">Phone Number (Optional)</label>
                                    {{Form::text('phone_1', null, ['class'=>'form-control','placeholder'=>'0114533334'])}}
                                    <span class="help-block">{{$errors->first('phone_1')?$errors->first('phone_1'):''}}</span>
                                </div>

                                <div class="form-group {{$errors->has('phone_2')?'has-error':''}}">
                                    <label for="phone_2">Phone Number </label>
                                    {{Form::text('phone_2', null, ['class'=>'form-control','placeholder'=>'0114533334'])}}
                                    <span class="help-block">{{$errors->first('phone_2')?$errors->first('phone_2'):''}}</span>
                                </div>

                                <div class="form-group {{$errors->has('fax_1')?'has-error':''}}">
                                    <label for="fax_1">Fax Number</label>
                                    {{Form::text('fax_1', null, ['class'=>'form-control','placeholder'=>'0114533334'])}}
                                    <span class="help-block">{{$errors->first('fax_1')?$errors->first('fax_1'):''}}</span>
                                </div>

                                <div class="form-group {{$errors->has('fax_2')?'has-error':''}}">
                                    <label for="fax_2">Fax Number (Optional)</label>
                                    {{Form::text('fax_2', null, ['class'=>'form-control','placeholder'=>'0114533334'])}}
                                    <span class="help-block">{{$errors->first('fax_2')?$errors->first('fax_2'):''}}</span>
                                </div>

                                <div class="form-group {{$errors->has('email')?'has-error':''}}">
                                    <label for="email">Email</label>
                                    {{Form::text('email', null, ['class'=>'form-control','placeholder'=>'Document Number'])}}
                                    <span class="help-block">{{$errors->first('email')?$errors->first('email'):''}}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group {{$errors->has('business_reg_no')?'has-error':''}}">
                                    <label for="business_reg_no">Business Registration Number</label>
                                    {{Form::text('business_reg_no', null, ['class'=>'form-control','placeholder'=>'Business Registration Number'])}}
                                    <span class="help-blocnauk">{{$errors->first('business_reg_no')?$errors->first('business_reg_no'):''}}</span>
                                </div>

                                <div class="form-group {{$errors->has('business_reg_date')?'has-error':''}}">
                                    <label for="business_reg_date">Business Registration Date</label>
                                    {{Form::date('business_reg_date', $supplier->business_reg_date, ['class'=>'form-control','placeholder'=>'Business Registration Date'])}}
                                    <span class="help-block">{{$errors->first('business_reg_date')?$errors->first('business_reg_date'):''}}</span>
                                </div>

                                <div class="form-group {{$errors->has('vat_no')?'has-error':''}}">
                                    <label for="vat_no">Vat Number</label>
                                    {{Form::text('vat_no', null, ['class'=>'form-control','placeholder'=>'Vat Number'])}}
                                    <span class="help-block">{{$errors->first('vat_no')?$errors->first('vat_no'):''}}</span>
                                </div>

                                <div class="form-group {{$errors->has('nature_of_business_id')?'has-error':''}}">
                                    <label for="id">Nature of the Business</label>
                                    {!! Form::select('nature_of_business_id', $nature_of_business, null,['placeholder'=>'Select a Nature of the Business', 'id'=>'cmbNature', 'class'=>'form-control form-control-sm']) !!}
                                    <span class="help-block">{{$errors->first('nature_of_business_id')?$errors->first('nature_of_business_id'):''}}</span>
                                </div>

                                <div class="form-group {{$errors->has('contact_person')?'has-error':''}}">
                                    <label for="contact_person">Contact Person</label>
                                    {{Form::text('contact_person', null, ['class'=>'form-control','placeholder'=>'Contact Person'])}}
                                    <span class="help-block">{{$errors->first('contact_person')?$errors->first('contact_person'):''}}</span>
                                </div>

                                <div class="form-group {{$errors->has('remark')?'has-error':''}}">
                                    <label for="remark">Remarks</label>
                                    {{Form::textarea('remark', null, ['class'=>'form-control','placeholder'=>'Remarks','rows'=>4])}}
                                    <span class="help-block">{{$errors->first('remark')?$errors->first('remark'):''}}</span>
                                </div>
                                
                                <div class="form-group {{$errors->has('is_active')?'has-error':''}}">
                                    <label for="id">Supplier Status</label>
                                    {!! Form::select('is_active', [0=>'Disabled',1=>'Active'], null,['placeholder'=>'Select a Supplier status', 'class'=>'form-control form-control-sm']) !!}
                                    <span class="help-block">{{$errors->first('is_active')?$errors->first('is_active'):''}}</span>
                                </div>
                            </div>
                        </div>
                        

                        
                        <div class="form-group">
                            {{Form::submit('Save', ['class'=>'btn btn-success'])}}
                        </div>

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
            <!--/.direct-chat -->
        </div>
    </div>
@endsection

@section('scripts')

@endsection