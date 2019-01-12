@extends('layouts.app')

@section('title','Employee')

@section('styles')

@endsection


@section('header')
    <i class="fa fa-user"></i> Create Supplier
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            @include('layouts.messages.success')

            <div class="box box-primary direct-chat direct-chat-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Supplier Products</h3>

                    <div class="box-tools pull-right">
                        <a href="{{URL::previous() }}" class="btn btn-primary btn-sm pull-right"> <i class="fa fa-angle-left"> </i> Back</a>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="col-md-12">
                        <div class="col-sm-12 col-md-6 invoice-col">
                            <address>
                                <strong>Details</strong><br>
                                Company Name : {{$supplier->company_name}} <br>
                                Business Registration Number : {{$supplier->business_reg_no}}<br>
                                Document Number : {{$supplier->doc_no}} <br>
                                Receipt Number : {{$supplier->reciept_no}}
                            </address>
                        </div>
                        <div class="col-sm-12 col-md-6 invoice-col">
                            <address>
                                <strong>Contact</strong><br>
                                Phone: {{$supplier->phone_1}} / {{$supplier->phone_2}}<br>
                                Fax: {{$supplier->fax_1}} / {{$supplier->fax_2}}<br>
                                Email: {{$supplier->email}}<br>
                            </address>
                        </div>
                    </div>
                </div>
            </div>
            <!--/.direct-chat -->
        </div>
    </div>
@endsection

@section('scripts')

@endsection