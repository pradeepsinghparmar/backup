@php

use Illuminate\Support\Str;

@endphp
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
                                        <div class="col-md-6">
                                   <h1 class="h3 mb-2 text-gray-800">Employee Attendance</h1>
                                    </div>
                                     <div class="col-md-6">
                                     <a href="{{ route('attendance.index') }}" class="btn btn-dark btn-icon-split">
                                        <span class="text">Back</span>
                                    </a>
                                    <a href="{{ route('employee_calendar_attendance',$employee_id) }}" class="btn btn-primary btn-icon-split">
                                        <span class="text">Attendance By Calendar</span>
                                    </a>
                                     <a href="{{ route('employee_hour_attendance',$employee_id) }}" class="btn btn-primary btn-icon-split">
                                        <span class="text">Attendance By Hour</span>
                                    </a>
                                          
                                    </div>
                   </div>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                         <div class="row">
                                        <div class="col-xl-12 col-md-12 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="col-md-4" style="float: left;">
                                                 @php   $id = Request::segment(3); @endphp
                                               @foreach($users as $us)
                                                        @if($us->id == $id)
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
                                               @php   $id = Request::segment(3); @endphp
                                               @foreach($users as $us)
                                                        @if($us->id == $id)
                                                         {{ $us->name }}
                                                        @endif
                                                    @endforeach </b></h4>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                            </div>
                <div class="row mt-3">
                <div class="col-md-12">                        
                        <div class="col-xl-3 col-md-6 mb-4" style="float: left;">
                            <div class="card border-left-success shadow">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Working Days</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                              @php
                                              if(!empty($holiday_att)){ $h_at =  $holiday_att; }else{ $h_at = '0'; }
                                              @endphp
                                                
                                                 {{ date('t') - $h_at }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-2 col-md-6 mb-4" style="float: left;">
                            <div class="card border-left-success shadow">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Present</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"> @if(!empty($present_att)) {{ $present_att }} @else 0 @endif</div>
                                        </div>
                                         <div class="col-auto">
                                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-2 col-md-6 mb-4" style="float: left;">
                            <div class="card border-left-success shadow">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Late</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">  @if(!empty($late_att)) {{ $late_att }} @else 0 @endif</div>
                                        </div>
                                         <div class="col-auto">
                                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                       
                        <div class="col-xl-2 col-md-6 mb-4" style="float: left;">
                            <div class="card border-left-success shadow">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Absent</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"> 
                                            
                                             @php
                                              if(!empty($holiday_att)){ $h_at =  $holiday_att; }else{ $h_at = '0'; }
                                               $wrkng_day = date('d') - $h_at;
                                               
                                               
                                               if(!empty($present_att)) { $pt = $present_att; }else{ $pt = '0'; }
                                              
                                              $absent_new = $wrkng_day - $pt;
                                              if($absent_new < 0){
                                              $absent_new = 0;
                                              }
                                               
                                              @endphp
                                                
                                                 {{ $absent_new}}
                                            </div>
                                        </div>
                                         <div class="col-auto">
                                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-2 col-md-6 mb-4" style="float: left;">
                            <div class="card border-left-success shadow">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Holidays</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"> @if(!empty($holiday_att)) {{ $holiday_att }} @else 0 @endif</div>
                                        </div>
                                         <div class="col-auto">
                                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                </div>
                        <!--<div class="card-header py-3">-->
                        <!--    <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>-->
                        <!--</div>-->
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="export_example">
                                    <thead>
                                        <tr>
                                             <th>Date</th>
                                                    <th>Status</th>
                                                    <th>Clock In</th>
                                                    <th>Clock Out</th>
                                                    <th>Clock In Location</th>
                                                    <th>Clock Out Location</th>
                                                    <th>Total</th>
                                                    <th>Action</th>
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                        @php $i=0; @endphp
                                         @foreach($emp_att as $key => $customer)
 @php $i++; @endphp
                                                <tr>
                                                   <td>{{ date('d M y',strtotime($customer->date)) }} <br><div class="badge bg-dark text-white rounded-pill" style="color: #fff !important;">{{ date('l',strtotime($customer->date)) }}</div></td>
                                                    
                                                    <td>
                                                        @if($customer->mark_attendance_by == '1')
                                                        <div class="btn btn-primary btn-sm rounded-pill"> Present</div>
                                                       @endif
                                                       </td>
                                                    <td>{{ $customer->clock_in }} &nbsp; @if($customer->late == 'Yes') <i class="fas fa-fw fa-tachometer-alt"></i>&nbsp; Late @endif</td>
                                                     <td>
                                                   @if(!empty($customer->clock_out))        
                                                         {{ $customer->clock_out }}
                                                         @else
                                                         --
                                                         @endif
                                                         </td>
                                                      <td>
                                                          @if(!empty($customer->live_location))
                                                          
                                                          {{ Str::limit($customer->live_location, 20) }}
                                                          @else
                                                          --
                                                          
                                                          @endif
                                                          
                                                          </td>
                                                           <td>
                                                          @if(!empty($customer->clock_out_location))
                                                          
                                                          {{ Str::limit($customer->clock_out_location, 20) }}
                                                          @else
                                                          --
                                                          
                                                          @endif
                                                          
                                                          </td>
                                                    <td> 
                                                    
                                                     <?php
    if($customer->clock_out == ""){ 
      $hourss = '0'.' hours';  
    }else{
   $time1 = new DateTime($customer->clock_in);
    $time2 = new DateTime($customer->clock_out);
    $time_diff = $time1->diff($time2);
    $hourss = $time_diff->h.' hours';
    }
                               ?>
                                                   
                                {{ $hourss ?? '0' }}</td>
                                                    <td>
                                                     
                                                      <a class="btn btn-primary btn-sm"  href="#" data-toggle="modal" data-target="#myModal_{{$customer->id}}" title="View"><i class="fas fa-fw fa-eye"></i></a>  
                                                    </td>
           <div class="modal fade" id="myModal_{{$customer->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
        <div class="col-md-12">
            <div class="card bg-white border-0 b-shadow-4">
            <div class="card-header bg-white border-0 text-capitalize d-flex justify-content-between p-20">
    <center><h4 class="f-18 f-w-500 mb-0">Date - {{date('d-M-Y',strtotime($customer->date))}}</h4></center>
  

            
    
</div>
      &nbsp;&nbsp;&nbsp;<h5>Work From - @if(!empty($customer->working_from)) {{ $customer->working_from}} @else -- @endif</h5>
      &nbsp;&nbsp;&nbsp;<h5>Clock In Location - @if(!empty($customer->live_location)) {{ $customer->live_location}} @else -- @endif</h5>
            <div class="card-body ">
            <div class="punch-status">
                    <div class="border rounded p-3 mb-3 bg-light">
                        <h6 class="f-13">Clock In</h6>
                        <p class="mb-0">{{ date('H:i A',strtotime($customer->clock_in))}}</p>
                    </div>
                    <div class="punch-info">
                        <div class="punch-hours f-13">
                            <span>
                                <?php
    if($customer->clock_out == ""){ 
      $hourss = '0'.' hours';  
    }else{
   $time1 = new DateTime($customer->clock_in);
    $time2 = new DateTime($customer->clock_out);
    $time_diff = $time1->diff($time2);
    $hourss = $time_diff->h.' hours';
    }
                               ?>
                                {{ $hourss ?? '0' }} </span>
                        </div>
                    </div><br>
                     @if(!empty($customer->clock_out_location))
                     <h5>Clock Out Location - {{$customer->clock_out_location}}</h5>
                      @endif
                    <div class="border rounded p-3 bg-light">
                        <h6 class="f-13">Clock Out</h6>
                        @if($customer->status == '1')
                        <p class="mb-0">00:00:00</p>
                        @else
                        <p class="mb-0">{{ date('H:i A',strtotime($customer->clock_out))}}</p>
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
  </div>                                      </tr>
                                                
                                                  @endforeach

                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
  
@endsection