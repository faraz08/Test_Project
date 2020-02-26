@extends('layout')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            User Management
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{url('/')}}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active"><a href="{{url('users')}}">user management</a></li>
        </ol>
    </section>
    @if( Session::has("success") )
        <div class="container flash-padd">
            <div class="alert alert-success alert-block" role="alert">
                <button class="close" data-dismiss="alert"></button>
                {{ Session::get("success") }}
            </div>
        </div>
    @endif
    <section class="content">
        <div class="box">
            <div class="box-header">
                @role(['admin'])
                <button type="button" class="btn btn-info pull-right" data-toggle="modal"
                        data-backdrop="static" data-keyboard="false" data-target="#modal-add-new-user">
                    Add New User
                </button>
                @endrole
                <h3 class="box-title">Users List</h3>
                <h6 class="box-subtitle">Manage users from here</h6>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <table id="example" class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Roles</th>
                        <th>Status</th>
                        @role($assigned_roles)
                        @permission('create')
                        <th>Actions</th>
                        @endpermission
                        @endrole
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($getUserRoles as $users)
                        <tr>
                            <td>{{$users->name}}</td>
                            <td>
                                @foreach($users->roles as $roles)
                                    <span class="badge bg-green">{{$roles->name}}</span>
                                @endforeach
                            </td>
                            <td>
                                <form action="{{route('user-status-change')}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{$users->id}}">
                                    <select class="form-control" name="status" id="status"
                                            onchange="this.form.submit()" {{(Auth::user()->isAdmin()) ? '' : 'disabled' }} >
                                        @foreach($status as $single_status)
                                            <option
                                                {{($single_status == $users->status) ? 'selected' : ''}} value="{{$single_status}}">{{$single_status}}</option>
                                        @endforeach
                                    </select>
                                </form>
                            </td>
                            @role($assigned_roles)
                            <td>
                                <div class="tools">
{{--                                    @permission('edit')--}}
                                    @role(['admin'])
                                    <a type="button" href="{{url('edit-Permissions'.'/'.$users->name)}}"
                                       class="btn btn-default btn-xs bg-blue"><i class="fa fa-edit"></i> Edit</a>
                                    @endrole
{{--                                    @endpermission--}}
{{--                                    @permission('delete')--}}
                                    @role(['admin'])
                                    <a type="button" class="btn btn-default btn-xs bg-red user-del" id="{{$users->id}}"><i
                                            class="fa fa-trash-o"></i>
                                        Delete</a>
                                    @endrole

                                    <a type="button" href="{{url('user-profile'.'/'.$users->name)}}" class="btn btn-default btn-xs bg-green"><i
                                            class="fa fa-trash-o"></i>
                                        Details</a>

