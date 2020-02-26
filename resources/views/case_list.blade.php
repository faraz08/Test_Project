@extends('layout')
@section('style')
    <style>
        a.btn.btn-info.pull-right {
            margin-top: -5px;
        }

        a.case_delete {
            cursor: pointer;
        }
    </style>
@endsection
@section('content')
    <section class="content-header">
        <h1>
            Cases List
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{url('/')}}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="{{url('case-list')}}">case</a></li>
            <li class="active">cases list</li>
        </ol>
    </section>
    <section class="content">


        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Cases List</h3>
                <div class="box-tools pull-right">
                    <a href="{{route('create-case')}}" type="submit" class="btn btn-info pull-right">Create New Case</a>
                </div>
            </div>

            <!-- /.box-header -->
            <div class="box-body">
                <table id="myTable" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Case #</th>
                        <th>Patient name</th>
                        <th>Doctor name</th>
                        <th>Case Register</th>
                        <th>Portal</th>
                        <th>Registered By</th>

                        <th>Action</th>

                    </tr>
                    </thead>
                    <tbody>

                    @foreach($cases as $case)
                        <tr>
                            <td class="case_number" id="case_number">{{$case->case_number}}</td>
                            <td class="patient_name">{{$case->patient_name}}</td>
                            <td class="doctor_name">{{$case->doctor_name}}</td>
                            <td class="">{{$case->created_at->format('Y-m-d')}}</td>
                            <td class="">{{$case->portal->name}}</td>
                            <td class="">{{$case->user->name}}</td>
                            <td class="">

                                <a class="case_delete" id="{{$case->id}}"> <i class="fa fa-trash-o"
                                                                              aria-hidden="true"></i></a>
                                |
                                <a href="" id="{{$case->id}}" data-toggle="modal" data-target=".bs-patient-modal-lg"
                                   class="show-patient-modal" data-backdrop="static" data-keyboard="false"><i
                                        class="fa fa-fw fa-list" aria-hidden="true"></i></a>
                                |
                                <a href="" id="{{$case->id}}" data-toggle="modal" data-target=".bs-case-modal-lg"
                                   class="show-case-modal" data-backdrop="static" data-keyboard="false"><i
                                        class="fa fa-pencil-square-o" aria-hidden="true"></i></a>

                            </td>

                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
        </div>

        <!-- /. edit modal -->
        <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
             aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="myLargeModalLabel">Edit Patient</h4>
                    </div>
                    <div class="modal-body">
                        <div id="patientEditModal"></div>
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
        <!-- /. show modal -->
        <div class="modal fade bs-show-modal-lg" id="patient_details_view" tabindex="-1" role="dialog"
             aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="myLargeModalLabel">Patien Details View</h4>
                    </div>
                    <div class="modal-body">
                        <div id="showPatientModal"></div>
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
        <!-- /. show patient list modal -->
        <div class="modal fade bs-patient-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
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

        <div class="modal fade bs-case-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
             aria-hidden="false" style="display: none;">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="myLargeModalLabel">Edit Case</h4>
                    </div>
                    <form method="post" id="edit-case-form" action="{{route('show-edit-case-modal-ajax-call')}}">
                        @csrf
                        <div class="box-body">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Case number</label>
                                    <input type="text" name="case_number" class="form-control" id="case_numberr"
                                           value="">

                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Patient number</label>
                                    <input type="text" name="patient_name" class="form-control" id="patient_name"
                                           value="">

                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Doctor name</label>
                                    <input type="text" name="doctor_name" class="form-control" id="doctor_name"
                                           value="">
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger waves-effect text-right" data-dismiss="modal">
                            Close
                        </button>
                        <button type="submit" form="edit-case-form"
                                class="btn btn-success waves-effect submit-edit-case-modal">Save
                        </button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

    </section>
