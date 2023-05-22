@extends('admin.layout')

@section('content')

  <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="row">
                                        <div class="col-md-10">
                                   <h1 class="h3 mb-2 text-gray-800">All API List</h1>
                                    </div>
                                     <div class="col-md-2">
                                     <a href="{{ route('create_allapi') }}" class="btn btn-info btn-icon-split">
                                        <span class="text">Create API</span>
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
                                           <th>Site No</th>
                                                    <th>API URL</th>
                                                    <th>API Type</th>
                                                    <th>API Status</th>
                                                    <th>Added On</th>
                                                    <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                           <th>Site Name</th>
                                           <th>Site No</th>
                                                    <th>API URL</th>
                                                    <th>API Type</th>
                                                    <th>API Status</th>
                                                    <th>Added On</th>
                                                    <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                         @foreach($api_list as $key => $info)

                                                <tr>
                                                    <td>{{ $info->site_id_name }}</td>
                                                    <td>Site {{ $info->name }}</td>
                                                    <td>{{ $info->api_url }}</td>
                                                    <td>
                                                        @if($info->type == 1)
                                                        New
                                                        @elseif($info->type == 2)
                                                        Old
                                                        @endif
                                                        
                                                        </td>
                                                  
                                                    
                                                    <td> 
                                                    
                                                    <div class="form-check form-switch">
                                @if($info->status == '1')
                                            <input class="form-check-input" type="checkbox"id="{{ $info->id }}" onclick="publishUser(this);" checked="">
                                             <label class="form-check-label" for="flexSwitchCheckChecked"></label>
                                @elseif($info->status == '0')
                                           <input class="form-check-input" type="checkbox" id="{{ $info->id }}" onclick="publishUser(this);">
                                             <label class="form-check-label" for="flexSwitchCheckChecked"></label>
                                 @endif
                                        </div>
                                        
                                        
                                        </td>
                                        <td>{{ date('d M Y H:i:s',strtotime($info->created_at)) }}</td>
                                        <td>
                                                  
                                                                        <a   class="btn btn-danger btn-circle btn-sm" onclick="if (!confirm('Are you sure? you want to delete this info')) return false;"   href="{{route('delete_allapi', $info->id)}}"  title="Delete">
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
  
{{ csrf_field() }}

<script>
function publishUser(sender) {
 var _token = $('input[name="_token"]').val();
  var api_id = sender.id;
    //   alert(_token);
//if (!confirm('Are you sure? you want to delete this info')) return false;
                 $.ajax({ 

                    url: "{{ route('change_status') }}",
                    method: 'POST',
                    data:{api_id:api_id, _token:_token},

                    success: function(data) { 
// alert(data);
                if(data == "0"){
                        alert('Active Successfully');
                        location.reload();
                }else if(data == "1"){
                        alert('Inactive Successfully');
                            location.reload();
                }

                    } 

                }); 


}
</script>

@endsection