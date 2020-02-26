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


var path = "{{ url('case-number-search') }}";

$('#typeahead').typeahead({
    source: function (query, process) {
        return $.get(path, {query: query}, function (data) {
            return process(data);

        });
    }
});


$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function (e) {
    // Submit form data via Ajax
    $("#case-form").on('submit', function (e) {

        fileafterdropzone.processQueue();
        myDropzone.processQueue();

        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            type: 'POST',
            url: "{{route('case-submit')}}",
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
