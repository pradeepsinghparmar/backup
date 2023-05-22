@extends('admin.layout')
@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-md-10">
                <h1 class="h3 mb-2 text-gray-800">Daily Task Details Report</h1>
            </div>
             <div class="col-md-2">
                <!-- <a class="btn btn-primary" href="{{ route('createPDF') }}">Export to PDF</a> -->
            </div>
       </div>
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="container-fluid"><br>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form action="{{ route('activity_reports') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="bs-form-wrapper">
                                    <div class="input-wrapper">
                                        <div class="row">
                                            <div class="col-sm-5">
                                                <div class="row">
                                                    <label class="col-sm-3">From Date</label>
                                                    <div class="col-sm-3">
                                                        <input type="date" name="from" value="{{ $from }}" placeholder="Date" class="form-control">
                                                    </div>
                                                    <label class="col-sm-2">To Date</label>
                                                    <div class="col-sm-3">
                                                        <input type="date" name="to" value="{{ $to }}" placeholder="Date" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-5">
                                                <div class="row">
                                                    <label class="col-sm-2">Name</label>
                                                    <div class="col-sm-4">
                                                        <select name="user_id[]" id="user_id" class="form-control" multiple>
                                                           @foreach($users as $rl)
                                                                <option value="{{ $rl->id }}" @if(in_array($rl->id, $user_ids)) Selected @endif>{{ $rl->name }} {{ $rl->last_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <label class="col-sm-2">Project</label>
                                                    <div class="col-sm-4">
                                                       <select name="project_id" id="project_id" class="form-control">
                                                            <option selected="" disabled="" value="">Select</option>
                                                            @foreach($projects as $pr)
                                                                <option value="{{ $pr->id }}" @if($pr->id == $project_id) Selected @endif>{{ $pr->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <input type="submit" class="btn btn-primary" value="Search">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <br>
                    <form action="{{ route('createPDF') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div style="display:none;">
                        <input type="date" name="from1" value="{{ $from }}" placeholder="Date" class="form-control">
                        <input type="date" name="to1" value="{{ $to }}" placeholder="Date" class="form-control">
                        <select name="user_id1[]" class="form-control" multiple>
                           @foreach($users as $rl)
                                <option value="{{ $rl->id }}" @if(in_array($rl->id, $user_ids)) Selected @endif>{{ $rl->name }} {{ $rl->last_name }}</option>
                            @endforeach
                        </select>
                       <select name="project_id1" class="form-control">
                            <option selected="" disabled="" value="">Select</option>
                            @foreach($projects as $pr)
                                <option value="{{ $pr->id }}" @if($pr->id== $project_id) Selected @endif>{{ $pr->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <input type="submit" class="btn btn-primary" value="Export to PDF">
                </form>
                    <br>
                    <div class="table-responsive">
                         <table class="export_example">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Name</th>
                                    <th>Project-Task</th>
                                    <th>Activity Hour</th>
                                    <th>Count</th>
                                    <th>Comments</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($timesheets as $key => $timesheet)
                                    <tr>
                                        <td>{{ date("D M d ", strtotime($timesheet['date'])) }}</td>
                                        <td>{{ $timesheet['name'] }}</td>
                                        <td>{{ $timesheet['project'] }}</td>
                                        <td>{{ $timesheet['hours'] }}</td>
                                        <td>{{ $timesheet['count'] }}</td>
                                        <td>{{ $timesheet['comments'] }}</td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <style type="text/css">
            #DataTables_Table_0_filter{
            float: left;
            }
            .dt-buttons {
                display: none;
            }

            .dataTables_filter{
                display: none;
            }
            .export_example{
                border: 2px solid #c3c5e0;
            }
        </style>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
        <script>
            $("#user_id").select2({
              placeholder: "Select",
              allowClear: true,
          });
            $("#project_id").select2({
              placeholder: "Select",
              allowClear: true,
          });
        </script>
@endsection