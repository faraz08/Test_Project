@extends('layout')


@section('content')

    <div class="row">

        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Manage User Roles
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{url('/')}}"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="{{url('users')}}">users</a></li>
                <li class="active">user permissions</li>
            </ol>
        </section>
        <section class="content">

            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">User Roles & Permissions</h3>

                        <div class="box-tools pull-right">

                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#modal-department" data-backdrop="static" data-keyboard="false">
                                Assign Department
                            </button>

                        </div>
                    </div>

                    <div class="box-body table-responsive no-padding">
                        <table id="records_table" class="table table-hover">
                            <tr>

                                <th>User</th>
                                <th>Department</th>
                                <th>Roles</th>
                                <th></th>
                                <th></th>
                                <th>Actions</th>
                            </tr>

                            <tr>
                                <td>{{$getUserRoles->name}}</td>

                                <td>
                                    @if(!empty($getUserRoles->department))
                                        <span
                                            class="label label-success">{{$getUserRoles->department->department_name}}</span>
                                    @endif

                                </td>
                                <td>
                                    @foreach($getUserRoles->roles as $roles)
                                        <span class="label label-success">{{$roles->name}}</span>
                                    @endforeach
                                </td>
                                <td></td>
                                <td></td>
                                <td>

                                    <div class="tools">

                                        @if(empty($getUserRoles->roles))
                                            <button type="button"
                                                    class="btn btn-default btn-xs bg-blue modal-edit-permissions"
                                                    type="button" class="btn btn-info pull-right"
                                                    id="{{$getUserRoles->roles[0]->id}}" data-toggle="modal"
                                                    data-target="#modal-edit-permissions" data-backdrop="static"
                                                    data-keyboard="false"><i class="fa fa-edit"></i> Edit
                                            </button>
                                        @endif
                                        @if(!empty($getUserRoles->department))
{{--                                            <a type="button" class="btn btn-default btn-xs bg-purple user-del"--}}
                                            <a type="button" class="btn btn-default btn-xs bg-purple"
                                               data-toggle="modal" data-target="#modal-permissions"
                                               data-backdrop="static" data-keyboard="false"><i class="fa fa-user-circle"
                                                                                               aria-hidden="true"></i>
                                                Assign Roles</a>
                                        @endif
                                        @if(!empty($getUserRoles->department))
                                            <a type="button" class="btn btn-default btn-xs bg-red user-del"
                                               id=""><i
                                                    class="fa fa-trash-o"></i>
                                                Delete </a>
                                        @endif


                                        <input type="hidden" name="user_id" id="user_id" value="{{$getUserRoles->id}}">
                                    </div>

                                </td>
                            </tr>

                            <div id="display_result"></div>

                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </section>
    </div>

    <div class="modal fade" id="modal-edit-permissions">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Add New User</h4>
                </div>
                <div class="modal-body">
                    <div class="box-body">
                        <div id="edit_user_permissions"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="javascript:window.location.reload()"
                            class="btn btn-default pull-left" data-dismiss="modal">Close
                    </button>
                    <button type="submit" class="btn btn-primary" form="myForm">Save changes</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal fade in" id="modal-permissions">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">Assign Roles & Permissions</h4>
                </div>
                <div class="modal-body">
                    <div class="box-body">
                        <form method="post" id="myForm1" name="myForm1" action="{{route('user-roles-permission')}}">
                            <input type="hidden" name="user" value="{{$user->name}}">
                            <input type="hidden" name="department_id" value="{{$user->department_id}}">
                            @csrf
                            <div class="form-group">

                                <label>Roles</label>
                                <select class="form-control select2" style="width: 100%;" name="roles" id="roles">

                                    @foreach($all_roles as $roles)
                                        <option value="{{$roles->id}}">{{$roles->name}}</option>
                                    @endforeach

                                </select>
                            </div>

                            <div class="form-group">
                                <label>Permissions</label>
                                <select class="form-control select2" style="width: 100%;" multiple=""
                                        name="permissions[]">

                                    @foreach($all_permissions as $permissions)
                                        <option value="{{$permissions->id}}" {{(in_array($permissions->id, $user_permissions)) ? 'selected' : ''}}>{{$permissions->name}}</option>
                                    @endforeach

                                </select>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="javascript:window.location.reload()"
                            class="btn btn-default pull-left" data-dismiss="modal">Close
                    </button>
                    <button type="submit" class="btn btn-primary" form="myForm1">Save changes</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal fade in" id="modal-department">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">Assign User Department</h4>
                </div>
                <div class="modal-body">
                    <div class="box-body">
                        <form method="post" id="myForm2" name="myForm2" action="{{route('assign-user-department')}}">
                            <input type="hidden" name="user" value="{{$user->name}}">
                            @csrf
                            <div class="form-group">
                                <label>User</label>
                                <select class="form-control select2" style="width: 100%;" name="user" id="user">

                                    <option value="{{$user->id}}">{{$user->name}}</option>

                                </select>
                            </div>

                            <div class="form-group">
                                <label>Department</label>
                                <select class="form-control select2" style="width: 100%;" name="department">

                                    @foreach($department_list as $department)
                                        <option
                                            value="{{$department->id}}" {{($user->id == $department->id) ? 'selected' : ''}}>{{$department->department_name}}</option>
                                    @endforeach

                                </select>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="javascript:window.location.reload()"
                            class="btn btn-default pull-left" data-dismiss="modal">Close
                    </button>
                    <button type="submit" class="btn btn-primary" form="myForm2">Save changes</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

