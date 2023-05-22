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
                                    <h3>View Payment Collect</h3>
                                    </div>
                                     <div class="col-md-2">
                                         <button type="button" class="btn btn-dark"><a href="{{ route('employee_payment_collect',$vlist->employee_id) }}" style="color:#fff;text-decoration: auto !important;">Back</a></button>   
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
                        <td><b>Employee Name:</b></td>
                         <td>
                                                        @foreach($users as $us)
                                                        @if($us->id == $vlist->employee_id)
                                                        
                                                        {{ $us->name }}
                                                        @endif
                                                         @endforeach 
                                                        
                                                        </td>
                      </tr>
                        <tr>
                        <td><b>Site Name:</b></td>
                         <td>
                                                       Site {{ $vlist->site_id }}
                                                      
                                                        </td>
                      </tr>
                      
                       <tr>
                        <td><b>Total Amount:</b></td>
                        <td><?php echo $vlist->total_amount;?></td>
                      </tr>
                       <tr>
                        <td><b>Cash Received:</b></td>
                        <td><?php echo $vlist->cash_received;?></td>
                      </tr>
                      
                        <tr>
                        <td><b>Cash Due:</b></td>
                        <td><?php echo $vlist->cash_due;?></td>
                      </tr>
                      
                       
                      <tr>
                        <td><b>Site Location:</b></td>
                        <td><?php echo $vlist->site_location;?></td>
                      </tr>
                   

                      <tr>
                        <td><b>Added On:</b></td>
                        <td><?php echo date('d M y',strtotime($vlist->date)); ?></td>
                      </tr>

                      
                    </tbody>
                  </table>

      
            </div>
                                                
                                        
                                        
                                        
                                                                        
       </div>
                        </div>
                    </div>

  
@endsection