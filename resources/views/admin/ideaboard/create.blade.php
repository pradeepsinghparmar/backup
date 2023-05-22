@extends('admin.layout')
@section('content')

    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-md-10">
               <h1 class="h3 mb-2 text-gray-800">Add Project</h1>
            </div>
            <div class="col-md-2">
                <a href="{{ route('project_list') }}" class="btn btn-dark btn-icon-split">
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
                            <form action="{{ route('store_project') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <!-- <div class="row mb-3">
                                    <label for="validationCustom01" class="col-sm-3 col-form-label">Project Id</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="project_id"  placeholder="Project Id" class="form-control" for="validationCustom01" required>
                                    </div>
                                </div> -->
                                <div class="row mb-3">
                                    <label for="validationCustom01" class="col-sm-3 col-form-label required">Project Name</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="name"  placeholder="Project Name" class="form-control" for="validationCustom01" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="validationCustom02" class="col-sm-3 col-form-label">Description</label>
                                    <div class="col-sm-9">
                                        <input type="description" name="description"  placeholder="description" class="form-control" id="validationCustom02">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="validationCustom01" class="col-sm-3 col-form-label">Customer</label>
                                    <div class="col-sm-9">
                                        <select name="customer_id" id="customer_id" class="form-control" for="validationCustom04">
                                            <option selected="" value="">Select</option>
                                            @foreach($customer as $rl)
                                            <option value="{{ $rl->id }}">{{ $rl->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="validationCustom01" class="col-sm-3 col-form-label">Vendor</label>
                                    <div class="col-sm-9">
                                        <select name="vendor_id" id="vendor_id" class="form-control" for="validationCustom04">
                                            <option selected="" disabled="" value="">Select</option>
                                            @foreach($vendor as $ve)
                                            <option value="{{ $ve->id }}">{{ $ve->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="validationCustom01" class="col-sm-3 col-form-label required">Assing To</label>
                                    <div class="col-sm-9">
                                        <select name="user_id[]" id="user_id" multiple class="form-control" for="validationCustom04" required>
                                            @foreach($employee as $rl)
                                            <option value="{{ $rl->id }}">{{ $rl->name }} {{ $rl->last_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <!-- <div class="row mb-3">
                                    <label for="validationCustom04" class="col-sm-3 col-form-label required">Status</label>
                                    <div class="col-sm-9">
                                        <select name="status"  class="form-control" for="validationCustom04" required>
                                            <option selected="" disabled="" value="">Select</option>
                                            <option value="1">Active</option>
                                            <option value="0">Deactive</option>
                                        </select>
                                    </div>
                                </div> -->
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

    <!-- Select2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script>
        $("#vendor_id").select2({
            placeholder: "Select",
            allowClear: true,
        });
        $("#customer_id").select2({
            placeholder: "Select",
            allowClear: true,
        });
        $("#user_id").select2({
          placeholder: "Select",
          allowClear: true,
      });
    </script>
@endsection