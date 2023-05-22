@extends('admin.layout')

@section('content')

  <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="row">
                                        <div class="col-md-10">
                                   <h1 class="h3 mb-2 text-gray-800">All API Cash Reports</h1>
                                    </div>
                                     <div class="col-md-2">
                                    <!-- <a href="{{ route('create_allapi') }}" class="btn btn-info btn-icon-split">-->
                                    <!--    <span class="text">Create API</span>-->
                                    <!--</a>-->
                                          
                                    </div>
                   </div>
                   

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        
                         <div class="row mt-3">
                                <div class="col-md-12">                        
<form action="{{ route('search_sitewise_cash_reports') }}" method="post">
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
           <a href="{{ route('cash_reports') }}" class="btn btn-secondary">All</a>
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
                                                    <th>Total System Amount</th>
                                                      <th>Adjustment Payment</th>
                                                    <th>Balance</th>
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                       
                                         @php $i=0; @endphp
                                        @if(!empty($total_payment))
                                         @foreach($total_payment as $key => $info)
                                    @php $i++; @endphp
                                                <tr>
                                                     <td>{{ $i }}</td>
                                                    <td> @foreach($site_list as $inf)
                                    @if($inf->name == $info->site_id)                
                                                      Site {{ $inf->site_id_name }}
                                  @endif
                                  @endforeach</td>
                                                    <td>
                                                          @php
                                           $sum_payment_ajustment = \App\Models\PaymentCollect::where('payment_adjustment','1')->where('site_id',$info->site_id)->where('month',date('m'))->where('year',date('Y'))->get()->sum('cash_received');   
                                            @endphp
                                                        
                                                        <a target="_blank" href="{{ route('cash_site_cash_report',$info->site_id) }}">{{ $info->total_amount ?? '0' }}</a></td>
                                                    <td> @php
                                           $sum_adjustment = \App\Models\PaymentCollect::where('payment_adjustment','1')->where('site_id',$info->site_id)->where('month',date('m'))->where('year',date('Y'))->get()->sum('cash_received');   
                                            @endphp 
                                            {{ $sum_adjustment }}</td>
                                                   
                                               <td> <a target="_blank" href="{{ route('cash_site_balance_report',$info->site_id) }}">{{ $info->total_amount - $sum_adjustment ?? '0' }}</a></td>   
                                                    
                                                  
                                      
                                                </tr>
                                               
                                                  @endforeach
                                        @endif
                                        
                                    
                                     <tfoot>
                                        <tr>
                                            <th>--</th>
                                           <th>{{ $total_site_count ?? '0' }} </th>
                                           <th>{{ $total_site_payments ?? '0' }}</th>
                                           <th>{{ $payment_adjustment ?? '0' }}</th>
                                           <th>{{ $total_site_payments - $payment_adjustment ?? '0' }}</th>
                                        </tr>
                                    </tfoot>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>



@endsection