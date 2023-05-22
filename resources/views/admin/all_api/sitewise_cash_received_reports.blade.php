@extends('admin.layout')

@section('content')

  <div class="container-fluid">
                                  <div class="row">
                                        <div class="col-md-10">
                                   <h1 class="h3 mb-2 text-gray-800">Site wise Cash Received Report</h1>
                                    </div>
                                     <div class="col-md-2">
                                    <!--<a target="_blank" href="{{ route('view_offline_site_details', $api_site_info->name) }}" class="btn btn-primary btn-icon-split">-->
                                    <!--    <span class="text">Site History</span>-->
                                    <!--</a>-->
                                    </div>
                   </div>
                    <!-- Page Heading -->
                  
                   

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                         <div class="row mt-3">
                                <div class="col-md-12">                        
<form action="{{ route('search_sitewise_cash_received_reports') }}" method="post">
@csrf

<div class="col-sm-3" style="float: left;">
           <select name="site_name[]" class="form-control multi_select" id="inputEmail3" required multiple data-selected-text-format="count > 3">
                @foreach($site_list as $hi)
                @if(in_array($hi->name,$name))
                <option value="{{ $hi->name }}" selected>Site {{ $hi->site_id_name }}</option>
                @else
                <option value="{{ $hi->name }}" >Site {{ $hi->site_id_name }}</option>
                @endif
                
                @endforeach
            </select>
        </div>
        <div class="col-sm-3" style="float: left;">
            <input type="date" name="start_date" placeholder="Enter Start Date" value="<?php if(!empty($from_date)) { echo date('Y-m-d',strtotime($from_date)); }else{ echo date('Y-m-d') ;}?>" class="form-control" id="inputEmail3"  required>
        </div>
    
        <div class="col-sm-3" style="float: left;">
            <input type="date" name="end_date" placeholder="Enter End Date" value="<?php if(!empty($to_date)) { echo date('Y-m-d',strtotime($to_date)); }else{ echo date('Y-m-d') ;}?>" class="form-control" id="inputEmail3" required>
        </div>
    
    <div class="col-sm-3" style="float: left;">
   
          <input type="submit" name="cmdSearch" class="btn btn-primary" value="Search">
           <a href="{{ route('all_emp_payment_collect') }}" class="btn btn-secondary">All</a>
    </div>
</form>
                                
                            </div>
                        </div>

                        <!--<div class="card-header py-3">-->
                        <!--    <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>-->
                        <!--</div>-->
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="export_example" data-name='add_money'>
                                    <thead>
                                        <tr>
                                             <th>S No</th>
                                                    <th>Site Name</th>
                                                    <th>Date</th>
                                                    <th>Total Amount</th>
                                        </tr>
                                    </thead>
                                   
                                   
                                  
                                        
                                      
                                     
                                         <tbody>
                                         @if(!empty($show_site_total_payment))
                                                  @php $i = 0; @endphp
                                                  @foreach($show_site_total_payment as $info)
                                                  
                                                
                                                  @php $i++; @endphp

                                                <tr>
                                          <td>{{ $i }}</td>
                                          <td>Site {{ $api_site_info->site_id_name }}</td>  
                                          <td>
                                              {{ date('d M y',strtotime($info->date)) }}
                                              
                                          </td> 
                                          <td>
                                             
                                              {{ $info->cash_received }} 
                                              
                                          </td>     
                                                    
                          
                        
                                                   
                                                </tr>
                                                
                                                  @endforeach
                                            @endif
                                         <tfoot>
                                            <tr>
                                                 <th>--</th>
                                                  <th>--</th>
                                                  <th>--</th>
                                                   <th>Total Amount :  {{ $sum_site_total_payment ?? '0' }}</th>
                                            </tr>
                                         </tfoot>
                                    </tbody>
                                        
                                   
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
  
@endsection