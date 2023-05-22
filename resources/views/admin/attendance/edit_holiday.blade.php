@extends('admin.layout')

@section('content')

  <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="row">
                                        <div class="col-md-10">
                                   <h1 class="h3 mb-2 text-gray-800">Edit Holiday</h1>
                                    </div>
                                     <div class="col-md-2">
                                     <a href="{{ route('holiday_list') }}" class="btn btn-dark btn-icon-split">
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
<form action="{{ route('update_holiday',$holiday_edit->id) }}" method="post" enctype="multipart/form-data">
@csrf
<div class="bs-form-wrapper">
<div class="input-wrapper">
    <div class="row">
        <div class="col-sm-12">
            <div class="col-sm-4" style="float:left;">
                <input type="date" name="date"  placeholder="Date" class="form-control" value="{{ $holiday_edit->date }}" for="validationCustom01" required>
            </div>
            <div class="col-sm-7" style="float:left;">
                <input type="text" name="occasion" value="{{ $holiday_edit->occasion }}" placeholder="Occasion" class="form-control" id="validationCustom02" required>
            </div>
        </div>
   </div>
  </div>
</div>
<br>
    &nbsp;&nbsp;&nbsp;<input type="submit" class="btn btn-primary" value="Save">
    
</form>
                                        
        </div>                                
              
                           </div>
                           </div>
                                        
                                        
                                        
                                        
                                     
                    </div>
                </div>
            </div>

@endsection