@extends('admin.layout')

@section('content')

  <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="row _title-style">
                                        <div class="col-md-10">
                                   <h1 class="h3 mb-2 text-gray-800">All Payment Adjustment List</h1>
                                    </div>
                                     <div class="col-md-2">
                                     <a href="{{ route('site_payment_adjustment') }}" class="btn btn-dark btn-icon-split">
                                        <span class="text">Back</span>
                                    </a>
                                          
                                    </div>
                   </div>
                   

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
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
                                                     <!--<th>Total Amount</th>-->
                                                    <th>Cash Adjustment</th>
                                                    <!--<th>Cash Due</th>-->
                                                    <th>Added On</th>
                                                    <th>Action</th>
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
                                                       
                       <!--  <td>
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
                                                    <!--<td>{{ $info->total_amount }}</td>-->
                                                    <td>{{ $info->cash_received }}</td>
                                                    <!--<td>{{ $info->cash_due }}</td>-->
                                                    <td>{{ date('d M y',strtotime($info->date)) }}</td>
                                                 <td>
                                                         <a class="btn btn-primary btn-circle btn-sm"  href="{{route('view_payment_adjustment', $info->id)}}"  title="View"><i class="fas fa-eye"></i></a>
                                                       <a   class="btn btn-danger btn-circle btn-sm" onclick="if (!confirm('Are you sure? you want to delete this info')) return false;"   href="{{route('delete_payment_adjustment', $info->id)}}"  title="Delete">
                                         <i class="fas fa-trash"></i>
                                                    </a>  
                                                       </td> 
                                       
                                                </tr>
                                                
                                                  @endforeach

                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
  

@endsection