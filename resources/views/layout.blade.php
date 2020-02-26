<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{asset('public/images/favicon.ico')}}">


    <title>Clearpath - System Dashboard</title>

    <!-- bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{asset('public/assets/vendor_components/bootstrap/dist/css/bootstrap.css')}}">

    <!-- font awesome -->
    <link rel="stylesheet" href="{{asset('public/assets/vendor_components/font-awesome/css/font-awesome.css')}}">

    <!-- ionicons -->
    <link rel="stylesheet" href="{{asset('public/assets/vendor_components/Ionicons/css/ionicons.css')}}">

    <!-- theme style -->
    <link rel="stylesheet" href="{{asset('public/css/master_style.css')}}">

    <!-- mpt_admin skins. choose a skin from the css/skins folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{asset('public/css/skins/_all-skins.css')}}">

    <!-- morris chart -->
    <link rel="stylesheet" href="{{asset('public/assets/vendor_components/morris.js/morris.css')}}">

    <!-- jvectormap -->
    <link rel="stylesheet" href="{{asset('public/assets/vendor_components/jvectormap/jquery-jvectormap.css')}}">

    <!-- date picker -->
    <link rel="stylesheet"
          href="{{asset('public/assets/vendor_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.css')}}">

    <!-- daterange picker -->
    <link rel="stylesheet"
          href="{{asset('public/assets/vendor_components/bootstrap-daterangepicker/daterangepicker.css')}}">

    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet"
          href="{{asset('public/assets/vendor_plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.css')}}">
    <link rel="stylesheet" href="{{asset('public/js/dropzone.css')}}">


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Datatable server-side script// -->
{{--<script src="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css"></script>--}}

<!-- google font -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">

    <style>
        /*#myUL {*/
        /*    position: absolute;*/
        /*    border: 1px solid #d4d4d4;*/
        /*    border-bottom: none;*/
        /*    border-top: none;*/
        /*    z-index: 99;*/
        /*    top: 100%;*/
        /*    background-color: white;*/
        /*    list-style-type: none;*/
        /*    width: 50%;*/
        /*    padding-left: 0px;*/
        /*}  */
        #myUL {
            position: absolute;
            border: 1px solid #d4d4d4;
            border-bottom: none;
            border-top: none;
            list-style-type: none;
            z-index: 100;
            background-color: white;
            margin-top: 5px;
            width: 89%;
            padding-left: 0px;

        }

        li.autocomplete {
            font-weight: 500;
        }

        #myUL li:hover:not(.header) {
            background-color: #eee;
            cursor: pointer;
            border-bottom: 1px solid #d4d4d4;
        }

        .column {
            float: left;
            width: 33.33%;
            padding: 5px;
        }

        #patient_details_view {
            z-index: 1080 !important;

        }

        input[type=file] {
            color: transparent;
        }

        .spacing {
            margin-right: 5px;
        }

        label.padding {
            padding-left: unset;
        }

        /*.input-group-btn{*/
        /*padding-top: 31px;*/
        /*}*/
        li.autocomplete {
            font-weight: 500;
            line-height: 30px;
            border-bottom: 1px solid #d4d4d4;
            padding-left: 5px;
        }

        li.autocomplete :hover {
            color: #389af0;
        }

        .flash-padd {
            padding-top: 10px;
        }
    </style>

    @section('style')
    @show

</head>

<body class="hold-transition skin-blue sidebar-mini {{\Illuminate\Support\Facades\Auth::check() ? '' : 'sidebar-collapse'}}">
<div class="wrapper">

@section('header')
    @include('top_header')
@show

@if(\Illuminate\Support\Facades\Auth::check())
    <!-- Left side column. contains the logo and sidebar -->
@section('sidebar')
    @include('sidebar')
@show
@endif


<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <div id="body">
        @yield('content')
        <!-- /.content -->
        </div>
    </div>
    <!-- /.content-wrapper -->

    {{--    Ajax Modals--}}

    <div class="modal fade bs-patientt-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
         aria-hidden="false" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myLargeModalLabel">Patient Case Revision List</h4>
                </div>
                <div class="modal-body">
                    <div id="showPatientListModal"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Close
                    </button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>


@section('footer')
    @include('footer')
@show

<!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Create the tabs -->
        <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
            <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
            <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-cog fa-spin"></i></a></li>
        </ul>
        <!-- Tab panes -->
    </aside>
    <!-- /.control-sidebar -->

    <!-- Add the sidebar's background. This div must be placed immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>

</div>

<script src="{{asset('public/assets/vendor_components/jquery/dist/jquery.min.js')}}"></script>

