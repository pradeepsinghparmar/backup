@extends('admin.layout')

@section('content')

  <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="row">
                                        <div class="col-md-10">
                                   <h1 class="h3 mb-2 text-gray-800">Assign Sites For Recharge Module</h1>
                                    </div>
                                     <div class="col-md-2">
                                     <a href="{{ route('staff_list') }}" class="btn btn-dark btn-icon-split">
                                        <span class="text">Back</span>
                                    </a>
                                          
                                    </div>
                   </div>
                   

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <!--<div class="card-header py-3">-->
                        <!--    <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>-->
                        <!--</div>-->
                        <div class="card-body">
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
                                         <div class="row">
                                <div class="col-md-12">         
                       <div class="col-md-3">
                           </div>                    
                <div class="col-md-9">                          
<form action="{{ route('update_assign_sites',$staff_info->id) }}" method="post" enctype="multipart/form-data">
@csrf
    <div class="row mb-3">
        <label for="inputEmail3" class="col-sm-3 col-form-label">Employee Name</label>
        <div class="col-sm-9">
            <input type="text"  placeholder="Name" class="form-control" value="{{ $staff_info->name }}" disabled id="inputEmail3" required>
            
            <input type="hidden"  value="{{ $staff_info->id }}" name="user_ids">
        </div>
    </div>
    <div class="row mb-3">
        <label for="inputEmail3" class="col-sm-3 col-form-label">Assign Sites<span> (Already Assign Sites so disabled on dropdown)</span></label>
        <div class="col-sm-9">
          <select name="site_id[]" class="form-control multi_select" id="inputEmail3" required multiple data-selected-text-format="count > 3">
              
              @foreach($api_list as $hi)
               @if(!empty($asign_ids))
                @if(in_array($hi->id,$asign_ids))
                <option value="{{ $hi->id }}" disabled>Site {{ $hi->site_id_name }}</option>
                @else
                <option value="{{ $hi->id }}" >Site {{ $hi->site_id_name }}</option>
                @endif
                @else
                <option value="{{ $hi->id }}" >Site {{ $hi->site_id_name }}</option>
                @endif
              @endforeach
            </select>
        </div>
    </div>
  
    <div class="row mb-3">
        <label for="inputEmail3" class="col-sm-3 col-form-label"></label>
        <div class="col-sm-9">
    <input type="submit" class="btn btn-primary" value="Assign Sites">
      </div>
    </div>
</form>
                                        
         </div>                                
              
                           </div>
                           </div>
                                        
                                        
                         <div class="card-body">
                            <div class="table-responsive">
                                <table class="export_example">
                                    <thead>
                                        <tr>
                                                    <th>S No</th>
                                                    <th>Site Name</th>
                                                    <th>Action</th>
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                        @php $i=0; @endphp
                                        @if(!empty($sites))
                                         @foreach($sites as $key => $info)
                                    @php $i++; @endphp
                                    <tr>
                                                     <td>{{ $i }}</td>
                                                     <td>
                                           <?php
                                           $site_name =  \App\Models\Allapi::where('id',$info->site_id)->first();?>
                                                      {{  $site_name->site_id_name ?? '' }}  
                                                         
                                                     </td>
                                                     
                                                     <td> <a   class="btn btn-danger btn-circle btn-sm" onclick="if (!confirm('Are you sure? you want to delete this info')) return false;"   href="{{route('delete_assign_sites', $info->id)}}"  title="Delete">
                                         <i class="fas fa-trash"></i>
                                                    </a></td>
                                    
                                     </tr>
                                      @endforeach
                                        @endif
                                          </tbody>
                                </table>
                            </div>
                        </div>
               
                                        
                                     
                    </div>
                </div>
            </div>

  
@endsection