@extends('admin.layout')
@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-md-10">
               <h1 class="h3 mb-2 text-gray-800">Edit Permission</h1>
            </div>
            <div class="col-md-2">
                <a href="{{ route('role_list') }}" class="btn btn-dark btn-icon-split">
                    <span class="text">Back</span>
                </a>
            </div>
        </div>
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <!--<div class="card-header py-3">-->
            <!--    <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>-->
            <!--</div>-->
            <div class="card-body">
                @if(session('error'))
                    <div class="alert alert-custom alert-indicator-top indicator-danger" role="alert">
                        <div class="alert-content">
                            <span class="alert-title">Error!</span>
                            <span class="alert-text"> {{ session('error') }}</span>
                        </div>
                    </div>
                @endif
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-3">
                        </div>
                        <div class="col-md-9">
                            <form action="{{ route('update_role_permission',$role->role_id) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row mb-3">
                                    <div class="col mb-10"></div>
                                    <div class="col-sm-2">
                                        <input type="submit" class="btn btn-primary" value="Save">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Name</label>
                                    <div class="col-sm-9">
                                        <input type="text"  placeholder="Name" class="form-control" value="{{ $role->name }}" disabled id="inputEmail3" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Permissions</label>
                                    <div class="col-sm-9">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Permission</th>
                                                    <th>Is Visible</th>
                                                    <th>Create</th>
                                                    <th>Edit</th>
                                                    <th>Delete</th>
                                                </tr>
                                            </thead>
                                            @php
                                            $permission = json_decode($role->permission);
                                            @endphp 
                                            @foreach($permissions as $row1)
                                                    <tr>
                                                        <td>{{ $row1->name }}</td>
                                                        <td>
                                                            <div class="settings-integrations-item-switcher">
                                                                <div class="form-check form-switch">
                                                                    <input class="form-check-input form-control-md" type="checkbox" value="{{ $row1->permission_id }}" name="permission[]" @if(in_array($row1->permission_id,$permission)) {{ 'checked';}} @endif>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <input type="hidden" value="{{ $row1->permission_id }}" name="user_permissions[{{ $row1->permission_id }}][permission_id]">
                                                            <div class="settings-integrations-item-switcher">
                                                                <div class="form-check form-switch">
                                                                    <input class="form-check-input form-control-md" type="checkbox" value="1" name="user_permissions[{{ $row1->permission_id }}][is_create]" @if($row1->is_create==1) {{ 'checked';}} @endif>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="settings-integrations-item-switcher">
                                                                <div class="form-check form-switch">
                                                                    <input class="form-check-input form-control-md" type="checkbox" value="1" name="user_permissions[{{ $row1->permission_id }}][is_edit]" @if($row1->is_edit==1) {{ 'checked';}} @endif>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="settings-integrations-item-switcher">
                                                                <div class="form-check form-switch">
                                                                    <input class="form-check-input form-control-md" type="checkbox" value="1" name="user_permissions[{{ $row1->permission_id }}][is_delete]" @if($row1->is_delete==1) {{ 'checked';}} @endif>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                            @endforeach
                                        </table>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col mb-10"></div>
                                    <div class="col-sm-2">
                                        <input type="submit" class="btn btn-primary" value="Save">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection