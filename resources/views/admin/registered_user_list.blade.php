@extends('admin.layout')

@section('content')

  <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">All Registered Users</h1>
                   

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
                                            <th>S.No.</th>
                                             <th>Name</th>
                                                    <th>Mobile</th>
                                                    <th>Added On</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                             <th>S.No.</th>
                                             <th>Name</th>
                                                    <th>Mobile</th>
                                                    <th>Added On</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @php $i = 0 @endphp
                                         @foreach($registered_user_list as $key => $customer)
 @php $i++ @endphp
                                                <tr>
                                                    <td>{{ $i }}</td>
                                                    <td>{{$customer->name}}</td>
                                                    <td>{{$customer->mobile}}</td>
                                                    <td>
                                                     {{date('d M Y H:i:s',strtotime($customer->created_at))}}
                                   
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