@extends('admin.layout')
@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-md-10">
                <h1 class="h3 mb-2 text-gray-800">My Team Time</h1>
            </div>
             <div class="col-md-2">
            </div>
       </div>
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <!--<div class="card-header py-3">-->
            <!--    <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>-->
            <!--</div>-->
            <div class="container-fluid"><br>
                <div class="card-body">
                    <div class="table-responsive">
                         <table class="export_example">
                            <thead>
                                <tr>
                                    <th>S.No.</th>
                                    <th>Name</th>
                                    <th>Date</th>
                                    <th>Login Time</th>
                                    <th>Logout Time</th>
                                    <th>Total Break time</th>
                                    <th>Total Hours</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i = 0;@endphp
                                @foreach($data as $key => $data)
                                    @php $i++;@endphp
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>
                                            @foreach($user as $us)
                                                @if($us->id == $data->employee_id) {{ $us->name }} {{ $us->last_name }} @endif 
                                            @endforeach
                                        </td>
                                        <td>{{ date("l M d , Y", strtotime($data->date)) }}</td>
                                        <td>{{ date('H:i:a',strtotime($data->login_time)) }}</td>
                                        <td>{{ date('H:i:a',strtotime($data->logout_time)) }}</td>
                                        <td>{{ gmdate("H:i:s",$data->total_break_time) }}</td>
                                        <td>{{ gmdate("H:i:s",$data->total_hours) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
@endsection