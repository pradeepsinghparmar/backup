@extends('admin.layout')
@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-md-10">
                <h1 class="h3 mb-2 text-gray-800">My Daily Time</h1>
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
                                    <th>Date</th>
                                    <th>Login Time</th>
                                    <th>Logout Time</th>
                                    <th>Break In</th>
                                    <th>Break Out</th>
                                    <th>Total Time</th>
                                    @if(App\Models\Userpermission::get_permission('reports','is_edit'))
                                        <th>Action</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @php $i = 0;@endphp
                                @foreach($data as $key => $data)
                                    @php $i++;@endphp
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ date("l M d , Y", strtotime($data->date)) }}</td>
                                        <td>{{ date('H:i:a',strtotime($data->login_time)) }}</td>
                                        <td>{{ date('H:i:a',strtotime($data->logout_time)) }}</td>
                                        <td>{{ date('H:i:a',strtotime($data->break_in)) }}</td>
                                        <td>{{ date('H:i:a',strtotime($data->break_out)) }}</td>
                                        <td>{{ gmdate("H:i",$data->total_hours) }}</td>
                                        @if(App\Models\Userpermission::get_permission('reports','is_edit'))
                                            <th>Action</th>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    <style>
    .export_example{
        border: 2px solid #c3c5e0;
    }
    table {
        table-layout:fixed;
        width:99% !important;
    }
    td{
        overflow:hidden;
        text-overflow: ellipsis;
    }
</style>
@endsection