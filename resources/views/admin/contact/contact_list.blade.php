@extends('admin.layout')

@section('content')

  <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="row">
                                        <div class="col-md-9">
                                   <h1 class="h3 mb-2 text-gray-800">All Contact List</h1>
                                    </div>
                                     <div class="col-md-3">
                                       <a href="{{ route('create_contact') }}" class="btn btn-info btn-icon-split">
                                        <span class="text">Create Contact to Admin</span>
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
                                             <th>S No.</th>
                                                    <th>Subject</th>
                                                    <th>Message</th>
                                                    <th>Added On</th>
                                                    <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                          <th>S No.</th>
                                                    <th>Subject</th>
                                                    <th>Message</th>
                                                    <th>Added On</th>
                                                     <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @php $i=0; @endphp
                                        @if(!empty($all_contact_list))
                                         @foreach($all_contact_list as $key => $info)
   @php $i++; @endphp
                                                <tr>
                                                    <td>{{ $i }}</td>
                                                   
                                                  <td>{{ \Illuminate\Support\Str::limit($info->subject, 20, '...') }}</td>
                                                     <td>{{ \Illuminate\Support\Str::limit($info->message, 40, '...') }}</td>
                                                    <td>{{ date('d M Y',strtotime($info->created_at)) }}</td>
                                                   
                                                      <td>
                                                          <a class="btn btn-primary btn-circle btn-sm"  href="{{route('view_contact', $info->id)}}"  title="View"><i class="fas fa-eye"></i></a>
                                                  
                                                                        <a   class="btn btn-danger btn-circle btn-sm" onclick="if (!confirm('Are you sure? you want to delete this info')) return false;"   href="{{route('delete_contact', $info->id)}}"  title="Delete">
                                         <i class="fas fa-trash"></i>
                                                    </a>
                                                    </td>
                                                  
                                                </tr>
                                                
                                                  @endforeach
                                            @endif
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
  


@endsection