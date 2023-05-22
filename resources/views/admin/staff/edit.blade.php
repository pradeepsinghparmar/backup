@extends('admin.layout')
@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-md-10">
                <h1 class="h3 mb-2 text-gray-800">Edit Staff</h1>
            </div>
            <div class="col-md-2">
                 <a href="{{ route('staff_list') }}" class="btn btn-dark btn-icon-split">
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
                        <div class="col-md-3"></div>
                        <div class="col-md-9">
                            <form action="{{ route('update_staff',$editstaff->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                                <div class="row mb-3">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Name</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="name"  placeholder="Name" value="{{ $editstaff->name }}" class="form-control" id="inputEmail3" required>
                                    </div>
                                </div>
                                 <div class="row mb-3">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Email</label>
                                    <div class="col-sm-9">
                                        <input type="email" value="{{ $editstaff->email }}"  placeholder="Email" class="form-control" id="inputEmail3" disabled>
                                    </div>
                                </div>
                                 <div class="row mb-3">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Mobile</label>
                                    <div class="col-sm-9">
                                        <input type="number" name="phone" value="{{ $editstaff->phone }}"  placeholder="Mobile" class="form-control" id="inputEmail3" required>
                                    </div>
                                </div>
                                 <div class="row mb-3">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Password</label>
                                    <div class="col-sm-9">
                                        <input type="password" name="password"  placeholder="Password" class="form-control" id="inputEmail3">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Role</label>
                                    <div class="col-sm-9">
                                        <select name="role"  class="form-control" id="inputEmail3" required>
                                            <option selected="" disabled="" value="">Select Role</option>
                                            @foreach($role as $rl)
                                                @if($rl->role_id != 3)
                                                    <option value="{{ $rl->role_id }}" {{ $editstaff->role == $rl->role_id ? 'selected="selected"' : '' }}>{{ $rl->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <input type="submit" class="btn btn-primary" value="Update">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection