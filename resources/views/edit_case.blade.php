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

        .dropzone .dz-preview {
            display: inline-block;
            width: 39%;
        }

        .dz-default.dz-message span {
            color: #d2d6de
        }

        p.text-aqua {
            padding-top: 10px;
            border-bottom: 3px solid;
        }

        .text-aqua, .text-info {
            display: table;
        }

        .text-aqua button.close {
            color: red;
        }

    </style>
@endsection
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Edit Case
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">case</a></li>
            <li class="active">edit case</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Basic Forms -->
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Edit Case</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="flash-message" id="flash-message"></div>
            <!-- /.box-header -->
            {{--{{print_r($patient)}}--}}
            <form method="post" enctype="multipart/form-data" id="case-form"
                  action="{{route('edit-patient-case-submit')}}">
                <input type="hidden" name="patient_id" value="{{$patient->id}}">
                <input type="hidden" name="revisions" value="{{$patient->revisions}}">
                @csrf
                <div class="box-body form-element">
                    <div class="row">

                        <div class="col-md-12">
                            <div class="form-group clearfix">
                                <div class="col-sm-12">
                                    <label for="example-text-input" class="col-sm-10">Portal ID</label>
                                    <input class="form-control" type="text" name="portal" id="portal"
                                           value={{$patient['cases']->case_number}}
                                               required>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group clearfix">
                                <div class="col-sm-12">
                                    <label for="example-text-input" class="col-sm-10">Case ID</label>
                                    <div id="">
                                        <input class="form-control typeahead" type="text" name="case_number"
                                               value="{{$patient['cases']->case_number}}" id="case_number"
                                               autocomplete="off" id="(@error('case_number') inputError @enderror"
                                               max="50" readonly>
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
                                    <input class="form-control" type="text" name="doctor_name" id="doctor_name"
                                           value="{{$patient['cases']->doctor_name}}" required max="50">
                                </div>

                            </div>
                            <div class="form-group clearfix">

                                <div class="col-sm-12">
                                    <label for="example-text-input" class="col-sm-10">Upper Aligner</label>
                                    <input class="form-control" type="number" name="upper_aligner" id="upper_aligner"
                                           value="{{$patient->upper_aligner}}" required>
                                </div>

                            </div>
                            <div class="form-group clearfix">

                                <div class="col-sm-12">
                                    <label class="col-sm-10">Operator</label>
                                    <select class="form-control select2" style="width: 100%;" name="operator_name"
                                            value="{{$patient->operator_name}}" id="operator_id" required>
                                        @foreach($operators as $operator)
                                            <option
                                                value="{{$operator->id}}" {{($patient->operator_name == $operator->id) ? 'selected' : '' }}>{{$operator->name}}</option>
                                        @endforeach

                                    </select>
                                </div>

                            </div>

                        </div>

                        <div class="col-md-6">
                            <div class="form-group clearfix">

                                <div class="col-sm-12">
                                    <label for="example-text-input" class="col-sm-10">Portal</label>
                                    <select class="form-control col-sm-10" name="portal_id" id="portal" required>
                                        @foreach($portal as $obj)
                                            <option
                                                value="{{$obj->id}}" {{($patient['cases']->portal_id == $obj->id) ? 'selected' : '' }}>{{$obj->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                            <div class="form-group clearfix">

                                <div class="col-sm-12">
                                    <label for="example-text-input" class="col-sm-10">Patient</label>
                                    <input class="form-control" type="text" name="patient_name" id="patient_name"
                                           value="{{$patient['cases']->patient_name}}" required max="50">
                                </div>

                            </div>
                            <div class="form-group clearfix">

                                <div class="col-sm-12">
                                    <label for="example-text-input" class="col-sm-10">Lower Aligner</label>
                                    <input class="form-control" type="number" id="lower_aligner" name="lower_aligner"
                                           value="{{$patient->lower_aligner}}" required>
                                </div>
                            </div>

                        </div>
                        <!-- /.col -->
                    </div>

                    <div class="row">
                        <div class="col-md-12">

                            <div class="col-sm-4">

                                <label for="exampleInputFile">File Before</label>
                                <div class="file-drop-area border">
                                    <label class="control-label file_before"
                                           style="display:none; color: #fc4b6c;"><i
                                            class="fa fa-times-circle-o"></i></label>

                                    <input type="file" id="file_before" name="file_before[]" class="file_before files"
                                           accept=".stl" required multiple>
                                    <p class="message">Drag your files here or click in this area.</p>
                                </div>
                                    <button id="file_before_reset" class="btn btn-danger"><i class="fa fa-refresh"
                                                                                             aria-hidden="true"></i>
                                    </button>

                                    <div class="file_before_reset" id="file_before_reset_append">
                                        <div class="file_before_append"></div>
                                    </div>


                                @foreach($filtered_array_beforeFiles as $key => $value)
                                    <p class="text-aqua">{{str_replace('"', "", $value)}}
                                        <button type="button" id="myBtn" class="close" aria-hidden="true"
                                                value="{{str_replace('"', "", $value)}}" onclick="getValue(this.value)">
                                            x
                                        </button>
                                    </p>
                                @endforeach
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="exampleInputFile">File After</label>
                                    <div class="file_after-drop-area border">
                                        <label class="control-label file_after" style="display:none; color: #fc4b6c;"><i
                                                class="fa fa-times-circle-o"></i></label>
                                        <input type="file" id="file_after" name="file_after[]" class="file_after files"
                                               accept=".stl" required multiple>
                                        <p class="message">Drag your files here or click in this area.</p>
                                    </div>
                                    <button id="file_after_reset" class="btn btn-danger"><i class="fa fa-refresh" aria-hidden="true"></i></button>
                                    <div class="file_after_append"></div>

                                    @foreach($filtered_array_afterFiles as $key => $value)
                                        <p class="text-aqua">{{str_replace('"', "", $value)}}
                                            <button type="button" id="myBtn" class="close" aria-hidden="true"
                                                    value="{{str_replace('"', "", $value)}}"
                                                    onclick="afterFileGetValue(this.value)">x
                                            </button>
                                        </p>
                                    @endforeach

                                </div>
                            </div>

                            <div class="col-sm-4">
                                <label for="exampleInputFile">IPR Form</label>

                                <div class="ipr_form-drop-area border">
                                    <input type="file" id="ipr_form" name="ipr_form" class="ipr_form files"
                                           accept="image/*">
                                    <p class="message">Drag your files here or click in this area.</p>
                                </div>
                                <img src="" id="profile-img-tag" width="200px"/>

                                <a href="{{url('public/cases/'.$patient['cases']->case_number.'/ipr_form/'.$patient->revisions.'/'.$patient->ipr_form)}}"
                                   class="text-aqua" target="_blank">{{$patient->ipr_form}}</a>

                            </div>
                        </div>
                    </div>
                    <!-- /.row -->
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-info pull-right">Submit Case</button>
                </div>
                <!-- /.box-body -->
            </form>
        </div>
        <!-- /.box -->
    </section>
@endsection
@section('case-script')

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="{{asset('public/notify.min.js')}}"></script>
    {{--    <script src="{{asset('public/js/dropzone.js')}}"></script>--}}

    {{--    <script>--}}
    {{--        Dropzone.autoDiscover = false;--}}
    {{--        var file_after;--}}
    {{--        var fileList = new Array;--}}
    {{--        var i = 0;--}}

    {{--        // Dropzone class:--}}
    {{--        var myDropzone = new Dropzone("div#mydropzone", {--}}

    {{--            url: "{{route('dropzone-files')}}",--}}
    {{--            acceptedFiles: '.stl',--}}
    {{--            addRemoveLinks: true,--}}
    {{--            autoProcessQueue: true,--}}
    {{--            uploadMultiple: true,--}}
    {{--            paramName: "file_before",--}}
    {{--            params: {--}}
    {{--                _token: "{{csrf_token()}}"--}}
    {{--            },--}}
    {{--            removedfile: function (file) {--}}
    {{--                var name = file.name;--}}

    {{--                $.ajax({--}}
    {{--                    type: 'POST',--}}
    {{--                    url: "{{url('del-dropzone-file')}}",--}}
    {{--                    data: {file_before: name, request: 2},--}}
    {{--                    sucess: function (data) {--}}
    {{--                        console.log('success: ' + data);--}}
    {{--                    }--}}
    {{--                });--}}
    {{--                var _ref;--}}
    {{--                return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;--}}
    {{--            }--}}

    {{--        });--}}


    {{--        var myDropzone = new Dropzone("div#fileafterdropzone", {--}}
    {{--            url: "{{route('dropzone-files')}}",--}}
    {{--            acceptedFiles: '.stl',--}}
    {{--            addRemoveLinks: true,--}}
    {{--            parallelUploads: 10,--}}
    {{--            uploadMultiple: true,--}}
    {{--            paramName: "file_after",--}}
    {{--            autoProcessQueue: true,--}}
    {{--            params: {--}}
    {{--                _token: "{{csrf_token()}}"--}}
    {{--            },--}}
    {{--            removedfile: function (file) {--}}
    {{--                var name = file.name;--}}

    {{--                $.ajax({--}}
    {{--                    type: 'POST',--}}
    {{--                    url: "{{url('del-dropzone-file')}}",--}}
    {{--                    data: {file_after: name, request: 2},--}}
    {{--                    sucess: function (data) {--}}
    {{--                        location.reload(true);--}}
    {{--                        console.log('success: ' + data);--}}
    {{--                    }--}}
    {{--                });--}}
    {{--                var _ref;--}}
    {{--                return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;--}}
    {{--            }--}}
    {{--        });--}}
    {{--    </script>--}}

    <script>

        $("#case-form").submit(function (e) {

            // alert('case-form');

            e.preventDefault();

            var validFields = $('input[name="file_before[]"],input[name="file_after[]"]').map(function () {
                if ($(this).val() != "")
                    return $(this);
            }).get();


            $.ajax({
                type: 'POST',
                url: '{{route('edit-patient-case-submit')}}',
                data: new FormData(this),
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                success: function (response) {

                    var value = JSON.parse(response);

                    $('.file_before').show();
                    $('.file_before').append('<label>' + value[0] + '</label>');

                    $('.file_after').show();
                    $('.file_after').append('<label>' + value[1] + '</label>');

                    $('#flash-message').html(response);

                    $.notify("Case Registered Successfully", "success");
                },
                error: function (response) {
                    console.log('yeah baby');
                    $.notify(" There might be a problem case not registered", "error");
                }
            });

        });

        function getValue(x) {

            var file_before = x;
            var id = "{{ Request::segment(2) }}";
            // console.log(id);
            // alert(id);
            // return false;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '{{route('del-dropzone-file-related-to-patient')}}',
                type: 'POST',
                dataType: 'text',
                data: {file_before: file_before, id: id},

                success: function (response) {
                    $(this).hide()
                    $.notify("File Deleted", "success");

                }
            })

            // console.log(file_before);
            // alert(file_before)
        }

        function afterFileGetValue(x) {

            var file_after = x;
            var id = "{{ Request::segment(2) }}";

            // console.log(id);
            // alert(id);
            // return false;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '{{route('del-dropzone-file-related-to-patient')}}',
                type: 'POST',
                dataType: 'text',
                data: {id: id, file_after: file_after},

                success: function (response) {
                    $(this).hide()
                    $.notify("File Deleted", "success");

                }
            })

        }
    </script>

    <script>
        var $ = jQuery.noConflict();

        var $fileInput2 = $('.ipr_form');
        var $droparea2 = $('.ipr_form-drop-area');

        $fileInput2.on('dragenter focus click', function () {
            $droparea2.addClass('is-active');

        });

        $fileInput2.on('dragleave blur drop', function () {
            $droparea2.removeClass('is-active');
        });

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

    <script>
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
    <script type="text/javascript">

        document.getElementById('file_after_reset').onclick = function (event) {
            var field = document.getElementById('file_after');
            field.value = field.defaultValue;

            $(".name").remove();

            event.preventDefault();
        };

        document.getElementById('file_before_reset').onclick = function (event) {
            var field = document.getElementById('file_after');
            field.value = field.defaultValue;

            $(".name").remove();

            event.preventDefault();
        };
    </script>

@endsection
