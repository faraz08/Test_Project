@extends('layout')
@section('style')
    <style>
        form input.files {
            position: absolute;
            margin: 0;
            padding: 0;
            width: 100%;
            opacity: 0;
        }

        .border {
            border: 2px dashed #d2d6de;
            /*height: 40px;*/
        }

        form .message {
            width: 100%;
            height: 100%;
            text-align: center;
            line-height: 35px;
            overflow: hidden;
            color: #d2d6de;
        }

        label.col-sm-10 {
            padding-left: initial;
        }

        .file-drop-area {
            position: relative;
            display: inline-block;
            /*display: flex;*/
            /*width: 450px;*/
            width: 100%;
            max-width: 100%;
            transition: 0.2s;
        }

        .file-drop-area.border.is-active {
            border: 2px dashed black;
        }

        .file_after-drop-area {
            position: relative;
            display: inline-block;
            width: 450px;
            max-width: 100%;
            transition: 0.2s;
        }

        .file_after-drop-area.border.is-active {
            border: 2px dashed black;
        }

        .ipr_form-drop-area.border.is-active {
            border: 2px dashed black;
        }

        img#profile-img-tag {
            max-width: fit-content;
            padding-top: 10px;
        }

        label.col-sm-10 {
            font-weight: normal !important;
        }

        .dz-preview.dz-file-preview.dz-processing.dz-error.dz-complete {
            width: 38% !important;
        }

        /*    dropzone*/
        .dropzone .dz-preview {
            display: inline-block;
            width: 39%;
        }

        .dz-default.dz-message span {
            color: #d2d6de
        }


    </style>
