@extends('admin.layout')
@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-md-10">
                <h1 class="h3 mb-2 text-gray-800">Edit Task</h1>
            </div>
            <div class="col-md-2">
                <a href="{{ route('task_list') }}" class="btn btn-dark btn-icon-split">
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
                            <form action="{{ route('update_task',$editstaff->id) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <!-- <div class="row mb-3">
                                    <label for="validationCustom01" class="col-sm-3 col-form-label">Task Id</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="task_id" value="{{ $editstaff->task_id }}" placeholder="Task Id" class="form-control" for="validationCustom01" required>
                                    </div>
                                </div> -->
                                <div class="row mb-3">
                                    <label for="validationCustom01" class="col-sm-3 col-form-label required">Name</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="name" value="{{ $editstaff->name }}" placeholder="Name" class="form-control" for="validationCustom01" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="validationCustom01" class="col-sm-3 col-form-label required">Project</label>
                                    <div class="col-sm-9">
                                        <select name="project_id" id="project_id" class="form-control" for="validationCustom04" required>
                                            <option selected="" disabled="" value="">Select</option>
                                            @foreach($project as $pr)
                                            <option value="{{ $pr->id }}" @if($pr->id==$editstaff->project_id) selected @endif>{{ $pr->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Description</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="description" value="{{ $editstaff->description }}" placeholder="Description" class="form-control" id="description">
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
        $("#project_id").select2({
          placeholder: "Select",
          allowClear: true,
      });
    </script>
@endsection