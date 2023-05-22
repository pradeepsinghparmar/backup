@extends('admin.layout')

@section('content')

  <div class="container-fluid">

                    <!-- Page Heading -->
                                       <div class="row">
                                    <div class="col-md-10">
                                    <h3>Create Site Management</h3>
                                    </div>
                                     <div class="col-md-2">
                                         <button type="button" class="btn btn-dark"><a href="{{ route('site_management.index') }}" style="color:#fff;text-decoration: auto !important;">Back</a></button>   
                                         </div>
                   
</div>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <!--<div class="card-header py-3">-->
                        <!--    <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>-->
                        <!--</div>-->
                         @if(session('success'))
                                        <div class="alert alert-custom alert-indicator-top indicator-success" role="alert">
                                            <div class="alert-content">
                                                <span class="alert-title">Success!</span>
                                                <span class="alert-text"> {{ session('success') }}</span>
                                            </div>
                                        </div>
                                           
                                        @endif
                                          @if(session('error'))
                                        <div class="alert alert-custom alert-indicator-top indicator-danger" role="alert">
                                            <div class="alert-content">
                                                <span class="alert-title">Error!</span>
                                                <span class="alert-text"> {{ session('error') }}</span>
                                            </div>
                                        </div>
                                           
                                        @endif
                        <div class="card-body">
                                         <div class="row">
                                <div class="col-md-12">         
                       <div class="col-md-3">
                           </div>                    
                <div class="col-md-9">                          
<form action="{{ route('store_site_management') }}" method="post" enctype="multipart/form-data">
@csrf

<div class="row mb-3">
        <label for="inputEmail3" class="col-sm-3 col-form-label">Site Name</label>
        <div class="col-sm-9">
            <input type="text" name="site_name" placeholder="Enter Site Name" class="form-control" id="inputEmail3" required>
        </div>
    </div>
    <div class="row mb-3">
        <label for="inputEmail3" class="col-sm-3 col-form-label">Building No/Name</label>
        <div class="col-sm-9">
            <input type="text" name="building_no_name" placeholder="Enter Building No/Name" class="form-control" id="inputEmail3" required>
        </div>
    </div>
    
    <div class="row mb-3">
        <label for="inputEmail3" class="col-sm-3 col-form-label">Street Name</label>
        <div class="col-sm-9">
            <input type="text" name="street_name" placeholder="Enter Street Name" class="form-control" id="inputEmail3" required>
        </div>
    </div>
    
    <div class="row mb-3">
        <label for="inputEmail3" class="col-sm-3 col-form-label">City</label>
        <div class="col-sm-9">
            <input type="text" name="city" placeholder="Enter City" class="form-control" id="inputEmail3" required>
        </div>
    </div>
    
      <div class="row mb-3">
        <label for="inputEmail3" class="col-sm-3 col-form-label">Postcode</label>
        <div class="col-sm-9">
            <input type="number" maxlength="6" name="postcode" placeholder="Enter Postcode" class="form-control" id="inputEmail3" required>
        </div>
    </div>  
    
   
    
     <div class="row mb-3">
        <label for="inputEmail3" class="col-sm-3 col-form-label">Description</label>
        <div class="col-sm-9">
            <textarea name="description" placeholder="Enter Description" class="form-control" id="inputEmail3" required></textarea>
        </div>
    </div>
  
     <div class="row mb-3">
        <label for="inputEmail3" class="col-sm-3 col-form-label">Google Map Location</label>
        <div class="col-sm-9">
            <input type="text" name="google_map_location" placeholder="Enter Google Map Location" class="form-control" id="inputEmail3">
        </div>
    </div>
    

   
    <input type="submit" class="btn btn-primary" value="Save">
    
</form>
                                
                            </div>
                        </div>
                    </div>

                </div>
  
@endsection