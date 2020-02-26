
    <!-- /.box-header -->
    <div class="box-body">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>Name</th>
                <th>Roles</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>

            @forelse($department_users as $dept_user)

            <tr>
                <td>{{$dept_user->name}}</td>
                <td>
                    @foreach($dept_user->roles as $role)
                        <span class="badge bg-green">{{$role->name}}</span>
                    @endforeach
                </td>
                <td>San Francisco</td>
                <td>
                    <a type="button" href="{{url('edit-Permissions'.'/'.$dept_user->name)}}" class="btn btn-default btn-xs bg-blue"><i class="fa fa-edit"></i> Edit</a>
                    <a type="button" class="btn btn-default btn-xs bg-red user-del" id=""><i class="fa fa-trash-o"></i>
                        Delete</a>
                </td>
            </tr>
            @empty
                    <p>No users</p>
            @endforelse

            </tbody>

        </table>
    </div>
    <!-- /.box-body -->
