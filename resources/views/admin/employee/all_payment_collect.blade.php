@extends('admin.layout')

@section('content')

  <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="row">
                                        <div class="col-md-10">
                                   <h1 class="h3 mb-2 text-gray-800">All Payment Collect List</h1>
                                    </div>
                                     <div class="col-md-2">
                                    <button type="button" class="btn btn-dark"><a href="{{ route('employee_list.index') }}" style="color:#fff;text-decoration: auto !important;">Back</a></button>   
                                          
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
                                                     <th>Employee Name</th>
                                                     <th>Site Name</th>
                                                     <th>Total Amount</th>
                                                    <th>Cash Received</th>
                                                    <th>Cash Due</th>
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
                                                       @foreach($users as $us)
                                                        @if($us->id == $info->employee_id)
                                                        
                                                        {{ $us->name }}
                                                        @endif
                                                         @endforeach 
                                                        
                                                        </td>
                                                    <td>
                                                       
                                                        Site {{ $info->site_id }}
                                                      
                                                        
                                                        </td>
                                                    <td>{{ $info->total_amount }}</td>
                                                    <td>{{ $info->cash_received }}</td>
                                                    <td>{{ $info->cash_due }}</td>
                                                    <td>{{ date('d M y',strtotime($info->date)) }}</td>
                                                 <td>
                                                         <a class="btn btn-primary btn-circle btn-sm"  href="{{route('view_employee_payment_collect', $info->id)}}"  title="View"><i class="fas fa-eye"></i></a>
                                                      <a   class="btn btn-danger btn-circle btn-sm" onclick="if (!confirm('Are you sure? you want to delete this info')) return false;"   href="{{route('delete_employee_payment_collect', $info->id)}}"  title="Delete">
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