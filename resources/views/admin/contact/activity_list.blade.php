@extends('admin.layout')

@section('content')

  <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="row">
                                        <div class="col-md-9">
                                   <h1 class="h3 mb-2 text-gray-800">All Activity Notification</h1>
                                    </div>
                                     <div class="col-md-3">
                                      
                                          
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
                                                    <th>Employee Name</th>
                                                    <th>Account Type</th>
                                                    <th>Module</th>
                                                    <th>Activity</th>
                                                    <th>Added On</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                          <th>S No.</th>
                                                    <th>Employee Name</th>
                                                    <th>Account Type</th>
                                                    <th>Module</th>
                                                    <th>Activity</th>
                                                    <th>Added On</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @php $i=0; @endphp
                                        @if(!empty($activity_list))
                                         @foreach($activity_list as $key => $info)
   @php $i++; @endphp
                                                <tr>
                                                    <td>{{ $i }}</td>
                                                   
                                                    <td>
                                                        @foreach($emp as $in)
                                                        @if($in->id == $info->user_id)
                                                         {{ $in->name }}
                                                        @endif
                                                        @endforeach
                                                        
                                                       
                                                        
                                                        
                                                        </td>
                                                    <td> @foreach($role as $inf)
                                    @if($inf->role_id == $info->user_type)                
                                         {{ $inf->name }}
                                  @endif
                                  @endforeach</td>
                                                    <td>{{ $info->module }}</td>
                                                    <td>{{ $info->activity }}</td>
                                                    <td>{{ date('d M Y',strtotime($info->created_at)) }}</td>
                                                   <td>
                                                       
                                                        <?php if($info->status == "read"){?>
                                                             <span class="badge bg-light-success text-success rounded-pill">Read</span>
                                                             <?php }elseif($info->status == "unread"){?>
                                                                  <span class="badge bg-light-danger text-danger rounded-pill">Unread</span>
                                                            <?php  }?>
                                                   </td>
                                                      <td>
                                                          <a class="btn btn-primary btn-circle btn-sm"  href="{{route('view_activity', $info->id)}}"  title="View"><i class="fas fa-eye"></i></a>
                                                  
                                                                        <a   class="btn btn-danger btn-circle btn-sm" onclick="if (!confirm('Are you sure? you want to delete this info')) return false;"   href="{{route('delete_activity', $info->id)}}"  title="Delete">
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