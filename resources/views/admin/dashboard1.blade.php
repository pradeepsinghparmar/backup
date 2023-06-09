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
                            
                            
                             @if(!empty($todayattendance->status) && $todayattendance->status == '1')
                             <div class="col-md-5">
                             <h1 class="h3 mb-0 text-gray-800">Welcome to Employee</h1>
                            </div>
                            <div class="col-md-3">
                              &nbsp;&nbsp;&nbsp;<b> @php echo date('h:i a'); @endphp</b><br>
                                <p>Clock In at - {{ date('h:i a',strtotime($todayattendance->clock_in)) }}</p>
                            </div>
                             @else
                             <div class="col-md-6">
                             <h1 class="h3 mb-0 text-gray-800">Welcome to Employee</h1>
                            </div>
                              <div class="col-md-2">
                             &nbsp;&nbsp;&nbsp;<b> @php echo date('h:i a'); @endphp</b>
                             </div>
                            @endif
                            <div class="col-md-2"> 
                            @if(!empty($todayattendance->status) &&  $todayattendance->status == '1')
                              <a onclick="if (!confirm('Are you sure? you want to check out'))
            return false;" href="{{ route('checkoutattendance',$todayattendance->id) }}" class="d-none d-sm-inline-block btn btn-danger shadow-sm"><i
                                class="fas fa-sign-out-alt text-white"></i> Clock Out</a>
                            @else
                               <button type="button" class="d-none d-sm-inline-block btn btn-primary shadow-sm" data-toggle="modal" data-target="#myModal"><i
                                class="fas fa-sign-in-alt text-white"></i> Clock In</button>
                            @endif
                            
                            </div>
                             <div class="col-md-2"> 
                            <a href="{{ route('attendance.index') }}" class="d-none d-sm-inline-block btn btn-primary shadow-sm">View Attendance</a>
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
                                             <img class="img-profile" src="https://owlok.in/jwpl/public/admin/assets/img/undraw_profile.svg" style="width: 50px;">
                                            </div>
                                            <div class="col-md-6"  style="float: left;">
                                               <h4><b>Admin Panel</b></h4>
                                               <p>Employee ID : EMP-1</p>
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
                                               
                                                2
                                                </div>
                                        </div>
                                        <div class="col-auto">
                                            <!--<i class="fas fa-rupee-sign fa-2x text-gray-300"></i>-->
                                             <i class="fas fa-money-bill fa-2x text-gray-300"></i>
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
                                                Ubsent</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">0</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-comments fa-2x text-gray-300"></i>
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
                                                Total Cash (Monthly)</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"> {{ $monthly_sale ?? '0' }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-money-bill fa-2x text-gray-300"></i>
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
                                               
                                                100000
                                                </div>
                                        </div>
                                        <div class="col-auto">
                                            <!--<i class="fas fa-rupee-sign fa-2x text-gray-300"></i>-->
                                             <i class="fas fa-money-bill fa-2x text-gray-300"></i>
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
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $monthly_sale - 100000 }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-comments fa-2x text-gray-300"></i>
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

                    <div class="row">

                        <!-- Area Chart -->
                        <div class="col-xl-8 col-lg-7">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Earnings Overview</h6>
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                            aria-labelledby="dropdownMenuLink">
                                            <div class="dropdown-header">Dropdown Header:</div>
                                            <a class="dropdown-item" href="#">Action</a>
                                            <a class="dropdown-item" href="#">Another action</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#">Something else here</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="chart-area">
                                        <canvas id="myAreaChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pie Chart -->
                        <div class="col-xl-4 col-lg-5">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Revenue Sources</h6>
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                            aria-labelledby="dropdownMenuLink">
                                            <div class="dropdown-header">Dropdown Header:</div>
                                            <a class="dropdown-item" href="#">Action</a>
                                            <a class="dropdown-item" href="#">Another action</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#">Something else here</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="chart-pie pt-4 pb-2">
                                        <canvas id="myPieChart"></canvas>
                                    </div>
                                    <div class="mt-4 text-center small">
                                        <span class="mr-2">
                                            <i class="fas fa-circle text-primary"></i> Direct
                                        </span>
                                        <span class="mr-2">
                                            <i class="fas fa-circle text-success"></i> Social
                                        </span>
                                        <span class="mr-2">
                                            <i class="fas fa-circle text-info"></i> Referral
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Content Column -->
                        <div class="col-lg-6 mb-4">

                            <!-- Project Card Example -->
                            <!--<div class="card shadow mb-4">-->
                            <!--    <div class="card-header py-3">-->
                            <!--        <h6 class="m-0 font-weight-bold text-primary">Projects</h6>-->
                            <!--    </div>-->
                            <!--    <div class="card-body">-->
                            <!--        <h4 class="small font-weight-bold">Server Migration <span-->
                            <!--                class="float-right">20%</span></h4>-->
                            <!--        <div class="progress mb-4">-->
                            <!--            <div class="progress-bar bg-danger" role="progressbar" style="width: 20%"-->
                            <!--                aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>-->
                            <!--        </div>-->
                            <!--        <h4 class="small font-weight-bold">Sales Tracking <span-->
                            <!--                class="float-right">40%</span></h4>-->
                            <!--        <div class="progress mb-4">-->
                            <!--            <div class="progress-bar bg-warning" role="progressbar" style="width: 40%"-->
                            <!--                aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>-->
                            <!--        </div>-->
                            <!--        <h4 class="small font-weight-bold">Customer Database <span-->
                            <!--                class="float-right">60%</span></h4>-->
                            <!--        <div class="progress mb-4">-->
                            <!--            <div class="progress-bar" role="progressbar" style="width: 60%"-->
                            <!--                aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>-->
                            <!--        </div>-->
                            <!--        <h4 class="small font-weight-bold">Payout Details <span-->
                            <!--                class="float-right">80%</span></h4>-->
                            <!--        <div class="progress mb-4">-->
                            <!--            <div class="progress-bar bg-info" role="progressbar" style="width: 80%"-->
                            <!--                aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>-->
                            <!--        </div>-->
                            <!--        <h4 class="small font-weight-bold">Account Setup <span-->
                            <!--                class="float-right">Complete!</span></h4>-->
                            <!--        <div class="progress">-->
                            <!--            <div class="progress-bar bg-success" role="progressbar" style="width: 100%"-->
                            <!--                aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>-->
                            <!--        </div>-->
                            <!--    </div>-->
                            <!--</div>-->

                            <!-- Color System -->
                            <!--<div class="row">-->
                            <!--    <div class="col-lg-6 mb-4">-->
                            <!--        <div class="card bg-primary text-white shadow">-->
                            <!--            <div class="card-body">-->
                            <!--                Primary-->
                            <!--                <div class="text-white-50 small">#4e73df</div>-->
                            <!--            </div>-->
                            <!--        </div>-->
                            <!--    </div>-->
                            <!--    <div class="col-lg-6 mb-4">-->
                            <!--        <div class="card bg-success text-white shadow">-->
                            <!--            <div class="card-body">-->
                            <!--                Success-->
                            <!--                <div class="text-white-50 small">#1cc88a</div>-->
                            <!--            </div>-->
                            <!--        </div>-->
                            <!--    </div>-->
                            <!--    <div class="col-lg-6 mb-4">-->
                            <!--        <div class="card bg-info text-white shadow">-->
                            <!--            <div class="card-body">-->
                            <!--                Info-->
                            <!--                <div class="text-white-50 small">#36b9cc</div>-->
                            <!--            </div>-->
                            <!--        </div>-->
                            <!--    </div>-->
                            <!--    <div class="col-lg-6 mb-4">-->
                            <!--        <div class="card bg-warning text-white shadow">-->
                            <!--            <div class="card-body">-->
                            <!--                Warning-->
                            <!--                <div class="text-white-50 small">#f6c23e</div>-->
                            <!--            </div>-->
                            <!--        </div>-->
                            <!--    </div>-->
                            <!--    <div class="col-lg-6 mb-4">-->
                            <!--        <div class="card bg-danger text-white shadow">-->
                            <!--            <div class="card-body">-->
                            <!--                Danger-->
                            <!--                <div class="text-white-50 small">#e74a3b</div>-->
                            <!--            </div>-->
                            <!--        </div>-->
                            <!--    </div>-->
                            <!--    <div class="col-lg-6 mb-4">-->
                            <!--        <div class="card bg-secondary text-white shadow">-->
                            <!--            <div class="card-body">-->
                            <!--                Secondary-->
                            <!--                <div class="text-white-50 small">#858796</div>-->
                            <!--            </div>-->
                            <!--        </div>-->
                            <!--    </div>-->
                            <!--    <div class="col-lg-6 mb-4">-->
                            <!--        <div class="card bg-light text-black shadow">-->
                            <!--            <div class="card-body">-->
                            <!--                Light-->
                            <!--                <div class="text-black-50 small">#f8f9fc</div>-->
                            <!--            </div>-->
                            <!--        </div>-->
                            <!--    </div>-->
                            <!--    <div class="col-lg-6 mb-4">-->
                            <!--        <div class="card bg-dark text-white shadow">-->
                            <!--            <div class="card-body">-->
                            <!--                Dark-->
                            <!--                <div class="text-white-50 small">#5a5c69</div>-->
                            <!--            </div>-->
                            <!--        </div>-->
                            <!--    </div>-->
                            <!--</div>-->

                        </div>

                        <div class="col-lg-6 mb-4">

                            <!-- Illustrations -->
                            <!--<div class="card shadow mb-4">-->
                            <!--    <div class="card-header py-3">-->
                            <!--        <h6 class="m-0 font-weight-bold text-primary">Illustrations</h6>-->
                            <!--    </div>-->
                            <!--    <div class="card-body">-->
                            <!--        <div class="text-center">-->
                            <!--            <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;"-->
                            <!--                src="{{ asset('admin/assets/img/undraw_posting_photo.svg') }}" alt="...">-->
                            <!--        </div>-->
                            <!--        <p>Add some quality, svg illustrations to your project courtesy of <a-->
                            <!--                target="_blank" rel="nofollow" href="https://undraw.co/">unDraw</a>, a-->
                            <!--            constantly updated collection of beautiful svg images that you can use-->
                            <!--            completely free and without attribution!</p>-->
                            <!--        <a target="_blank" rel="nofollow" href="https://undraw.co/">Browse Illustrations on-->
                            <!--            unDraw &rarr;</a>-->
                            <!--    </div>-->
                            <!--</div>-->

                            <!-- Approach -->
                            <!--<div class="card shadow mb-4">-->
                            <!--    <div class="card-header py-3">-->
                            <!--        <h6 class="m-0 font-weight-bold text-primary">Development Approach</h6>-->
                            <!--    </div>-->
                            <!--    <div class="card-body">-->
                            <!--        <p>SB Admin 2 makes extensive use of Bootstrap 4 utility classes in order to reduce-->
                            <!--            CSS bloat and poor page performance. Custom CSS classes are used to create-->
                            <!--            custom components and custom utility classes.</p>-->
                            <!--        <p class="mb-0">Before working with this theme, you should become familiar with the-->
                            <!--            Bootstrap framework, especially the utility classes.</p>-->
                            <!--    </div>-->
                            <!--</div>-->

                        </div>
                    </div>

                </div>
 <!-- Modal -->
<!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Clock In</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
        </div>
        <div class="modal-body">
          <div class="row justify-content-between">
            <div class="col" id="task_div">
                <h4 class="mb-4">
                     <i class="fas fa-clock"></i> @php echo date('d-m-Y h:i a'); @endphp</h4>
            <form action="{{ route('storeattendance') }}" method="post">
                @csrf
                <div class="form-group my-3">
                    <label class="f-14 text-dark-grey mb-12" data-label="true" for="working_from">Working From
                            <sup class="f-14 mr-1">*</sup>
                    
                    </label>
                
                    <input type="text" class="form-control height-35 f-14" placeholder="e.g. Office, Home, etc." name="working_from" id="working_from" required>
                
                </div>
            </div>
        </div>
        </div>
        
        <div class="modal-footer">
          <input type="submit" class="btn btn-primary" value="Save">
          <!--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
        </div>
    </form>
      </div>
    </div>
  </div>
  
@endsection
 