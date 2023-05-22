@extends('admin.layout')
@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-md-10">
               <h1 class="h3 mb-2 text-gray-800">Add Employee</h1>
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
                @if(session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('error') }}
                    </div>
                @endif
                <div class="row">
                    <div class="col-md-12">         
                        <div class="col-md-3">
                        </div>            
                        <div class="col-md-9">                          
                            <form action="{{ route('store_employee') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row mb-3">
                                    <label for="validationCustom01" class="col-sm-3 col-form-label required">First Name</label>
                                    <div class="col-sm-3">
                                        <input type="text" name="name"  placeholder="First Name" class="form-control" for="validationCustom01" required>
                                    </div>

                                    <label for="validationCustom01" class="col-sm-3 col-form-label required">Last Name</label>
                                    <div class="col-sm-3">
                                        <input type="text" name="last_name"  placeholder="Last Name" class="form-control" for="validationCustom01" required>
                                    </div>

                                </div>
                                <!-- <div class="row mb-3">
                                    <label for="validationCustom01" class="col-sm-3 col-form-label">Last Name</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="last_name"  placeholder="Last Name" class="form-control" for="validationCustom01" required>
                                    </div>
                                </div> -->
                                <div class="row mb-3">
                                    <label for="validationCustom02" class="col-sm-3 col-form-label required">Email</label>
                                    <div class="col-sm-9">
                                        <input type="email" name="email"  placeholder="Email" class="form-control" id="validationCustom02" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label required">Mobile</label>
                                    <div class="col-sm-2">
                                        <select name="country_code" class="form-control required" id="inputEmail3" required>
                                           <option value="">Select</option> 
                                           <option value="1">+1</option>
                                           <option value="91">+91</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-7">
                                        <input type="tel" name="phone"  placeholder="Mobile" class="form-control required" id="phone" maxlength="12" minlength="9" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="validationCustom04" class="col-sm-3 col-form-label required">Employee Type</label>
                                    <div class="col-sm-9">
                                        <select name="employee_type"  class="form-control" for="validationCustom04" required>
                                            <option selected="" disabled="" value="">Select type</option>
                                            <option value="Employee">Employee</option>
                                            <option value="Contractor">Contractor</option>
                                        </select>
                                    </div>
                                </div>
                                 <div class="row mb-3">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label required">Password</label>
                                    <div class="col-sm-9">
                                        <input type="password" name="password"  placeholder="Password" class="form-control" id="inputEmail3" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="validationCustom01" class="col-sm-3 col-form-label">Hourly Rate</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="hourly_rate" placeholder="Hourly Rate" class="form-control" for="validationCustom01">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="validationCustom01" class="col-sm-3 col-form-label">Salary</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="salary" placeholder="Salary" class="form-control" for="validationCustom01">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="validationCustom04" class="col-sm-3 col-form-label required">Role</label>
                                    <div class="col-sm-9">
                                        <select name="role" id="role" class="form-control" for="validationCustom04" required>
                                            <option selected="" disabled="" value="">Select Role</option>
                                            @foreach($role as $rl)
                                            <option value="{{ $rl->role_id }}">{{ $rl->name }}</option>
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
                                            <option value="{{ $gr->id }}">{{ $gr->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-sm-4 col-form-label">Show on desktop </label>
                                    <div class="col-sm-8">
                                        <input class="form-check-input" type="checkbox" name="is_dashboard" value="1">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-sm-4 col-form-label">Show on Ideaboard </label>
                                    <div class="col-sm-8">
                                        <input class="form-check-input" type="checkbox" name="is_ideaboard" value="1">
                                    </div>
                                </div>
                                <input type="submit" class="btn btn-primary" value="Save"> 
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script>
        (function($) {
            $.fn.inputFilter = function(callback, errMsg) {
                return this.on("input keydown keyup mousedown mouseup select contextmenu drop focusout", function(e){
                    if (callback(this.value)) {
                        // Accepted value
                        if (["keydown","mousedown","focusout"].indexOf(e.type) >= 0){
                          $(this).removeClass("input-error");
                          this.setCustomValidity("");
                        }
                        this.oldValue = this.value;
                        this.oldSelectionStart = this.selectionStart;
                        this.oldSelectionEnd = this.selectionEnd;
                    } else if (this.hasOwnProperty("oldValue")) {
                    // Rejected value - restore the previous one
                        $(this).addClass("input-error");
                        this.setCustomValidity(errMsg);
                        this.reportValidity();
                        this.value = this.oldValue;
                        this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
                    } else {
                        // Rejected value - nothing to restore
                        this.value = "";
                    }
                });
            };
        }(jQuery));

        // Install input filters.
        $("#phone").inputFilter(function(value) {
          return /^-?\d*$/.test(value); }, "Must be an integer");
    </script>
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