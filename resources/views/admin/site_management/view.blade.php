@extends('admin.layout')

@section('content')
 <style>
    .tile {
    position: relative;
    background: #ffffff;
    border-radius: 3px;
    padding: 15px;
    height: 500px;
    margin-bottom: 30px;
</style>

  <div class="container-fluid">

                    <!-- Page Heading -->
                                       <div class="row">
                                    <div class="col-md-10">
                                    <h3>View Site Management</h3>
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
                                        
                                        <div class="tile">
            
                  <table class="table table-striped table-bordered">
                    <tbody>
                        
                        <tr>
                        <td><b>Site Name:</b></td>
                        <td><?php echo $view_site_management->site_name;?></td>
                      </tr>
                      <tr>
                        <td><b>Building No/Name:</b></td>
                        <td><?php echo $view_site_management->building_no_name;?></td>
                      </tr>

                       <tr>
                        <td><b>Street Name:</b></td>
                        <td><?php echo $view_site_management->street_name;?></td>
                      </tr>
                      
                        <tr>
                        <td><b>City:</b></td>
                        <td><?php echo $view_site_management->city;?></td>
                      </tr>
                      
                        <tr>
                        <td><b>Postcode:</b></td>
                        <td><?php echo $view_site_management->postcode;?></td>
                      </tr>
                      
                        <tr>
                        <td><b>Description:</b></td>
                        <td><?php echo $view_site_management->description;?></td>
                      </tr>
                      @if(!empty($view_site_management->google_map_location))
                                              <tr>
                        <td><b>Google Map Location:</b></td>
                        <td><?php echo $view_site_management->google_map_location;?></td>
                      </tr>
                    @endif

                      <tr>
                        <td><b>Added On:</b></td>
                        <td><?php echo date('d M y H:i A',strtotime($view_site_management->created_at)); ?></td>
                      </tr>

                      
                    </tbody>
                  </table>

      
            </div>
                                                
                                        
                                        
                                        
                                                                        
       </div>
                        </div>
                    </div>

  
@endsection