@extends('admin.layout')
@section('content')
    <div class="container-fluid _dashboard-style">
        <div class="d-sm-flex align-items-center justify-content-between _employee-deshboard _title-style">
            <div class="col-md-4">
                <h1 class="h3 mb-0 text-gray-800">Welcome @if(Auth::user()->name) {{ Auth::user()->name }} @endif @if(Auth::user()->last_name) {{ Auth::user()->last_name }} @endif </h1>
            </div>
            <div class="col-md-6" id="clock">
                <b style="color: #000 !important; font-size: 20px;"> @php echo (date("l M d , Y", strtotime(date("Y/m/d"))).' '.date('h:i:s a').' '.date_default_timezone_get() );  @endphp</b>
            </div>
        </div>
    </div>
    <div id="team">
    @foreach($gd as $g)
    <div class="row" @if($g['id']==Auth::user()->group_id) style="display:block" @elseif(App\Models\Permission::admin_permission('admin_dashboard')) style="display:block") @else style="display:none" @endif>
        <div class="col-md-11">
            <div class="container-fluid"><br>
                <div class="_icon-box">
                    <div class="card-header" style="background: #0c6ead;">
                        <h6 class="m-0 font-weight-bold" style=" color: white;">ClinDCast Team Time Management ({{ $g['name']}})</h6>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="export_example">
                            <thead>
                                <tr>
                                    <th>S.No.</th>
                                    <th>User</th>
                                    <th>Login time</th>
                                    <th>Break Start</th>
                                    <th>Break End</th>
                                    <th>Logout Time</th>
                                    <th>Total Working Time</th>
                                    <th>Status</th>
                                    <th>Total Break Time</th>
                                </tr>
                            </thead>
                            <tbody id="myteam">
                                @php $i = 0;@endphp
                                @foreach($g['list'] as $key => $data)
                                    @php $i++;@endphp
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $data['user_id'] }}</td>
                                        <td>{{ $data['login_time1'] }}</td>
                                        <td>{{ $data['break_in_time1'] }}</td>
                                        <td>{{ $data['break_out_time1'] }}</td>
                                        <td>{{ $data['logout_time1'] }}</td>
                                        <td></td>
                                        <td>@if($data['is_leave'])
                                            <span class="badge bg-light-danger text-danger rounded-pill" style="background: #ffba00 !important;">On Leave</span>
                                            @elseif($data['is_logout1']) 
                                            <span class="badge bg-light-danger text-danger rounded-pill">Logged out</span>
                                            @elseif($data['is_breakout1']) 
                                            <span class="badge bg-light-success text-success rounded-pill">Online</span>
                                            @elseif($data['is_break1']) 
                                            <span class="badge bg-light-danger text-danger rounded-pill" style="background: #ffba00 !important;">On Break</span>
                                            @elseif($data['is_login1']) 
                                            <span class="badge bg-light-success text-success rounded-pill">Online</span>
                                            @else 
                                            <span class="badge bg-light-danger text-danger rounded-pill">Yet To Join</span>
                                            @endif
                                        </td>
                                         <td></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    </div>
    {{ csrf_field() }}
    <style>
        .dash{
            color: #fff;
            padding: 10px 20px 10px 20px;
            background-color: #00b050;
            border-radius: 10px;
        }
        .dash1{
            color: #fff;
            padding: 10px 20px 10px 20px;
            background-color: #0b0c0b;
            border-radius: 10px;
        }
        .entry{
            color: #fff !important;
            background-color: #007bff !important;
            padding: 10px 40px 10px 40px !important;
        }
        .entry1{
            color: #fff !important;
            background-color: #ff6f00 !important;
            padding: 10px 40px 10px 40px !important;
        }

        #DataTables_Table_0_filter{
            display: none;
        }
        .dt-buttons{
            display: none;
        }
        .export_example{
            border: 2px solid #c3c5e0;
        }

        @media only screen and (min-width:1281px) and (max-width:1536px){
            .entry{
                color: #fff !important;
                background-color: #007bff !important;
                padding: 10px 15px 10px 15px !important;
            }
        }

        @media only screen and (min-width:1225px) and (max-width:1280px){
            .entry{
                color: #fff !important;
                background-color: #007bff !important;
                padding: 10px 15px 10px 15px !important;
            }
        }

        @media only screen and (min-width:769px) and (max-width:1224px){
            .entry{
                color: #fff !important;
                background-color: #007bff !important;
                padding: 10px 15px 10px 15px !important;
            }
        }

        @media only screen and (min-width:481px) and (max-width:768px){

        }

        @media only screen and (min-width:320px) and (max-width:480px){

        }

        @media only screen and (min-width:279px) and (max-width:319px){

        }

    </style>
    <script src="{{ asset('admin/assets/vendor/jquery/jquery.min.js') }}"></script>
    <script type="text/javascript">
        jQuery(document).ready(function($){
            setInterval(timestamp, 1000);
            var interval = 1000 * 60 * 1;
            setInterval(myteam, interval);
        });

        function timestamp() {
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: "{{ route('clock') }}",
                method: 'POST',
                data:{ _token:_token},
                success: function(response) {
                    $('#clock').html(response);
                }
            });
        }

        function myteam() {
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: "{{ route('myteam') }}",
                method: 'POST',
                data:{ _token:_token},
                success: function(response) {
                    $('#team').html(response.table);
                }
            });
        }
    </script>
@endsection