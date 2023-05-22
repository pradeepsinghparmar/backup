@extends('admin.layout')

@section('content')

  <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">All Employee</h1>
                   

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <!--<div class="card-header py-3">-->
                        <!--    <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>-->
                        <!--</div>-->
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="export_example">
                                    <thead>
                                        <tr>
                                             <th>S No</th>
                                             <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Mobile</th>
                                                    <th>Added On</th>
                                                    <th>Action</th>
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                        @php $i=0; @endphp
                                         @foreach($users as $key => $customer)
 @php $i++; @endphp
                                                <tr>
                                                    <td>{{ $i }}</td>
                                                    <td> 
                                                   
                                                         @if(!empty($customer->image_url))
                                                         <img class="img-profile" src="{{ $customer->image_url }}" style="width: 50px;">
                                                         @else
                                                         <img class="img-profile" src="{{ asset('admin/assets/img/undraw_profile.svg') }}" style="width: 50px;">
                                                         @endif&nbsp;&nbsp;{{ $customer->name }}</td>
                                                    <td>{{ $customer->email }}</td>
                                                    <td>{{ $customer->phone }}</td>
                                                    <td>{{ date('d M y',strtotime($customer->created_at)) }}</td>
                                                    <td>
                                                      <!--<a class="btn btn-primary btn-sm"  href="{{route('employee_assign_sites', $customer->id)}}"  title="Assign Sites">Assign Sites</a>  -->
                                                      <a class="btn btn-primary btn-sm"  href="{{route('employee_dashboard', $customer->id)}}"  title="View"><i class="fas fa-fw fa-eye"></i></a>  
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