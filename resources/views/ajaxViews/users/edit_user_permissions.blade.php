<form method="post" id="myForm" name="myForm" action="{{route('edit-user_permissions')}}">
    <input type="hidden" name="user" value="{{$user}}">
    @csrf
            <!-- select -->
    <div class="form-group">
        <label>Role</label>
        <select class="form-control" name="roles" id="roles">
            @foreach($role_permissions as $role)
                <option value="{{$role->slug}}">{{$role->name}}</option>

            @endforeach
        </select>
    </div>

    <!-- Select multiple-->
    <div class="form-group">
        <label>Permissions</label>
        <select multiple="" class="form-control" name="permissions[]">

                @foreach($all_permissions as $permission)
                    <option value="{{$permission->slug}}" {{ (in_array($permission->slug, $permissions)) ? "selected" : "" }} >{{$permission->name}}</option>

                @endforeach

        </select>
    </div>

</form>