@endsection

@section('edit_user_permissions_script')

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
            $("#myForm").on('submit', function (e) {
                e.preventDefault();

                $.ajax({
                    type: 'POST',
                    url: '{{route('edit-user_permissions')}}',
                    data: new FormData(this),
                    dataType: 'html',
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (response) {
                        $('#flash-message').html(response);
                        console.log(response);
                    }
                });
            });
        });


        $(document).ready(function (e) {
            // Submit form data via Ajax
            $("#myForm1").on('submit', function (e) {
                e.preventDefault();

                $.ajax({
                    type: 'POST',
                    url: '{{route('user-roles-permission')}}',
                    data: new FormData(this),
                    dataType: 'html',
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (response) {

                        $.notify("Department Assigned Successfully", "success");

                    }
                });
            });
        });


    </script>

    <script>
        $(document).ready(function () {

            // Delete
            $('a.user-del').click(function () {

                var el = this;
                var id = this.id;
                var user_id = $('#user_id').val();

                alert(user_id);

                // AJAX Request
                $.ajax({
                    url: '{{route('delete-user-role')}}',
                    type: 'POST',
                    data: {"_token": "{{ csrf_token() }}", id: id, user_id: user_id},
                    success: function (response) {

                        console.log(response);
                        if (response == 1) {
                            // Remove row from HTML Table
                            $(el).closest('tr').fadeOut(800, function () {
                                $(this).remove();
                            });
                        } else {
                            alert('Invalid ID.');
                        }
                    }
                });
            });
        });


        $(document).ready(function (e) {
            $(".modal-edit-permissions").click(function (event) {

                var id = $(this).attr('id');
                var user = $(this).closest("tr").find("td:first-child").text();

                $.ajax({
                    url: "{{route('get-permissions')}}",
                    method: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        id: id, user: user
                    },
                    success: function (data) {
                        // console.log(data.html);
                        // $('#caseNumberList').fadeIn();
                        $('#edit_user_permissions').html(data.html);

                    }
                });
            });
        });
    </script>

    <script>
        $(document).ready(function (e) {
            // Submit form data via Ajax
            $("#myForm2").on('submit', function (e) {

                e.preventDefault();

                $.ajax({
                    type: 'POST',
                    url: '{{route('assign-user-department')}}',
                    data: new FormData(this),
                    dataType: 'json',
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (response) {

                        $.notify("Department Assigned Successfully", "success");

                    },
                    error: function (response) {

                        $.notify(" There might be a problem department not assigned", "error");
                    }
                });

            });
        });
    </script>


@endsection
