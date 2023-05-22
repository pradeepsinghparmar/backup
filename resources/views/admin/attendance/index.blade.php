@extends('admin.layout')
@section('content')
<style>
.punch-hours{
    align-items: center;
    border: 5px solid #1d82f5;
    border-radius: 50%;
    display: flex;
    font-size: 18px;
    height: 120px;
    justify-content: center;
    margin: 0 auto;
    width: 120px;
}
</style>
<style>
.attandance-list-table table.dataTable thead th, .attandance-list-table table.dataTable thead td {
    padding: 10px 0 !important;
}
.attandance-list-table table {
    display: block;
    overflow: auto;
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

.box {
  float: left;
  height: 20px;
  width: 20px;
  margin-bottom: 15px;
  border: 1px solid black;
  clear: both;
}

.red {
  background-color: red;
  border: 2px solid black;
  border-radius: 4px;
  cursor: pointer;
}

.green {
  background-color: #4bea42eb;
  border: 2px solid black;
  border-radius: 4px;
  cursor: pointer;
}

.yellow {
  background-color: yellow;
  border: 2px solid black;
  border-radius: 4px;
  cursor: pointer;
}

.leave {
  background-color: #ff008b6b;
  border: 2px solid black;
  border-radius: 4px;
  cursor: pointer;
}

.weakend {
  background-color: green;
  border: 2px solid black;
  border-radius: 4px;
  cursor: pointer;
}

.present {
  background-color: transparent;
  border: 2px solid black;
  border-radius: 4px;
  cursor: pointer;
}
</style>
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-md-9">
               <h1 class="h3 mb-2 text-gray-800">Monthly Attendance Report ({{$monthName}} {{$y_day}})</h1>
            </div>
            <div class="col-md-3">
            </div>
        </div>
        <!-- DataTales Example -->
        <div class="card shadow mb-4 attandance-list-table">
            <div class="row mt-3">
                <div class="col-md-12">
                    <form>
                        @csrf
                        <div class="col-sm-3" style="float: left;">
                            <select name="emp_id" class="form-control" id="inputEmail3">
                               <option value="">Select Employee</option>
                                @foreach($users as $hi)
                                <option value="{{ $hi->id }}" {{ $empid == $hi->id ? 'selected="selected"' : '' }}>{{ $hi->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-2" style="float: left;">
                            <select name="month" class="form-control" id="inputEmail3" required>
                                @if(date("m")>=1)
                                <option value="01" {{ $m_day == '01' ? 'selected="selected"' : '' }}>Jan</option>
                                @endif
                                @if(date("m")>=2)
                                <option value="02" {{ $m_day == '02' ? 'selected="selected"' : '' }}>Feb</option>
                                @endif
                                @if(date("m")>=3)
                                <option value="03" {{ $m_day == '03' ? 'selected="selected"' : '' }}>March</option>
                                @endif
                                @if(date("m")>=4)
                                <option value="04" {{ $m_day == '04' ? 'selected="selected"' : '' }}>April</option>
                                @endif
                                @if(date("m")>=5)
                                <option value="05" {{ $m_day == '05' ? 'selected="selected"' : '' }}>May</option>
                                @endif
                                @if(date("m")>=6)
                                <option value="06" {{ $m_day == '06' ? 'selected="selected"' : '' }}>Jun</option>
                                @endif
                                @if(date("m")>=7)
                                <option value="07" {{ $m_day == '07' ? 'selected="selected"' : '' }}>July</option>
                                @endif
                                @if(date("m")>=8)
                                <option value="08" {{ $m_day == '08' ? 'selected="selected"' : '' }}>Aug</option>
                                @endif
                                @if(date("m")>=9)
                                <option value="09" {{ $m_day == '09' ? 'selected="selected"' : '' }}>Sep</option>
                                @endif
                                @if(date("m")>=10)
                                <option value="10" {{ $m_day == '10' ? 'selected="selected"' : '' }}>Oct</option>
                                @endif
                                @if(date("m")>=11)
                                <option value="11" {{ $m_day == '11' ? 'selected="selected"' : '' }}>Nov</option>
                                @endif
                                @if(date("m")>=12)
                                <option value="12" {{ $m_day == '12' ? 'selected="selected"' : '' }}>Dec</option>
                                @endif
                            </select>

                        </div>
                        <div class="col-sm-2" style="float: left;">
                            <button class="btn btn-primary">Search</button>
                        </div>
                    </form>  
                    <form action="{{ route('createMonthlyAttendencePDF') }}" method="post" enctype="multipart/form-data">
                        @csrf
                            <input type="hidden" name="emp_id" value="{{$empid}}">
                            <input type="hidden" name="month" value="{{$m_day}}">
                        <div class="col-sm-4" style="float: left;">
                            <button class="btn btn-primary">Export to PDF</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-12">
                    <table style="padding-left: 20px; height:auto;">
                        <tr>
                            <td><div class='box present'></div> &nbsp;&nbsp;<b> Present</b></td>
                            <td><div class='box red'></div> &nbsp;&nbsp;<b> Absent</b></td>
                            <td><div class='box yellow'></div>&nbsp;&nbsp;<b>Halfday</b></td>
                            <td><div class='box leave'></div>&nbsp;&nbsp;<b>Leave</b></td>
                            <td><div class='box weakend'></div>&nbsp;&nbsp;<b>weakend</b></td>
                            <td><div class='box green'></div>&nbsp;&nbsp;<b> Holiday</b></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="export_example">
                        <thead>
                            <tr>
                                <th>Emp Name</th>
                                @foreach($months as $m)
                                    <th>{{ $m->day }}</th>
                                @endforeach  
                                <th>Total Present</th>
                                <th>Leave</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($emplist as $attend)
                            @php
                                $status =  App\Models\User::select('login_status')->where('id', $attend->employee_id)->first()->login_status;
                            @endphp
                            @if($status==1)
                                <tr>
                                    <td>
                                        @foreach($users as $us)
                                            @if($us->id == $attend->employee_id)
                                                    {{ $us->name }}
                                            @endif
                                        @endforeach 
                                    </td>
                                    <?php for($i = 1; $i <= $month_day_count; $i++){
                                    $y = $y_day;
                                    $m = $m_day;
                                    if($i < 10){
                                        $make_date = $y.'-'.$m."-0".$i;
                                    }else{
                                        $make_date = $y.'-'.$m."-".$i;
                                    }
                                    $userlist1 = App\Models\Attendanceday::select('*')->where('employee_id', $attend->employee_id)->where('year', $y_day)->where('month', $m_day)->where('login_time','!=','00:00:00')->where('logout_time','!=','00:00:00')->orderBy('date', 'ASC')->get();

                                    $month_day_attendance1 = $userlist1->count();
                                    $set_attendance_for_day=false;
                                    $leaves = 0;
                                    $leaves = App\Models\Leave::select('*')->where('user_id', $attend->employee_id)->whereDate('from' ,'<=', $make_date)->whereDate('to', '>=', $make_date)->count();
                                    foreach($userlist1 as $att){
                                        if($att->date == $make_date){
                                            $set_attendance_for_day=true;?>
                                            <?php $t= App\Http\Controllers\Admin\ProfileController::secondsToWords1($att->total_hours);
                                                if($t>5){
                                                    echo '<td><b>'.$t.'</b></td>';
                                                }else{
                                                   echo '<td style="background-color: yellow;"><b>'.$t.'</b></td>'; 
                                                }
                                                 ?>
                                            <!-- Modal -->
                                            <div class="modal fade" id="myModal_{{$att->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <!-- Modal content-->
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Attendance Details</h4>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row justify-content-between">
                                                                <div class="col" id="task_div">
                                                                    <div class="row">
                                                                        <div class="col-xl-12 col-md-12 mb-4">
                                                                            <div class="card border-left-success shadow h-100 py-2">
                                                                                <div class="card-body">
                                                                                    <div class="row no-gutters align-items-center">
                                                                                        <div class="col mr-2">
                                                                                            <div class="col-md-4" style="float: left;">
                                                                                                @foreach($users as $us)
                                                                                                    @if($us->id == $attend->employee_id)
                                                                                                        @if(!empty($us->image_url))
                                                                                                            <img class="img-profile" src="{{ $us->image_url }}" style="width: 50px;">
                                                                                                        @else
                                                                                                            <img class="img-profile" src="{{ asset('admin/assets/img/undraw_profile.svg') }}" style="width: 50px;">
                                                                                                        @endif
                                                                                                    @endif
                                                                                                @endforeach 
                                                                                            </div>
                                                                                            <div class="col-md-8" style="float: left;">
                                                                                                <h4><b> 
                                                                                                    @foreach($users as $us)
                                                                                                        @if($us->id == $attend->employee_id)
                                                                                                            {{ $us->name }}
                                                                                                        @endif
                                                                                                    @endforeach
                                                                                                </b></h4>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-auto">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <div class="card bg-white border-0 b-shadow-4">
                                                                                <div class="card-header bg-white border-0 text-capitalize d-flex justify-content-between p-20">
                                                                                    <h4 class="f-18 f-w-500 mb-0">Date - {{date('d-M-Y',strtotime($att->date))}}</h4>
                                                                                </div>
                                                                                &nbsp;&nbsp;&nbsp;<h5>Working From - {{$att->working_from}}</h5>
                                                                                &nbsp;&nbsp;&nbsp;<h5>Clock In Location - {{$att->live_location}}</h5>
                                                                                <div class="card-body ">
                                                                                    <div class="punch-status">
                                                                                        <div class="border rounded p-3 mb-3 bg-light">
                                                                                            <h6 class="f-13">Clock In</h6>
                                                                                            <p class="mb-0">{{ date('H:i A',strtotime($att->clock_in))}}</p>
                                                                                        </div>
                                                                                        <div class="punch-info">
                                                                                            <div class="punch-hours f-13">
                                                                                                <span>
                                                                                                <?php
                                                                                                if($att->clock_out == ""){ 
                                                                                                    $hourss = '0'.' hours';  
                                                                                                }else{
                                                                                                    $time1 = new DateTime($att->clock_in);
                                                                                                    $time2 = new DateTime($att->clock_out);
                                                                                                    $time_diff = $time1->diff($time2);
                                                                                                    $hourss = $time_diff->h.' hours';
                                                                                                }
                                                                                                ?>
                                                                                                {{ $hourss ?? '0' }}</span>
                                                                                            </div>
                                                                                        </div><br>
                                                                                        @if(!empty($att->clock_out_location))
                                                                                            <h5>Clock Out Location - {{$att->clock_out_location}}</h5>
                                                                                        @endif
                                                                                        <div class="border rounded p-3 bg-light">
                                                                                            <h6 class="f-13">Clock Out</h6>
                                                                                            @if($att->status == '1')
                                                                                            <p class="mb-0">00:00:00</p>
                                                                                            @else
                                                                                            <p class="mb-0">{{ date('H:i A',strtotime($att->clock_out))}}</p>
                                                                                            @endif
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>       
                                        <?php } ?>
                                    <?php } ?>
                                    <?php if (!$set_attendance_for_day) { 
                                        $isweekend = App\Http\Controllers\Admin\ProfileController::checkweekend($make_date);
                                            if($isweekend){
                                                echo '<td style="background-color: green;"></td>';
                                            }else{
                                                if(in_array($make_date , $holidays)){
                                                    echo '<td td style="background-color: #4bea42eb;"></td>';
                                                }elseif($leaves>0){
                                                    echo '<td td style="background-color: #ff008b6b;"></td>';
                                                }else{
                                                    echo '<td td style="background-color: red;"><b></b></td>';
                                                }
                                            }
                                        }
                                    }?>

                                    <td><div class="btn btn-primary btn-sm rounded-pill"> {{$month_day_attendance1}}/{{$month_day_count}}</div></td>
                                    <?php 
                                    $month_array = App\Http\Controllers\Admin\ProfileController::getStartAndEndDateofmonth($m_day,date("Y"));
                                    $total = App\Models\Leave::where('user_id',$attend->employee_id)->whereBetween('from', [$month_array['month_start'], $month_array['month_end']])->sum('duration'); ?>
                                    <td><div class="btn btn-primary btn-sm rounded-pill">{{$total}}</div></td>
                                </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection