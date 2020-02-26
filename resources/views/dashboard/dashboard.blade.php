@extends('layout')
@section('content')

    <section class="content-header">
        <h1>
            Dashboard

        </h1>

        <ol class="breadcrumb">
            <li><a href="{{url('/')}}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="{{url('/')}}">dashboard</a></li>
        </ol>
    </section>

    <section class="content">

        <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-aqua"><i class="ion ion-stats-bars"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-number">{{$total_cases}}<small></small></span>
                        <span class="info-box-text">Total Cases</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-green"><i class="ion ion-thumbsup"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-number">{{$today_cases}}</span>
                        <span class="info-box-text">Today Cases</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->

            <!-- fix for small devices only -->
            <div class="clearfix visible-sm-block"></div>

            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-pur   ple"><i class="ion ion-bag"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-number">760</span>
                        <span class="info-box-text">Total Users</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-red"><i class="ion ion-person-stalker"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-number">2,000</span>
                        <span class="info-box-text">Join Members</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <div class="row">

            <div class="col-md-12">

                <!-- BAR CHART -->
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">Month Wise Cases Analytics</h3>

                    </div>
                    <div class="box-body">
                        <div class="chart">
                            <canvas id="barChart" style="height:230px"></canvas>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->

            </div>
            </div>

    </section>

@endsection


@section('jquery-script')
    <script src="{{asset('public/assets/vendor_components/jquery/dist/jquery.min.js')}}"></script>

    <script src="{{asset('public/assets/vendor_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>




@endsection
@section('chart-script')

    <script src="{{asset('public/assets/vendor_components/chart-js/chart.js')}}"></script>

    <script src="{{asset('public/js/pages/widget-charts.js')}}"></script>





@endsection
