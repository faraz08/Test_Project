@extends('layout')
@section('content')

    <section class="content">

        <div class="row">
            <div class="col-md-4">

                <!-- Profile Image -->
                <div class="box box-primary">
                    <div class="box-body box-profile">
                        <img class="profile-user-img img-responsive img-circle" src="{{asset('public/images/5.jpg')}}" alt="User profile picture">

                        <h3 class="profile-username text-center">{{$user->name}}</h3>

                        <p class="text-muted text-center">{{$getUserRoles->roles[0]->name}}</p>

                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
            <div class="col-md-8">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">

                        <li class="active"><a href="#settings" data-toggle="tab" aria-expanded="true">Settings</a></li>
                    </ul>

                    <div class="tab-content">

                        <div class="tab-pane active" id="settings">
                            <form class="form-horizontal form-element" id="user-form" action="{{route('update-user-password')}}">
                                @csrf
                                <div class="form-group">
                                    <label for="inputName" class="col-sm-2 control-label">Username</label>

                                    <div class="col-sm-10">
                                        <input type="email" class="form-control" id="inputName" placeholder="" value="{{$user->name}}" disabled>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputName" class="col-sm-2 control-label">Full name</label>

                                    <div class="col-sm-10">
                                        <input type="email" class="form-control" id="inputName" placeholder="" value="{{$user->full_name}}" disabled>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail" class="col-sm-2 control-label">Email</label>

                                    <div class="col-sm-10">
                                        <input type="email" class="form-control" id="inputEmail" placeholder="" value="{{$user->email}}" disabled>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label  class="col-sm-2 control-label">Current Password</label>

                                    <div class="col-sm-10">
                                        <input type="password" class="form-control" name="current_password" placeholder="new password">

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label  class="col-sm-2 control-label">New Password</label>

                                    <div class="col-sm-10">
                                        <input type="password" class="form-control" name="password" placeholder="new password">

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label  class="col-sm-2 control-label">Retype Password</label>

                                    <div class="col-sm-10">
                                        <input type="password" class="form-control" name="password_confirmation" placeholder="confirm password">

                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button type="submit" class="btn btn-success">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div>
                <!-- /.nav-tabs-custom -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

    </section>

@endsection

@section('case-script')
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
        $("#user-form").on('submit', function (e) {

            e.preventDefault();
            var formData = new FormData(this);

            $.ajax({
                type: 'POST',
                url: '{{route('update-user-password')}}',
                // data: new FormData(this),
                dataType: 'json',
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                success: function (response) {

                    $.notify("Password Successfully changed", "success");

                },
                error: function (xhr, json, errorThrown) {

                    var response = JSON.parse(xhr.responseText);

                    $.each(response.errors, function (key, value) {

                        $.notify(" There might be a problem password not changed", "error");
                    });
                }
            });
        });
    });
</script>

@endsection
