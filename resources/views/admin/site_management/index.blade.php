@extends('admin.layout')

@section('content')

  <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="row">
                                        <div class="col-md-10">
                                   <h1 class="h3 mb-2 text-gray-800">All Site Management</h1>
                                    </div>
                                     <div class="col-md-2">
                                     <a href="{{ route('create_site_management') }}" class="btn btn-info btn-icon-split">
                                        <span class="text">Create Site</span>
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
                                                    <th>Site Name</th>
                                                    <th>Building No</th>
                                                    <th>Street Name</th>
                                                    <th>City</th>
                                                    <th>Postcode</th>
                                                    <th>Added On</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                
                                                  @foreach($site_management as $info)

                                                <tr>
                                                   
                                                    

                         <td>{{ $info->site_name }}</td>
                         <td>{{ $info->building_no_name }}</td>
                         <td>{{ $info->street_name }}</td>
                         <td>{{ $info->city }}</td>
                         <td>{{ $info->postcode }}</td>
                         <td>{{ date('d M y H:i A',strtotime($info->created_at)) }}</td>
                                                    <td>
                                                     
                                                           <a class="btn btn-primary btn-circle btn-sm"  href="{{route('view_site_management', $info->id)}}"  title="View"><i class="fas fa-eye"></i></a>
                                                         <a class="btn btn-success btn-circle btn-sm"  href="{{route('edit_site_management', $info->id)}}"  title="Edit"><i class="fas fa-edit"></i></a>
                                                                        <a   class="btn btn-danger btn-circle btn-sm" onclick="if (!confirm('Are you sure? you want to delete this info')) return false;"   href="{{route('delete_site_management', $info->id)}}"  title="Delete">
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