@extends('admin.layout')
@section('content')

    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-md-10">
               <h1 class="h3 mb-2 text-gray-800">Assign Task</h1>
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
                            <form action="{{ route('store_assigntask') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label">Task</label>
                                    <div class="col-sm-9">
                                        <select name="task_id[]" id="task_id" multiple class="form-control" >
                                            @foreach($task as $rl)
                                            <option value="{{ $rl->id }}">{{ $rl->task }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label required">Date</label>
                                    <div class="col-sm-9">
                                        <input type="date" name="date"  placeholder="Date" class="form-control" value="{{ date('Y-m-d')}}" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label required">Name</label>
                                    <div class="col-sm-9">
                                        <select name="user_id[]" id="user_id" multiple class="form-control"  required>
                                            @foreach($employee as $rl)
                                            <option value="{{ $rl->id }}">{{ $rl->name }} {{ $rl->last_name }}</option>
                                            @endforeach
                                        </select>
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
    <!-- Select2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script>
        $("#task_id").select2({
            placeholder: "Select",
            allowClear: true,
        });
        $("#user_id").select2({
          placeholder: "Select",
          allowClear: true,
      });
    </script>
@endsection