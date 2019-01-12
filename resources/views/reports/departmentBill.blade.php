@extends('layouts.app')

@section('title','Department Bill')

@section('styles')
    <link rel="stylesheet" href="{{asset('plugins/datatables/dataTables.bootstrap4.css')}}">
    <link rel="stylesheet" href="{{asset('js/print/print.min.css')}}">
    <script src="{{asset('js/print/print.min.js')}}"></script>
@endsection


@section('header')
    <i class="fa fa-user"></i> Department Bill
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            @include('layouts.messages.success')

            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">{{$department->name}} Department Bill</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table border="1"  id="printDiv">
                                <thead >
                                <tr>
                                    <th colspan="7">Department - {{$department->name}}</th>
                                </tr>
                                <tr>
                                    <th colspan="7">Date Range - {{\Carbon\Carbon::parse($startDate)->toDateString()}} - {{\Carbon\Carbon::parse($endDate)->toDateString()}}</th>
                                </tr>
                                <tr>
                                    <th >Product Code</th>
                                    <th >Product Name</th>
                                    <th >Unit Price (Rs.)</th>
                                    <th >Tax (Rs.)</th>
                                    <th >UPrice+Tax (Rs.)</th>
                                    <th >Quantity</th>
                                    <th >Total (Rs.)</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $sum = 0;
                                foreach ($completedProducts as $completedProduct){
                                    foreach ($completedProduct->product_issues as $productIssue){
//                                    echo "$productIssue->issued_at > ".\Carbon\Carbon::parse($startDate)."<br>";
                                        if ($productIssue->issued_at>=\Carbon\Carbon::parse($startDate)&&$productIssue->issued_at<=\Carbon\Carbon::parse($endDate)){

                                            foreach ($productIssue->product_issue_items as $product_issue_item){
                                                $product = $product_issue_item->product_request_item->product;
                                                $price = $product_issue_item->price;
                                                $tax = $product_issue_item->tax;
                                                $unitPrice = $price+$tax;
                                                $quantity = $product_issue_item->quantity;
                                                $totalPrice = $unitPrice*$quantity;
                                                $sum+=$totalPrice;
                                                echo "<tr>
                                                <td>$product->code</td>
                                                <td>$product->name</td>
                                                <td>".number_format($price)."</td>
                                                <td>".number_format($tax)."</td>
                                                <td>".number_format($unitPrice)."</td>
                                                <td>$quantity</td>
                                                <td align='right'>".number_format($totalPrice)."</td>
                                              </tr>";
                                            }
                                        }
                                    }
                                }
                                echo "<tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td>Total (Rs.)</td>
                                                <td align='right'>".number_format($sum)."</td>
                                              </tr>";
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

                <div class="box-footer clearfix">
                    <button type="button" class="btn btn-primary" onclick="printJS('printDiv', 'html')">
                        <i class="fa fa-print"></i> Print
                    </button>
                </div>
                <!-- /.box-footer -->
            </div>
        </div>
    </div>
@endsection

@section('scripts')

@endsection