@endsection
@section('case-list-scripts')
    <script src="{{asset('public/assets/vendor_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script
        src="{{asset('public/assets/vendor_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
    <script
        src="{{asset('public/assets/vendor_plugins/DataTables-1.10.15/media/js/jquery.dataTables.min.js')}}"></script>
    <script>
        $(function () {
            "use strict";

            $('#myTable').DataTable({
                'paging': true,
                'lengthChange': true,
                'searching': true,
                'ordering': true,
                'info': true,
                'autoWidth': false
            });

        }); // End of use strict
    </script>
    <script>
        $(document).ready(function (e) {
            $(".model_img").click(function (event) {
                var id = $(this).attr('id');

                $.ajax({
                    url: "{{route('get-patient-revision-modal-ajax-call')}}",
                    method: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        id: id
                    },
                    success: function (data) {
                        // console.log(data.html);
                        // $('#caseNumberList').fadeIn();
                        $('#patientEditModal').html(data.html);

                    }
                });
            });


            $(".case_delete").click(function (event) {

                var result = confirm("Are you sure you want to delete?");

                if (result) {

                    var id = $(this).attr('id');
                    var el = this;

                    $.ajax({
                        url: "{{route('del-case-ajax-call')}}",
                        method: "POST",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            id: id
                        },
                        success: function (response) {

                            if (response == 1) {
                                // Remove row from HTML Table
                                $(el).closest('tr').fadeOut(800, function () {
                                    $(this).remove();
                                });
                                $.notify("Case Deleted", "success");
                            } else {
                                $.notify(" There might be a problem case not deleted", "error");
                            }
                        }
                    });
                }
            });

            $(".show-patient-modal").click(function (event) {
                var id = $(this).attr('id');
//                alert(id);

                event.preventDefault();
                $.ajax({
                    url: "{{route('show-patientList-modal-ajax-call')}}",
                    method: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        id: id
                    },
                    success: function (data) {

//                        console.log(data);
                        $('#showPatientListModal').html(data.html);

                    }
                });
            });

            $(".show-case-modal").click(function (event) {

                var $row = $(this).closest("tr");
                var $case_number = $row.find(".case_number").text();

                var $patient_name = $row.find(".patient_name").text();
                var $doctor_name = $row.find(".doctor_name").text();

                // console.log($case_number)
                document.getElementById("case_numberr").value = $case_number;
                document.getElementById("patient_name").value = $patient_name;
                document.getElementById("doctor_name").value = $doctor_name;

            });

            $(".submit-edit-case-modal").click(function (event) {

                var updated_case_number = document.getElementById("case_number").value;
                var updated_patient_name = document.getElementById("patient_name").value;
                var updated_doctor_name = document.getElementById("doctor_name").value;

                console.log(updated_case_number);

//                return false;

                event.preventDefault();

                $.ajax({
                    url: "{{route('show-edit-case-modal-ajax-call')}}",
                    method: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        updated_case_number: updated_case_number,
                        updated_patient_name: updated_patient_name,
                        updated_doctor_name: updated_doctor_name,
                    },
                    success: function (data) {
                        $.notify("case edit successfully", "success");

                    },
                    error: function (data) {
                        $.notify(" There might be a problem record not deleted", "error");

                    }
                });

            });

        });

        $(document).on("click", 'a.show-modal', function (event) {
            var id = $(this).attr('id');

            $.ajax({
                url: "{{route('show-patient-modal-ajax-call')}}",
                method: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    id: id
                },
                success: function (data) {
                    // console.log(data.html);
                    // $('#caseNumberList').fadeIn();
                    $('#showPatientModal').html(data.html);

                }
            });
        });

        $(document).on("click", '.delete', function (event) {

            var result = confirm("Are you sure you want to delete1?");
            var revision = 'revision';

            if (result) {

                var id = $(this).attr('id');
                var el = this;

                event.preventDefault();

                $.ajax({
                    url: "{{route('del-case-ajax-call')}}",
                    method: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        id: id,
                        revision: revision
                    },
                    success: function (response) {

                        if (response == 1) {
                            // Remove row from HTML Table
                            $(el).closest('tr').fadeOut(800, function () {
                                $(this).remove();
                            });
                            $.notify("Record Deleted", "success");
                        } else {
                            $.notify(" There might be a problem record not deleted", "error");
                        }
                    }
                });
            }
        });


    </script>
@endsection