@endsection
@section('content')


    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Create Case
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{url('/')}}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="{{url('case-list')}}">case</a></li>
            <li class="active">create case</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Basic Forms -->
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Create Case</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="flash-message" id="flash-message"></div>
            <!-- /.box-header -->
            <form method="post" enctype="multipart/form-data" id="case-form" action="{{route('case-submit')}}">
                @csrf
                <div class="box-body form-element">
                    <div class="row">

                        <div class="col-md-12">
                            <div class="form-group clearfix">
                                <div class="col-sm-12">
                                    <label for="example-text-input" class="col-sm-10">Portal ID</label>
                                    <label class="control-label" for="inputError" style="color: red"><i
                                            id="portal_error"></i></label>
                                    <input class="form-control" type="text" name="portal" id="portal" required>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group clearfix">
                                <div class="col-sm-12">
                                    <label for="example-text-input" class="col-sm-10">Case ID</label>
                                    <div id="">
                                        <label class="control-label" for="inputError" style="color: red"><i
                                                id="case_number_error"></i></label>
                                        <input class="form-control typeahead" type="text" name="case_number"
                                               value="{{old('case_number')}}" id="case_number" autocomplete="off"
                                               id="(@error('case_number') inputError @enderror" max="10">
                                        @error('case_number')
                                        <span class="help-block">{{$errors->first('case_number')}}</span>
                                        @enderror
                                    </div>
                                    <div id="caseNumberList"></div>
                                </div>
                            </div>

                            <div class="form-group clearfix">

                                <div class="col-sm-12">
                                    <label for="example-text-input" class="col-sm-10">Doctor</label>
                                    <label class="control-label" for="inputError" style="color: red"><i
                                            id="doctor_name_error"></i></label>
                                    <input class="form-control" type="text" name="doctor_name" id="doctor_name" required
                                           max="50">
                                </div>

                            </div>
                            <div class="form-group clearfix">

                                <div class="col-sm-12">
                                    <label for="example-text-input" class="col-sm-10">Upper Aligner</label>
                                    <label class="control-label" for="inputError" style="color: red"><i
                                            id="upper_aligner_error"></i></label>
                                    <input class="form-control" type="number" name="upper_aligner" id="upper_aligner"
                                           required>

                                </div>

                            </div>
                            <div class="form-group clearfix">

                                <div class="col-sm-12">
                                    <label class="col-sm-10">Operator</label>
                                    <label class="control-label" for="inputError" style="color: red"><i
                                            id="operator_name_error"></i></label>
                                    <select class="form-control select2" style="width: 100%;" name="operator_name"
                                            id="operator_id" required>
                                        @foreach($operators as $operator)
                                            <option value="{{$operator->id}}">{{$operator->name}}</option>
                                        @endforeach

                                    </select>
                                </div>

                            </div>

                        </div>

                        <div class="col-md-6">
                            <div class="form-group clearfix">

                                <div class="col-sm-12">
                                    <label for="example-text-input" class="col-sm-10">Portal</label>
                                    <label class="control-label" for="inputError" style="color: red"><i
                                            id="portal_id_error"></i></label>
                                    <select class="form-control col-sm-10" name="portal_id" id="portal" required>
                                        @foreach($portal as $obj)
                                            <option value="{{$obj->id}}">{{$obj->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                            <div class="form-group clearfix">

                                <div class="col-sm-12">
                                    <label for="example-text-input" class="col-sm-10">Patient</label>
                                    <label class="control-label" for="inputError" style="color: red"><i
                                            id="patient_name_error"></i></label>
                                    <input class="form-control" type="text" name="patient_name" id="patient_name"
                                           required max="50">
                                </div>

                            </div>
                            <div class="form-group clearfix">

                                <div class="col-sm-12">
                                    <label for="example-text-input" class="col-sm-10">Lower Aligner</label>
                                    <label class="control-label" for="inputError" style="color: red"><i
                                            id="lower_aligner_error"></i></label>
                                    <input class="form-control" type="number" id="lower_aligner" name="lower_aligner"
                                           required>
                                </div>
                            </div>

                        </div>
                        <!-- /.col -->
                    </div>

                    <div class="row">
                        <div class="col-md-12">

                            <div class="col-sm-4" runat="server">

                                <label for="exampleInputFile">File Before</label>
                                <label class="control-label file_before" style="display:none; color: #fc4b6c;"><i
                                        class="fa fa-times-circle-o"></i></label>

                                <div class="file-drop-area border dropzone clsbox" id="mydropzone">
                                </div>
                            </div>

                            <div class="col-sm-4" runat="server">
                                <div class="form-group">
                                    <label for="exampleInputFile">File After</label>
                                    <label class="control-label file_after" style="display:none; color: #fc4b6c;"><i
                                            class="fa fa-times-circle-o"></i></label>
                                    <div class="file_after-drop-area border dropzone clsbox" id="fileafterdropzone">
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <label for="exampleInputFile">IPR Form</label>

                                <div class="ipr_form-drop-area border">
                                    <label class="control-label" for="inputError" style="color: red"><i
                                            id="ipr_form_error"></i></label>
                                    <input type="file" id="ipr_form" name="ipr_form" class="ipr_form files"
                                           accept="image/*" required>
                                    <p class="message">Drag your files here or click in this area.</p>
                                </div>
                                <img src="" id="profile-img-tag" width="200px"/>
                            </div>
                        </div>
                    </div>
                    <!-- /.row -->
                </div>
                <div class="box-footer">
                    <button type="submit" id="button" class="btn btn-info pull-right">Submit Case</button>
                </div>
                <!-- /.box-body -->
            </form>
        </div>
        <!-- /.box -->
    </section>
@endsection
@section('case-script')

    <script src="{{asset('public/js/jquery.js')}}"></script>
    <script src="{{asset('public/notify.min.js')}}"></script>
    <script src="{{asset('public/js/dropzone.js')}}"></script>
    {{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>--}}


    <script>
        Dropzone.autoDiscover = false;
        var file_after;
        var fileList = new Array;
        var i = 0;

        // Dropzone class:
        var myDropzone = new Dropzone("div#mydropzone", {

            url: "{{route('dropzone-files')}}",
            acceptedFiles: '.stl',
            addRemoveLinks: true,
            autoProcessQueue: false,
            uploadMultiple: true,
            paramName: "file_before",
            params: {
                _token: "{{csrf_token()}}"
            },
        });

        var fileafterdropzone = new Dropzone("div#fileafterdropzone", {
            url: "{{route('dropzone-files')}}",
            acceptedFiles: '.stl',
            addRemoveLinks: true,
            parallelUploads: 10,
            uploadMultiple: true,
            paramName: "file_after",
            autoProcessQueue: false,
            params: {
                _token: "{{csrf_token()}}"
            },
        });

    </script>

    <script type="text/javascript">
        var path = "{{ url('case-number-search') }}";

        $('#typeahead').typeahead({
            source: function (query, process) {
                return $.get(path, {query: query}, function (data) {
                    return process(data);

                });
            }
        });
    </script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <script>
        $(document).ready(function (e) {
            // Submit form data via Ajax
            $("#case-form").on('submit', function (e) {

                fileafterdropzone.processQueue();
                myDropzone.processQueue();

                e.preventDefault();
                var formData = new FormData(this);

                $.ajax({
                    type: 'POST',
                    url: '{{route('case-submit')}}',
                    // data: new FormData(this),
                    dataType: 'json',
                    data: formData,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (response) {

                        var files_before = Dropzone.forElement("div#mydropzone");
                        files_before.removeAllFiles();
                        var fiels_after = Dropzone.forElement("div#fileafterdropzone");
                        fiels_after.removeAllFiles();

                        $.notify("Case Registered Successfully", "success");

                    },
                    error: function (xhr, json, errorThrown) {

                        var response = JSON.parse(xhr.responseText);

                        $.each(response.errors, function (key, value) {

                            $("#" + key + "_error").text(value[0]);
                            var element = document.getElementById(key + "_error");
                            element.classList.add('fa', 'fa-times-circle-o');
                            $("#" + key + "_error").css("color", "red");

                            $.notify(" There might be a problem case not registered", "error");
                        });
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            $("#case_number").keyup(function () {
                var query = $(this).val();

                if (query != '') {

                    $.ajax({
                        url: "{{route('get-case-numbers-ajax-call')}}",
                        method: "POST",
                        data: {"_token": "{{ csrf_token() }}", query: query},
                        success: function (data) {
                            // console.log(data.html);
                            $('#caseNumberList').fadeIn();
                            $('#caseNumberList').html(data.html);

                        }
                    });
                }

            });

            $(document).on('click', "li[name^='autocomplete']", function () {

                var val = $('#case_number').val($(this).text());

                $('#caseNumberList').fadeOut();
                var case_number = $("#case_number").val();

                if (case_number != '') {

                    $.ajax({
                        url: "{{route('get-case-data-ajax-call')}}",
                        method: "POST",
                        data: {"_token": "{{ csrf_token() }}", case_number: case_number},
                        success: function (data) {
                            console.log(data.operator_id.name);

                            $('#case_number').val(data.case.case_number);
                            $('#patient_name').val(data.case.patient_name);
                            $('#doctor_name').val(data.case.doctor_name);
                            $('#upper_aligner').val(data.patient.upper_aligner);
                            $('#lower_aligner').val(data.patient.lower_aligner);
                            $('#operator_id').val(data.operator_id.id);
                        }
                    });
                }
            });
        });

        $(function () {
            $('.file_before').change(function () {
                for (var i = 0; i <= this.files.length; i++) {
                    var filename = this.files[i].name;
                    $('.file_before_append').append('<div class="name">' + filename + '</div>');
                }
            });
        });
        $(function () {
            $('.file_after').change(function () {
                for (var i = 0; i <= this.files.length; i++) {
                    var filename = this.files[i].name;
                    $('.file_after_append').append('<div class="name">' + filename + '</div>');
                }
            });
        });
    </script>

    <script>
        var $ = jQuery.noConflict();

        var $fileInput = $('.file_after');
        var $droparea = $('.file_after-drop-area');

        $fileInput.on('dragenter focus click', function () {
            $droparea.addClass('is-active');
            $droparea.removeClass('message');

        });

        $fileInput.on('dragleave blur drop', function () {
            $droparea.removeClass('is-active');
        });

        var $fileInput1 = $('.file_before');
        var $droparea1 = $('.file-drop-area');

        $fileInput1.on('dragenter focus click', function () {
            $droparea1.addClass('is-active');

        });

        $fileInput1.on('dragleave blur drop', function () {
            $droparea1.removeClass('is-active');
        });

        var $fileInput2 = $('.ipr_form');
        var $droparea2 = $('.ipr_form-drop-area');

        $fileInput2.on('dragenter focus click', function () {
            $droparea2.addClass('is-active');

        });

        $fileInput2.on('dragleave blur drop', function () {
            $droparea2.removeClass('is-active');
        });

    </script>

    <script type="text/javascript">
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#profile-img-tag').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#ipr_form").change(function () {
            readURL(this);
        });
    </script>

@endsection
