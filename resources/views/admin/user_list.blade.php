@extends('admin.layout')

@section('content')

  <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">All Users</h1>
                   

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
                                             <th>Full Name</th>
                                                    <th>Email ID</th>
                                                    <th>Added On</th>
                                                    <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                             <th>Full Name</th>
                                                    <th>Email ID</th>
                                                    <th>Added On</th>
                                                    <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                         <!--@foreach($users as $key => $customer)-->

                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td>
                                                     
                                    <!--                    <a   class="btn btn-danger btn-circle btn-sm" onclick="if (!confirm('Are you sure? you want to delete this info')) return false;"   href="{{route('delete_user', $customer->id)}}"  title="Delete">-->
                                    <!--    <i class="fas fa-trash"></i>-->
                                    <!--</a>-->
                                                    </td>
                                                </tr>
                                                
                                                  <!--@endforeach-->

                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
  
@endsection