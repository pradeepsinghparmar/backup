@extends('admin.layout')

@section('content')

  <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="row">
                                        <div class="col-md-10">
                                   <h1 class="h3 mb-2 text-gray-800">Create Contact</h1>
                                    </div>
                                     <div class="col-md-2">
                                     <a href="{{ route('contact_list') }}" class="btn btn-dark btn-icon-split">
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
<form action="{{ route('store_contact') }}" method="post" enctype="multipart/form-data">
@csrf

 <div class="row mb-3">
        <label for="validationCustom01" class="col-sm-3 col-form-label">Subject</label>
        <div class="col-sm-9">
            <input type="text" name="subject"  placeholder="Enter Subject" class="form-control" for="validationCustom01" required>
        </div>
    </div>
    <div class="row mb-3">
        <label for="validationCustom01" class="col-sm-3 col-form-label">Message</label>
        <div class="col-sm-9">
            <textarea name="message"  rows="6" placeholder="Enter Message" class="form-control" for="validationCustom01" required></textarea>
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