@extends('admin.layout')
@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-md-10">
                <h1 class="h3 mb-2 text-gray-800">Edit Employee</h1>
            </div>
            <div class="col-md-2">
                <a href="{{ route('employee_list') }}" class="btn btn-dark btn-icon-split">
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
                            <form action="{{ route('update_employee',$editstaff->id) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row mb-3">
                                    <label for="validationCustom01" class="col-sm-3 col-form-label required">First Name</label>
                                    <div class="col-sm-3">
                                        <input type="text" name="name" value="{{ $editstaff->name }}" placeholder="First Name" class="form-control" for="validationCustom01" required>
                                    </div>
                                    <label for="validationCustom01" class="col-sm-2 col-form-label required">Last Name</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="last_name" value="{{ $editstaff->last_name }}" placeholder="Last Name" class="form-control" for="validationCustom01" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label required">Email</label>
                                    <div class="col-sm-9">
                                        <input type="email" name="email" value="{{ $editstaff->email }}" placeholder="Email" class="form-control" id="inputEmail3" disabled>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label required">Mobile</label>
                                    <div class="col-sm-9">
                                        <input type="number" name="phone" value="{{ $editstaff->phone }}"  placeholder="Mobile" class="form-control" id="inputEmail3" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="validationCustom04" class="col-sm-3 col-form-label required">Employee Type</label>
                                    <div class="col-sm-9">
                                        <select name="employee_type"  class="form-control" for="validationCustom04" required>
                                            <option selected="" disabled="" value="">Select type</option>
                                            <option value="Employee" @if($editstaff->employee_type=='Employee') selected @endif>Employee</option>
                                            <option value="Contractor" @if($editstaff->employee_type=='Contractor') selected @endif>Contractor</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label required">Password</label>
                                    <div class="col-sm-9">
                                        <input type="password" name="password"  placeholder="Password" class="form-control" id="inputEmail3">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="validationCustom01" class="col-sm-3 col-form-label">Hourly Rate</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="hourly_rate" value="{{ $editstaff->hourly_rate }}" placeholder="Hourly Rate" class="form-control" for="validationCustom01">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="validationCustom01" class="col-sm-3 col-form-label">Salary</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="salary" value="{{ $editstaff->salary }}" placeholder="Salary" class="form-control" for="validationCustom01">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label required">Role</label>
                                    <div class="col-sm-9">
                                        <select name="role" id="role" class="form-control" id="inputEmail3" required>
                                            <option selected="" disabled="" value="">Select Role</option>
                                            @foreach($role as $rl)
                                                <option value="{{ $rl->role_id }}" {{ $editstaff->role == $rl->role_id ? 'selected="selected"' : '' }}>{{ $rl->name }}</option>
                                           @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label required">Group</label>
                                    <div class="col-sm-9">
                                        <select name="group_id" id="group" class="form-control" required>
                                            <option selected="" disabled="" value="">Select Group</option>
                                            @foreach($groups as $gr)
                                            <option value="{{ $gr->id }}" {{ $editstaff->group_id == $gr->id ? 'selected="selected"' : '' }}>{{ $gr->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-sm-4 col-form-label">Show on dashboard </label>
                                    <div class="col-sm-8">
                                        <input class="form-check-input" type="checkbox" name="is_dashboard" value="1" @if($editstaff->is_dashboard==1) checked @endif>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-sm-4 col-form-label">Show on Ideaboard </label>
                                    <div class="col-sm-8">
                                        <input class="form-check-input" type="checkbox" name="is_ideaboard" value="1" @if($editstaff->is_ideaboard==1) checked @endif>
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
    <style type="text/css">
        .required:after {
            content:" *";
            color: red;
          }
    </style>
    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!-- Select2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script>
        $("#role").select2({
            placeholder: "Select",
            allowClear: true,
        });
        $("#group").select2({
            placeholder: "Select",
            allowClear: true,
        });
    </script>
@endsection