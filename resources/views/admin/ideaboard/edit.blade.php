@extends('admin.layout')
@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-md-10">
                <h1 class="h3 mb-2 text-gray-800">Edit</h1>
            </div>
            <div class="col-md-2">
                <a href="{{ route('assigntask_list') }}" class="btn btn-dark btn-icon-split">
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
                            <form action="{{ route('update_assigntask',$editstaff->id) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label">Task</label>
                                    <div class="col-sm-9">
                                        <select name="task_id" id="task_id" class="form-control" >
                                            <option selected="" value="">Select</option>
                                            @foreach($task as $rl)
                                            <option value="{{ $rl->id }}" @if($rl->id==$editstaff->task_id) selected @endif>{{ $rl->task }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label">Date</label>
                                    <div class="col-sm-9">
                                        <input type="date" name="date" value="{{ $editstaff->date }}" placeholder="Date" class="form-control">
                                    </div>
                                </div>
                                @php $user_id_arr = explode(',', $editstaff->user_id); @endphp
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label required">Assign To</label>
                                    <div class="col-sm-9">
                                        <select name="user_id[]" id="user_id" multiple class="form-control"  required>
                                            @foreach($employee as $rl)
                                            <option value="{{ $rl->id }}" @if(in_array($rl->id, $user_id_arr)) selected @endif>{{ $rl->name }} {{ $rl->last_name }}</option>
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
    <style type="text/css">
        .required:after {
            content:" *";
            color: red;
          }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script>
        $("#task_id").select2({
          placeholder: "Select",
          allowClear: true,
      });
      $("#user_id").select2({
          allowClear: true,
      });
    </script>
@endsection