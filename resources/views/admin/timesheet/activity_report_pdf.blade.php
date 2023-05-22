@extends('admin.layout1')
@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-md-10">
                <h1 class="h3 mb-2 text-gray-800">Daily Task Details Report</h1>
            </div>
       </div>
        <table class="export_example">
            <thead>
                <tr>
                    <th style="width:100px;">Date</th>
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