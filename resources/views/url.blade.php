@extends('layout')

@section('content')

    <section class="content-header">
        <h1>
            {{$cases['cases']->patient_name}}'s Report

        </h1>

    </section>


    <!-- Main content -->
    <section class="invoice printableArea">
        <!-- title row -->
        <div class="row">
            <div class="col-xs-12">
                <h2 class="page-header">
                    Case Revision Registered
                    <small class="pull-right">Date: {{$cases->created_at}}</small>

                </h2>
            </div>
            <!-- /.col -->
        </div>
        <!-- info row -->
        <div class="row invoice-info">
            <div class="col-sm-6 invoice-col">
                <p class=""> Portal : {{$cases['cases']->portal->name}}</p>
                <p class=""> Upper Aligner : {{$cases->upper_aligner}}</p>
                <p class=""> Lower Alligner : {{$cases->lower_aligner}}</p>

            </div>
            <!-- /.col -->

            <div class="col-sm-12 invoice-col">
                <div class="invoice-details clearfix">
                    <div class="col-sm-3"><b>Doctor : </b>{{$cases->cases->doctor_name}}</div>
                    <div class="col-sm-3"><b>Operator :</b> {{$cases->operator->name}}</div>
                    <div class="col-sm-2"><b>Revision #:</b> {{$cases->revisions}}</div>
                    <div class="col-sm-2"><b>Case # :</b> {{$cases['cases']->case_number}}</div>

                </div>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <!-- Table row -->
        <div class="row">
            <div class="col-xs-12 table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Files Before</th>
                        <th>Files After</th>
                        <th>IPR Form</th>

                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>1</td>
                        @foreach($afterFiles as $key => $value)
                            <td>

                                <a href="{{url($pathToStoreFileAfter.'/'.str_replace('"', "", $value))}}"><p
                                        class="text-black">{{str_replace('"', "", $value)}}</p></a>
                            </td>
                        @endforeach
                        @foreach($beforeFiles as $key => $value)
                            <td>


                                <a href="{{url($pathToStoreFileBefore.'/'.str_replace('"', "", $value))}}"><p
                                        class="text-aqua">{{str_replace('"', "", $value)}}</p></a>


                            </td>
                        @endforeach
                        <td class="">
                            <a href="{{url('public/cases/'.$cases['cases']->case_number.'/ipr_form/'.$cases->revisions.'/'.$cases->ipr_form)}}"
                               target="_blank"><p class="text-aqua">IPR From</p></a>
                        </td>

                    </tr>

                    </tbody>
                </table>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <!-- this row will not appear when printing -->
        {{--        <div class="row no-print">--}}
        {{--            <div class="col-xs-12">--}}
        {{--                <button id="print" class="btn btn-warning" type="button"> <span><i class="fa fa-print"></i> Print</span> </button>--}}
        {{--                <button type="button" class="btn btn-success pull-right"><i class="fa fa-credit-card"></i> Submit Payment--}}
        {{--                </button>--}}
        {{--                <button type="button" class="btn btn-danger pull-right" style="margin-right: 5px;">--}}
        {{--                    <i class="fa fa-download"></i> Generate PDF--}}
        {{--                </button>--}}
        {{--            </div>--}}
        {{--        </div>--}}
    </section>
    <!-- /.content -->
    <div class="clearfix"></div>





@endsection
