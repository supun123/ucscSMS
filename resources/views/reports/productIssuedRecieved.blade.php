
@extends('layouts.app')

@section('title','Product Analise')

@section('styles')

@endsection

@section('content')

    <div class="row">
        <div class="col-md-12">
            <!-- BAR CHART -->
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Bar Chart</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="chart">
                        <canvas id="barChart" style="height:300px"></canvas>
                    </div>
                    <div class="col-md-6 col-md-offset-3">
                        <button class="btn bg-gray" >Requested Items</button>
                        <button class="btn bg-green" >Issued Items</button>
                        <button class="btn bg-light-blue" >Stock Items</button>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col (RIGHT) -->
    </div>
@endsection

@section('scripts')

    <script src="{{asset('/bower_components/chart.js/Chart.min.js')}}"></script>

    <script>
        $(function () {
            var url = '{{url("/products_received_issued")}}';

            $.ajax({
                method:'GET',
                url:url,
                success:function (data) {
                    /* ChartJS
        * -------
        * Here we will create a few charts using ChartJS
        */

                    //--------------
                    //- AREA CHART -
                    //--------------
                    labels = [];
                    rData = [];
                    issueDat = [];
                    inventory = [];
                    $.each(JSON.parse(data),function (key,value) {
                        labels.push(value.name);
                        rData.push(value.quantity);
                        issueDat.push(value.issued);
                        inventory.push(value.inventory);
                    });

                    var areaChartData = {
                        labels  : labels,
                        datasets: [
                            {
                                label               : 'Recived',
                                fillColor           : 'rgba(210, 214, 222, 1)',
                                strokeColor         : 'rgba(210, 214, 222, 1)',
                                pointColor          : 'rgba(210, 214, 222, 1)',
                                pointStrokeColor    : '#c1c7d1',
                                pointHighlightFill  : '#fff',
                                pointHighlightStroke: 'rgba(220,220,220,1)',
                                data                : rData
                            },
                            {
                                label               : 'Issued',
                                fillColor           : 'rgba(60,141,188,0.9)',
                                strokeColor         : 'rgba(60,141,188,0.8)',
                                pointColor          : '#3b8bba',
                                pointStrokeColor    : 'rgba(60,141,188,1)',
                                pointHighlightFill  : '#fff',
                                pointHighlightStroke: 'rgba(60,141,188,1)',
                                data                : issueDat
                            },
                            {
                                label               : 'Inventory',
                                fillColor           : 'rgba(60,141,188,0.9)',
                                strokeColor         : 'rgba(60,141,188,0.8)',
                                pointColor          : '#ba6c60',
                                pointStrokeColor    : 'rgba(60,141,188,1)',
                                pointHighlightFill  : '#fff',
                                pointHighlightStroke: 'rgba(60,141,188,1)',
                                data                : inventory
                            }
                        ]
                    }




                    //-------------
                    //- BAR CHART -
                    //-------------
                    var barChartCanvas                   = $('#barChart').get(0).getContext('2d')
                    var barChart                         = new Chart(barChartCanvas)
                    var barChartData                     = areaChartData
                    barChartData.datasets[1].fillColor   = '#00a65a'
                    barChartData.datasets[1].strokeColor = '#00a65a'
                    barChartData.datasets[1].pointColor  = '#00a65a'
                    var barChartOptions                  = {
                        //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
                        scaleBeginAtZero        : true,
                        //Boolean - Whether grid lines are shown across the chart
                        scaleShowGridLines      : true,
                        //String - Colour of the grid lines
                        scaleGridLineColor      : 'rgba(0,0,0,.05)',
                        //Number - Width of the grid lines
                        scaleGridLineWidth      : 1,
                        //Boolean - Whether to show horizontal lines (except X axis)
                        scaleShowHorizontalLines: true,
                        //Boolean - Whether to show vertical lines (except Y axis)
                        scaleShowVerticalLines  : true,
                        //Boolean - If there is a stroke on each bar
                        barShowStroke           : true,
                        //Number - Pixel width of the bar stroke
                        barStrokeWidth          : 2,
                        //Number - Spacing between each of the X value sets
                        barValueSpacing         : 5,
                        //Number - Spacing between data sets within X values
                        barDatasetSpacing       : 1,
                        //String - A legend template
                        legendTemplate          : '',
                        //Boolean - whether to make the chart responsive
                        responsive              : true,
                        maintainAspectRatio     : true
                    }

                    barChartOptions.datasetFill = false
                    barChart.Bar(barChartData, barChartOptions);


                }
            })
        })
    </script>

    <script>
        $(function () {

  })
</script>
@endsection




