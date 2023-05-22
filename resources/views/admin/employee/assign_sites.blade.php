@extends('admin.layout')

@section('content')

  <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="row">
                                        <div class="col-md-10">
                                   <h1 class="h3 mb-2 text-gray-800">Edit Assign Sites</h1>
                                    </div>
                                     <div class="col-md-2">
                                     <a href="{{ route('employee_list.index') }}" class="btn btn-dark btn-icon-split">
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
                            @if(session('error'))
                                        <div class="alert alert-custom alert-indicator-top indicator-danger" role="alert">
                                            <div class="alert-content">
                                                <span class="alert-title">Error!</span>
                                                <span class="alert-text"> {{ session('error') }}</span>
                                            </div>
                                        </div>
                                           
                                        @endif
                                         <div class="row">
                                <div class="col-md-12">         
                       <div class="col-md-3">
                           </div>                    
                <div class="col-md-9">                          
<form action="#" method="post" enctype="multipart/form-data">
@csrf
   
   <h4>Assign Sites for Employee</h4> 

    <div class="row mb-3">
        <div class="col-sm-9">
           
           <table class="table table-striped">

                        

                                
                                @foreach($api_list as $row1)

                                  

                            <tr>

                                <td>{{ $row1->site_id_name }}</td>

                                <td>
                                    <div class="settings-integrations-item-switcher">
                                     <div class="form-check form-switch">
                                        <input class="form-check-input form-control-md" type="checkbox" value="{{ $row1->id }}" name="sites_ids[]" >
                                     </div>
                                     </div>
                                </td>

                            </tr>

   @endforeach
                        </table>
           
           
        </div>
    </div>
    
   
    
    <input type="submit" class="btn btn-primary" value="Save">
    
</form>
                                        
         </div>                                
              
                           </div>
                           </div>
                                        
                                        
                                        
                                        
                                     
                    </div>
                </div>
            </div>

  
@endsection