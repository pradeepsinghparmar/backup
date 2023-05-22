@extends('admin.layout')

@section('content')

<div class="container-fluid">
        @if(session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
         @endif
        @if(session('error'))
        <div class="alert alert-danger" role="alert">
            {{ session('error') }}
        </div>                                     
        @endif
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            
                            
                            
                             <div class="col-md-8">
                             <h1 class="h3 mb-0 text-gray-800">Welcome to {{ $view_info->name }}</h1>
                            </div>
                           
                            
                             <div class="col-md-4"> 
                             
                             </div>
                    </div>

                    <!-- Content Row -->
                    <div class="row">
                      
                        <!-- Earnings (Monthly) Card Example -->
                       

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-6 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="col-md-3" style="float: left;">
                                               @if(!empty($view_info->image_url))
                                                         <img class="img-profile" src="{{ $view_info->image_url }}" style="width: 50px;">
                                                         @else
                                                         <img class="img-profile" src="{{ asset('admin/assets/img/undraw_profile.svg') }}" style="width: 50px;">
                                                         @endif
                                            </div>
                                            <div class="col-md-6"  style="float: left;">
                                               <h4><b>{{ $view_info->name }}</b></h4>
                                               <!--<p>Employee ID : EMP-1</p>-->
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-money-bill fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        
                         <div class="col-xl-3 col-md-3 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Present</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                               
                                               {{ $countpresent ?? '0' }}
                                                </div>
                                        </div>
                                        <div class="col-auto">
                                            <a href="{{ route('attendance.index') }}" class="text-blue-300 d-none d-sm-inline-block btn btn-primary shadow-sm" style="background-color:#2e4fb19e;width: 54px;font-size: 12px;height: 32px;">View</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
        
                       <div class="col-xl-3 col-md-3 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                Absent</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">0</div>
                                        </div>
                                        <div class="col-auto">
                                            <a href="{{ route('attendance.index') }}" class="text-blue-300 d-none d-sm-inline-block btn btn-primary shadow-sm" style="background-color:#2e4fb19e;width: 54px;font-size: 12px;height: 32px;">View</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                  
                    </div>
                    
                     <div class="row">

                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Total Cash</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $cash_received + $cash_due ?? '0'}}</div>
                                        </div>
                                        <div class="col-auto">
                                            <a href="{{ route('employee_payment_collect',$view_info->id) }}" class="text-blue-300 d-none d-sm-inline-block btn btn-primary shadow-sm" style="background-color:#2e4fb19e;width: 54px;font-size: 12px;height: 32px;">View</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        
                         <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Cash Received</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                               
                                                {{ $cash_received ?? '0' }}
                                                </div>
                                        </div>
                                        <div class="col-auto">
                                            <a href="{{ route('employee_payment_collect',$view_info->id) }}" class="text-blue-300 d-none d-sm-inline-block btn btn-primary shadow-sm" style="background-color:#2e4fb19e;width: 54px;font-size: 12px;height: 32px;">View</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
        
                       <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                Due Amount</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $cash_due ?? '0' }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <a href="{{ route('employee_payment_collect',$view_info->id) }}" class="text-blue-300 d-none d-sm-inline-block btn btn-primary shadow-sm" style="background-color:#2e4fb19e;width: 54px;font-size: 12px;height: 32px;">View</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                        <!-- Earnings (Monthly) Card Example -->
                        <!--<div class="col-xl-3 col-md-6 mb-4">-->
                        <!--    <div class="card border-left-info shadow h-100 py-2">-->
                        <!--        <div class="card-body">-->
                        <!--            <div class="row no-gutters align-items-center">-->
                        <!--                <div class="col mr-2">-->
                        <!--                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Tasks-->
                        <!--                    </div>-->
                        <!--                    <div class="row no-gutters align-items-center">-->
                        <!--                        <div class="col-auto">-->
                        <!--                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">50%</div>-->
                        <!--                        </div>-->
                        <!--                        <div class="col">-->
                        <!--                            <div class="progress progress-sm mr-2">-->
                        <!--                                <div class="progress-bar bg-info" role="progressbar"-->
                        <!--                                    style="width: 50%" aria-valuenow="50" aria-valuemin="0"-->
                        <!--                                    aria-valuemax="100"></div>-->
                        <!--                            </div>-->
                        <!--                        </div>-->
                        <!--                    </div>-->
                        <!--                </div>-->
                        <!--                <div class="col-auto">-->
                        <!--                    <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>-->
                        <!--                </div>-->
                        <!--            </div>-->
                        <!--        </div>-->
                        <!--    </div>-->
                        <!--</div>-->

                        <!-- Pending Requests Card Example -->
                        
</div>
                    <!-- Content Row -->

                

                </div>


@endsection
 