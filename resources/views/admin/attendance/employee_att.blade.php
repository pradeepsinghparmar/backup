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
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="row">
        <div class="col-md-9">
            <h1 class="h3 mb-2 text-gray-800">All Attendance List</h1>
        </div>
        <div class="col-md-3">
            <a href="{{ route('employee_hour_att') }}" class="btn btn-primary btn-icon-split">
                <span class="text">Attendance By Hour</span>
            </a>
        </div>
    </div>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="row mt-3">
            <div class="col-md-12"> 
                <center><h4></h4></center>
                <form>

                        <div class="col-sm-2" style="float: left;">
                            <select name="month" class="form-control" id="inputEmail3" required>
                                <option value="01" {{ $m_day == '01' ? 'selected="selected"' : '' }}>Jan</option>
                                <option value="02" {{ $m_day == '02' ? 'selected="selected"' : '' }}>Feb</option>
                                <option value="03" {{ $m_day == '03' ? 'selected="selected"' : '' }}>March</option>
                                <option value="04" {{ $m_day == '04' ? 'selected="selected"' : '' }}>April</option>
                                <option value="05" {{ $m_day == '05' ? 'selected="selected"' : '' }}>May</option>
                                <option value="06" {{ $m_day == '06' ? 'selected="selected"' : '' }}>Jun</option>
                                <option value="07" {{ $m_day == '07' ? 'selected="selected"' : '' }}>July</option>
                                <option value="08" {{ $m_day == '08' ? 'selected="selected"' : '' }}>Aug</option>
                                <option value="09" {{ $m_day == '09' ? 'selected="selected"' : '' }}>Sep</option>
                                <option value="10" {{ $m_day == '10' ? 'selected="selected"' : '' }}>Oct</option>
                                <option value="11" {{ $m_day == '11' ? 'selected="selected"' : '' }}>Nov</option>
                                <option value="12" {{ $m_day == '12' ? 'selected="selected"' : '' }}>Dec</option>
                            </select>
                        </div>
                    
                        <div class="col-sm-2" style="float: left;">
                            <select name="year" class="form-control" id="inputEmail3" required>
                                <option value="2020" {{ $y_day == '2020' ? 'selected="selected"' : '' }}>2020</option>
                                <option value="2021" {{ $y_day == '2021' ? 'selected="selected"' : '' }}>2021</option>
                                <option value="2022" {{ $y_day == '2022' ? 'selected="selected"' : '' }}>2022</option>
                            </select>
                        </div>
                        
                       
                    
                    <div class="col-sm-4" style="float: left;">
                   
                          <button class="btn btn-primary">Search</button>
                    </div>
                </form>
            </div>
        </div>
         @if(session('success'))
            <div class="alert alert-custom alert-indicator-top indicator-success" role="alert">
                <div class="alert-content">
                    <span class="alert-title">Success!</span>
                    <span class="alert-text"> {{ session('success') }}</span>
                </div>
            </div>
            @endif
            @if(session('error'))
            <div class="alert alert-custom alert-indicator-top indicator-danger" role="alert">
                <div class="alert-content">
                    <span class="alert-title">Error!</span>
                    <span class="alert-text"> {{ session('error') }}</span>
                </div>
            </div>
               
            @endif
            <div class="card-body">
                <div class="table-responsive">
                    <table class="export_example">
                        <thead>
                            <tr>
                                <th>Name</th>
                               @foreach($months as $m)
                                    <th>{{ $m->day }}</th>
                               @endforeach  
                                <th>Total Present</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <a href="{{ route('employee_att_details',Auth::user()->id) }} ">{{Auth::user()->name}}</a>
                                </td>
                                @foreach($months as $m)
                                    @php
                                        $mtoday = $m->day;
                                    @endphp
                                    @if(!empty($json_result))
                                        @php  $tody = json_decode($json_result); @endphp
                                    @if (in_array($mtoday, $tody))
                                     <td><a href="#" data-toggle="modal" data-target="#myModal_{{$mtoday}}"><b>P</b></a></td>
                                     <!-- Modal -->
                                    <div class="modal fade" id="myModal_{{$mtoday}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                            @php
                                                            $userlist = App\Models\Attendance::select('*')->where('employee_id', Auth::user()->id)->where('day', $mtoday)->where('year', $y_day)->where('month', $m_day)->first();
                                                            @endphp
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="card bg-white border-0 b-shadow-4">
                                                                        <div class="card-header bg-white border-0 text-capitalize d-flex justify-content-between p-20">
                                                                            <center><h4 class="f-18 f-w-500 mb-0">Date - {{date('d-M-Y',strtotime($userlist->date))}}</h4></center>
                                                                        </div>
                                                                        &nbsp;&nbsp;&nbsp;<h5>Working From - {{$userlist->working_from}}</h5>
                                                                        &nbsp;&nbsp;&nbsp;<h5>Clock In Location - {{$userlist->live_location}}</h5>
                                                                        <div class="card-body ">
                                                                            <div class="punch-status">
                                                                                <div class="border rounded p-3 mb-3 bg-light">
                                                                                    <h6 class="f-13">Clock In</h6>
                                                                                        <p class="mb-0">{{ date('H:i A',strtotime($userlist->clock_in))}}</p>
                                                                                </div>
                                                                                <div class="punch-info">
                                                                                    <div class="punch-hours f-13">
                                                                                        <span>
                                                                                            <?php
                                                                                            if($userlist->clock_out == ""){ 
                                                                                                $hourss = '0'.' hours';  
                                                                                            }else{
                                                                                                $time1 = new DateTime($userlist->clock_in);
                                                                                                $time2 = new DateTime($userlist->clock_out);
                                                                                                $time_diff = $time1->diff($time2);
                                                                                                $hourss = $time_diff->h.' hours';
                                                                                            }
                                                                                            ?>
                                                                                            {{ $hourss ?? '0' }}
                                                                                        </span>
                                                                                    </div>
                                                                                </div><br>
                                                                                @if(!empty($userlist->clock_out_location))
                                                                                    <h5>Clock Out Location - {{$userlist->clock_out_location}}</h5>
                                                                                @endif
                                                                                <div class="border rounded p-3 bg-light">
                                                                                    <h6 class="f-13">Clock Out</h6>
                                                                                    @if($userlist->status == '1')
                                                                                    <p class="mb-0">00:00:00</p>
                                                                                    @else
                                                                                    <p class="mb-0">{{ date('H:i A',strtotime($userlist->clock_out))}}</p>
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
                                                    @else
                                                      <td><b>A</b></td>
                                                    @endif
                                                  @endif  
                                                  
                                           
                                                @endforeach
                                            
                                            @if(!empty($month_day_attendance))
                                            <td><div class="btn btn-primary btn-sm rounded-pill"> {{ $month_day_attendance}}/{{$month_day_count}}</div></td>
                                            @endif

                                          
                                                  
                                                </tr>
              
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
 

@endsection