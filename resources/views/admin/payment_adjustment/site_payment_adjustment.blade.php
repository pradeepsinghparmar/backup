@extends('admin.layout')

@section('content')

  <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="row _title-style">
                                        <div class="col-md-9">
                                   <h1 class="h3 mb-2 text-gray-800">All Site Payment Adjustment List</h1>
                                    </div>
                                     <div class="col-md-3">
                                     <a href="{{ route('create_payment_adjustment') }}" class="btn btn-info btn-icon-split">
                                        <span class="text">Create Payment Adjustment</span>
                                    </a>
                                          
                                    </div>
                   </div>
                   

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                          <div class="row mt-3">
                                <div class="col-md-12">                        
<form action="{{ route('search_sitewise_cash_adjustment') }}" method="post">
@csrf

<div class="col-sm-3" style="float: left;">
     <!--label ui selection fluid dropdown-->
          <select name="site_name[]" class="form-control multi_select" id="inputEmail3" required multiple data-selected-text-format="count > 3">
               
                @foreach($site_list as $hi)
                <option value="{{ $hi->name }}">Site {{ $hi->site_id_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-sm-3" style="float: left;">
            <input type="date" name="start_date" placeholder="Enter Start Date" class="form-control" id="inputEmail3"  required>
        </div>
    
        <div class="col-sm-3" style="float: left;">
            <input type="date" name="end_date" placeholder="Enter End Date" class="form-control" id="inputEmail3" required>
        </div>
    
    <div class="col-sm-3" style="float: left;">
   
          <input type="submit" name="cmdSearch" class="btn btn-primary" value="Search">
           <a href="{{ route('site_payment_adjustment') }}" class="btn btn-secondary">All</a>
    </div>
</form>
                                
                            </div>
                        </div>
                        <!--<div class="card-header py-3">-->
                        <!--    <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>-->
                        <!--</div>-->
                       <div class="container-fluid"><br>
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
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="export_example">
                                    <thead>
                                        <tr>
                                                     <th>S No</th>
                                                     <th>Site Name</th>
                                                     <!-- <th>Month</th> -->
                                                    <th>Cash Adjustment</th>
                                                    <!--<th>Cash Due</th>-->
                                                    <!--<th>Added On</th>-->
                                                    <!--<th>Action</th>-->
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                        @php $i=0; @endphp
                                         @foreach($clist as $key => $info)
                                            @php $i++; @endphp
                                                <tr>
                                                    <td>{{ $i }}</td>
                                                    <td>
                                                        
                                                        @foreach($site_list as $inf)
                                    @if($inf->name == $info->site_id)                
                                                      Site {{ $inf->site_id_name }}
                                  @endif
                                  @endforeach
                                                        
                                                        </td>
                                                       
                      <!--   <td>
                           @if($info->month == '01')
                              January
                           @elseif($info->month == '02')
                              February
                           @elseif($info->month == '03')
                              March
                           @elseif($info->month == '04')
                              April
                           @elseif($info->month == '05')
                              May
                           @elseif($info->month == '06')
                              June
                           @elseif($info->month == '07')
                              July
                           @elseif($info->month == '08')
                              August
                           @elseif($info->month == '09')
                              September
                           @elseif($info->month == '10')
                              October
                           @elseif($info->month == '11')
                              November
                           @elseif($info->month == '12')
                              December
                           @endif
                            
                        </td> -->
                          @php
                                           $sum_payment_ajustment_cash = \App\Models\PaymentCollect::where('payment_adjustment','1')->where('site_id',$info->site_id)->where('month',date('m'))->where('year',date('Y'))->get()->sum('cash_received');   
                                            @endphp
                                                    <!--<td>{{ $info->total_amount }}</td>-->
                                                    <td><a href="{{route('payment_adjustment', $info->site_id)}}" target="_blank">{{ $sum_payment_ajustment_cash ?? '0' }}</a></td>
                                                    <!--<td>{{ $info->cash_due }}</td>-->
                                                    <!--<td>{{ date('d M y',strtotime($info->date)) }}</td>-->
                                                 <!--<td>-->
                                                 <!--        <a class="btn btn-primary btn-circle btn-sm"  href="{{route('payment_adjustment', $info->site_id)}}"  title="View"><i class="fas fa-eye"></i></a>-->
                                                     
                                                 <!--   </a>  -->
                                                 <!--      </td> -->
                                       
                                                </tr>
                                                
                                                  @endforeach

                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
  

@endsection