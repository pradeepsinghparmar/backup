<link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css" rel="stylesheet">
        @foreach($tt['gd'] as $g)
        <?php $h = 0;?>
                <div class="row">
                <div class="col-md-11">
                    <div class="container-fluid"><br>
                        <div class="_icon-box">
                            <div class="card-header" style="background: #0c6ead;">
                                <h6 class="m-0 font-weight-bold" style=" color: white;">ClinDCast Team Time Management ({{$g["name"]}})</h6>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="export_example" style="width: 100%;">
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
                @foreach($g['list'] as $key => $data)
                    <?php $h++; ?>
                    <tr>
                        <td>{{ $h }}</td>
                        <td>{{ $data['user_id'] }}</td>
                        <td>{{ $data['login_time1'] }}</td>
                        <td>{{ $data['break_in_time1'] }}</td>
                        <td>{{  $data['break_out_time1'] }}</td>
                        <td>{{  $data['logout_time1'] }}</td>
                        <td>{{  $data['total_hours'] }}</td>
                        <td>
                        @if($data['is_leave'])
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
                        <td>{{$data['t_break']}}</td>
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
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script>
      $(document).ready(function() {
        $({{export_example').DataTable( {
            orhder: [[ 0, "asc" ]],
            dom: 'Bfrtip',
            buttons: [
                'copyHtml5',
                'excelHtml5',
                // 'csvHtml5',
                // 'pdfHtml5',
                 'print'
            ],
            alengthChange: true,
            alengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
            pageLength: 31,
        });
    });
</script>