@extends('admin.layout1')
@section('content')
<?php
$holidays = array();
$i = 0;
foreach($data['holidays'] as $row1){
    $holidays[$i] = $row1->date;
}
?>
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-md-10">
                <h1 class="h3 mb-2 text-gray-800">Monthly Attendence Report ({{$data['monthName']}} {{$data['y_day']}})</h1>
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
        <table class="export_example">
            <thead>
                <tr>
                    <th>Emp Name</th>
                    @foreach($data['months'] as $m)
                        <th>{{ $m->day }}</th>
                    @endforeach  
                    <th>Total Present</th>
                    <th>Leave</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['emplist'] as $attend)
                    <tr>
                        <td>
                            @foreach($data['users'] as $us)
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
                        foreach($userlist1 as $att){
                            $leaves = App\Models\Leave::select('*')->where('user_id', $attend->employee_id)->whereDate('from' ,'<=', $make_date)->whereDate('to', '>=', $make_date)->count();
                            if($att->date == $make_date){
                                $set_attendance_for_day=true;?>
                                <?php $t= App\Http\Controllers\Admin\ProfileController::secondsToWords1($att->total_hours);
                                    if($t>5){
                                        echo '<td><b>'.$t.'</b></td>';
                                    }else{
                                       echo '<td style="background-color: yellow;"><b>'.$t.'</b></td>'; 
                                    }
                                     ?>     
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
                @endforeach
            </tbody>
        </table>
        <style type="text/css">
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
@endsection