{{--                                    @endpermission--}}
                                    {{--<button type="button" class="btn btn-default btn-xs bg-red user-del" id="{{$users->id}}"><i class="fa fa-folder-o" aria-hidden="true"></i>--}}
                                    {{--Assign Department</button>--}}
                                </div>
                            </td>
                            @endrole
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    </tfoot>
                </table>
            </div>
            <!-- /.box-body -->
        </div>

        <div class="modal fade" id="modal-add-new-user">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" onclick="javascript:window.location.reload()" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Add New User</h4>
                    </div>
                    <div class="modal-body">
                        <div class="box-body form-element">
                            <form method="POST" action="{{ route('register-user') }}" class="form-element"
                                  id="save-user">
                                @csrf
                                <div class="form-group has-feedback">
                                    <label class="control-label" for="inputError" style="color: red"><i
                                            id="full_name_error"></i></label>
                                    <input type="text" class="form-control" name="full_name" placeholder="Full name">
                                    <span class="ion ion-person form-control-feedback "></span>
                                </div>
                                <div class="form-group has-feedback">
                                    <label class="control-label" for="inputError" style="color: red"><i
                                            id="name_error"></i></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                           value="{{ old('name') }}" name="name" placeholder="User Name" required
                                           autocomplete="name" autofocus max="20">
                                    <span class="ion ion-person form-control-feedback "></span>
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                        </span>
                                    @enderror
                                </div>
                                <div class="form-group has-feedback">
                                    <label class="control-label" for="inputError" style="color: red"><i
                                            id="email_error"></i></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                           value="{{ old('email') }}" required autocomplete="email" name="email"
                                           placeholder="Email">
                                    <span class="ion ion-email form-control-feedback "></span>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                        </span>
                                    @enderror
                                </div>
                                <div class="form-group has-feedback">
                                    <label class="control-label" for="inputError" style="color: red"><i
                                            id="password_error"></i></label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                           name="password" placeholder="Password" required autocomplete="new-password">
                                    <span class="ion ion-locked form-control-feedback "></span>
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                        </span>
                                    @enderror
                                </div>
                                <div class="form-group has-feedback">
                                    <label class="control-label" for="inputError" style="color: red"><i
                                            id="password_confirmation_error"></i></label>
                                    <input type="password" class="form-control" placeholder="Retype password"
                                           name="password_confirmation" required autocomplete="new-password">
                                    <span class="ion ion-log-in form-control-feedback "></span>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" onclick="javascript:window.location.reload()" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" form="save-user">Save changes</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
    </section>

    @role(['admin'])
    <section class="content">
        <div class="box">
            <div class="box-header">
                @role(['admin'])
                <button type="button" class="btn btn-info pull-right" data-toggle="modal"
                        data-target="#modal-add-new-department">
                    Add Department
                </button>
                @endrole
                <h3 class="box-title">Departments List</h3>
                <h6 class="box-subtitle">Manage departments from here</h6>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <table id="example" class="table table-bordered table-hover display nowrap margin-top-10">
                    <thead>
                    <tr>
                        <th>Department name</th>
                        @role(['admin'])
                        <th>Actions</th>
                        @endrole
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($departments as $department)
                        <tr>
                            @role(['admin'])
                            <td>{{$department->department_name}}</td>
                            @endrole

                            @role(['admin'])
                            <td>
                                <div class="tools">
                                    <button type="button"
                                            data-toggle="modal"
                                            data-target=".bd-example-modal-lg"
                                            id="{{$department->id}}"
                                            data-backdrop="static" data-keyboard="false"
                                            class="btn btn-default btn-xs bg-blue modal-department-details"><i
                                            class="fa fa-edit"></i> Details
                                    </button>
                                    <a type="button" class="btn btn-default btn-xs bg-red department-del"
                                       id="{{$department->id}}"><i class="fa fa-trash-o"></i>
                                        Delete</a>
                                </div>
                            </td>
                            @endrole
                        </tr>
                    @endforeach

                    </tbody>
                    <tfoot>
                    </tfoot>
                </table>
            </div>
            <!-- /.box-body -->
        </div>
        <div class="modal fade" id="modal-add-new-department">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Add Department</h4>
                    </div>
                    <div class="modal-body">
                        <div class="box-body form-element">
                            <form method="POST" action="{{ route('register-department') }}" class="form-element"
                                  id="register-department">
                                @csrf
                                <div class="form-group has-feedback">
                                    <input type="text" class="form-control" name="department_name"
                                           placeholder="Department">
                                    <span class="ion ion-person form-control-feedback "></span>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" form="register-department">Save changes</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
        <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
             aria-hidden="true" id="modal-department-details">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Users in Department</h4>
                    </div>
                    <div class="modal-body">
                        <div id="departmentUserModal"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
    </section>
    @endrole

@endsection
@section('datatables-script')
    <script
        src="{{asset('public/assets/vendor_plugins/DataTables-1.10.15/media/js/jquery.dataTables.min.js')}}"></script>
    <!-- start - This is for export functionality only -->
    <script
        src="{{asset('public/assets/vendor_plugins/DataTables-1.10.15/extensions/Buttons/js/dataTables.buttons.min.js')}}"></script>
    <script
        src="{{asset('public/assets/vendor_plugins/DataTables-1.10.15/extensions/Buttons/js/buttons.flash.min.js')}}"></script>
    {{--<script src="{{asset('public/assets/vendor_plugins/DataTables-1.10.15/ex-js/jszip.min.js')}}"></script>--}}
    {{--<script src="{{asset('public/assets/vendor_plugins/DataTables-1.10.15/ex-js/pdfmake.min.js')}}"></script>--}}
    {{--<script src="{{asset('public/assets/vendor_plugins/DataTables-1.10.15/ex-js/vfs_fonts.js')}}"></script>--}}
    <script
        src="{{asset('public/assets/vendor_plugins/DataTables-1.10.15/extensions/Buttons/js/buttons.html5.min.js')}}"></script>
    <script
        src="{{asset('public/assets/vendor_plugins/DataTables-1.10.15/extensions/Buttons/js/buttons.print.min.js')}}"></script>
    <!-- mpt_admin for Data Table -->
    <script src="{{asset('public/js/pages/data-table.js')}}"></script>
    <script>
        $(document).ready(function () {

            // Delete
            $('a.user-del').click(function () {
                var result = confirm("Are you sure you want to delete?");
                if (result) {
                    var el = this;
                    var id = this.id;

                    // AJAX Request
                    $.ajax({
                        url: '{{route('delete-user')}}',
                        type: 'POST',
                        data: {"_token": "{{ csrf_token() }}", id: id},
                        success: function (response) {

                            console.log(response);

                            if (response == 1) {
                                // Remove row from HTML Table
                                $(el).closest('tr').fadeOut(800, function () {
                                    $(this).remove();
                                });
                                $.notify("User successfully deleted", "success");
                            } else {
                                $.notify(" There might be a problem record not deleted", "error");
                            }
                        }
                    });
                }
            });
        });

        $(document).ready(function () {
            // Delete
            $('a.department-del').click(function () {

                var result = confirm("Are you sure you want to delete?");

                if (result) {
                    var el = this;
                    var id = this.id;

                    // AJAX Request
                    $.ajax({
                        url: '{{route('delete-department')}}',
                        type: 'POST',
                        data: {"_token": "{{ csrf_token() }}", id: id},
                        success: function (response) {

                            console.log(response);

                            if (response == 1) {
                                // Remove row from HTML Table
                                $(el).closest('tr').fadeOut(800, function () {
                                    $(this).remove();
                                });
                                $.notify("User successfully deleted", "success");
                            } else {
                                $.notify(" There might be a problem record not deleted", "error");
                            }
                        }
                    });
                }
            });
        });

        $(document).ready(function (e) {
            // Submit form data via Ajax
            $("#register-department").on('submit', function (e) {

                e.preventDefault();

                var validFields = $('input[name="department_name"]').map(function () {
                    if ($(this).val() != "")
                        return $(this);
                }).get();

                if (validFields.length) {

                    $.ajax({
                        type: 'POST',
                        url: '{{route('register-department')}}',
                        data: new FormData(this),
                        dataType: 'json',
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function (response) {

                            $.notify("Department Registered Successfully", "success");
                        },
                        error: function (response) {

                            $.notify(" There might be a problem department not registered", "error");
                        }
                    });
                } else {
                    alert("Form is not valid");
                    $.notify("Form is not valid try reload page", "error");
                }
            });
        });

        $(document).ready(function (e) {
            $(".modal-department-details").click(function (event) {
                var id = $(this).attr('id');

                $.ajax({
                    url: "{{route('department-details')}}",
                    method: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        id: id
                    },
                    success: function (data) {
                        $('#departmentUserModal').html(data.html);

                    }
                });
            });
        });

    </script>
    <script>
        $(document).ready(function (e) {
            // Submit form data via Ajax
            $("#save-user").on('submit', function (e) {

                e.preventDefault();
                var formData = new FormData(this);

                $.ajax({
                    type: 'POST',
                    url: '{{route('register-user')}}',
                    // data: new FormData(this),
                    dataType: 'json',
                    data: formData,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (response) {
                    console.log(response);
                        $.notify("User Registered Successfully", "success");

                    },
                    error: function (xhr, json, errorThrown) {

                        var response = JSON.parse(xhr.responseText);

                        $.each(response.errors, function (key, value) {

                            $("#" + key + "_error").text(value[0]);
                            var element = document.getElementById(key + "_error");
                            element.classList.add('fa', 'fa-times-circle-o');
                            $("#" + key + "_error").css("color", "red");

                            $.notify(" There might be a problem user not registered", "error");
                        });
                    }
                });
            });
        });
    </script>
@endsection