<!-- Bootstrap 3.3.7 -->
<script src="{{asset('public/assets/vendor_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<!-- jQuery 3 -->
<script src="{{asset('public/assets/vendor_components/jquery/dist/jquery.js')}}"></script>
<script src="{{asset('public/js/typeahead/typeahead.js')}}"></script>

@section('typeahead-script')
@show


<script>
    $(document).ready(function () {
        $("#typeahead").keyup(function () {
            var query = $(this).val();

            if (query != '') {

                $.ajax({
                    url: "{{route('get-sidebar-search-ajax-call')}}",
                    method: "POST",
                    data: {"_token": "{{ csrf_token() }}", query: query},
                    success: function (data) {
                        // console.log(data.html);
                        $('#searchResult').fadeIn();
                        $('#searchResult').html(data.html);

                    }
                });
            }

        });

        $(document).on('click', "li[name^='autocomplete']", function () {

            $('#textbox').val($(this).text());

            $('#searchResult').fadeOut();

            var case_number = $("#typeahead").val();

            if (case_number !== '') {

                $.ajax({
                    url: "{{route('get-case-number-data-ajax-call')}}",
                    method: "POST",
                    data: {"_token": "{{ csrf_token() }}", case_number: case_number},
                    success: function (data) {

                        $('#body').html(data.html);
                    }
                });
            }
        });
    });
</script>


<!-- jQuery UI 1.11.4 -->
<script src="{{asset('public/assets/vendor_components/jquery-ui/jquery-ui.js')}}"></script>

<!-- DataTables -->
<script src="{{asset('public/assets/vendor_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('public/assets/vendor_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
<!-- end -->


<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
{{--<script>--}}
{{--$.widget.bridge('uibutton', $.ui.button);--}}
{{--</script>--}}

<!-- Bootstrap 3.3.7 -->
{{--<script src="{{asset('public/assets/vendor_components/bootstrap/dist/js/bootstrap.js')}}"></script>--}}

<!-- Morris.js charts -->
<script src="{{asset('public/assets/vendor_components/raphael/raphael.js')}}"></script>
<script src="{{asset('public/assets/vendor_components/morris.js/morris.js')}}"></script>

<!-- Sparkline -->
<script src="{{asset('public/assets/vendor_components/jquery-sparkline/dist/jquery.sparkline.js')}}"></script>

<!-- jvectormap -->
<script src="{{asset('public/assets/vendor_plugins/jvectormap/jquery-jvectormap-1.2.2.min.js')}}"></script>
<script src="{{asset('public/assets/vendor_plugins/jvectormap/jquery-jvectormap-world-mill-en.js')}}"></script>

<!-- jQuery Knob Chart -->
<script src="{{asset('public/assets/vendor_components/jquery-knob/js/jquery.knob.js')}}"></script>

<!-- Slimscroll -->
<script src="{{asset('public/assets/vendor_components/jquery-slimscroll/jquery.slimscroll.js')}}"></script>

<!-- FastClick -->
<script src="{{asset('public/assets/vendor_components/fastclick/lib/fastclick.js')}}"></script>
<script src="{{asset('public/notify.min.js')}}"></script>
@section('chart-script')
@show
<!-- mpt_admin App -->

<script src="{{asset('public/js/template.js')}}"></script>
<script src="{{asset('public/js/pages/dashboard.js')}}"></script>
<script src="{{asset('public/js/demo.js')}}"></script>

{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>--}}

@section('datatables-script')
@show

@section('edit_user_permissions_script')
@show

@section('case-script')
@show

@section('case-list-scripts')
@show

<script>
    $(document).ready(function () {

        var searchTxt1 = '';

        $('#srchTxt_btn1').on('click', function (e) {

            searchTxt1 = $('#typeahead').val();
            e.preventDefault();

            getFilteredCases(searchTxt1);

            // alert(searchTxt1);

        });

        function getFilteredCases(searchTxt1) {

            $.ajax({

                url: "{{url('get-filtered-cases')}}",
                method: 'POST',
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                data: {searchTxt1: searchTxt1},

                success: function (data) {

                    console.log(data);
                    $('div.content-wrapper').html(data.html);
                }

            });
        }
    });
</script>

<script>
    $(document).ready(function () {
        $(document).on("click", "a.show-patient-modal", function () {
            // $(".show-patient-modal").click(function (event) {
            var id = $(this).attr('id');

            $.ajax({
                url: "{{route('show-patientList-modal-ajax-call')}}",
                method: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    id: id
                },
                success: function (data) {

                    $('#showPatientListModal').html(data.html);

                }
            });
            // });
        });
    });
</script>

</body>
</html>
