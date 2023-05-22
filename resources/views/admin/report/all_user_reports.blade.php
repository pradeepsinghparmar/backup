@extends('admin.layout')
@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-md-10">
                <h1 class="h3 mb-2 text-gray-800">All Reports</h1>
            </div>
             <div class="col-md-2">
            </div>
       </div>
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="container-fluid"><br>
                <div class="card-body">
                    <form action="{{ route('attendencelist') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="bs-form-wrapper">
                            <div class="input-wrapper">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <input type="date" id="date" name="date"  placeholder="Date" value="{{ $date }}" class="form-control" required>
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="submit" class="btn btn-primary" value="Search">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
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
                                        @if($data->logout_time=='00:00:00')
                                            @if(App\Models\Userpermission::get_permission('leave_list','is_edit'))
                                                <td><input type="time" onchange="logouttime({{ $data->id}})" id="time_{{$data->id}}" name="time" value=""></td>
                                            @else
                                                <td>{{ date('H:i:a',strtotime($data->logout_time)) }}</td>
                                            @endif
                                        @else
                                            <td>{{ date('H:i:a',strtotime($data->logout_time)) }}</td>
                                        @endif
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
        <style type="text/css">
            .dt-buttons{
                display: none;
            }
            .dataTables_filter{
                display: none;
            }
        </style>
        <script src="{{ asset('admin/assets/vendor/jquery/jquery.min.js') }}"></script>
        <script type="text/javascript">
            function logouttime(id) {
                var _token = $('input[name="_token"]').val();
                var date=$('#date').val();
                var time = $('#time_'+id).val();
                $.ajax({
                    url: "{{ route('addlogouttime') }}",
                    method: 'POST',
                    data:{ id:id,time:time,_token:_token},
                    success: function(response) {
                        location.reload();
                    }
                });
            }
        </script>
@endsection