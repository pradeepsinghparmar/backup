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
                                       <div class="row  _title-style">
                                    <div class="col-md-10">
                                    <h3>View Adjustment Payment</h3>
                                    </div>
                                     <div class="col-md-2">
                                         <button type="button" class="btn btn-dark"><a href="{{ route('payment_adjustment') }}" style="color:#fff;text-decoration: auto !important;">Back</a></button>   
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
                         <td>
                             @foreach($site_list as $inf)
                                    @if($inf->name == $vlist->site_id)                
                                                      Site {{ $inf->site_id_name }}
                                  @endif
                                  @endforeach
                                                        
                                                        </td>
                      </tr>
                     <!--  <tr>
                        <td><b>Month:</b></td>
                        <td> @if($vlist->month == '01')
                              January
                           @elseif($vlist->month == '02')
                              February
                           @elseif($vlist->month == '03')
                              March
                           @elseif($vlist->month == '04')
                              April
                           @elseif($vlist->month == '05')
                              May
                           @elseif($vlist->month == '06')
                              June
                           @elseif($vlist->month == '07')
                              July
                           @elseif($vlist->month == '08')
                              August
                           @elseif($vlist->month == '09')
                              September
                           @elseif($vlist->month == '10')
                              October
                           @elseif($vlist->month == '11')
                              November
                           @elseif($vlist->month == '12')
                              December
                           @endif
                              </td>
                      </tr> -->
                     <!--  <tr>
                        <td><b>Total Amount:</b></td>
                        <td><?php echo $vlist->total_amount;?></td>
                      </tr> -->
                       <tr>
                        <td><b>Cash Adjustment:</b></td>
                        <td><?php echo $vlist->cash_received;?></td>
                      </tr>
                      
                      <!--  <tr>-->
                      <!--  <td><b>Cash Due:</b></td>-->
                      <!--  <td><?php echo $vlist->cash_due;?></td>-->
                      <!--</tr>-->
                      
                       
                      <tr>
                        <td><b>Reason:</b></td>
                        <td><?php echo $vlist->reason;?></td>
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