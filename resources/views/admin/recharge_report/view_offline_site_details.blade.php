@extends('admin.layout')

@section('content')


  <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="row">
                                        <div class="col-md-10">
                                   <h1 class="h3 mb-2 text-gray-800">View Offline Site History</h1>
                                    </div>
                                     <div class="col-md-2">
                                     <a href="{{ route('offline_recharge_history') }}" class="btn btn-dark btn-icon-split">
                                        <span class="text">Back</span>
                                    </a>
                                          
                                    </div>
                   </div>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                         <div class="row mt-3">
                                <div class="col-md-12">                        
<form>

        <div class="col-sm-3" style="float: left;">
            
            <input type="date" name="start_date" placeholder="Enter Start Date" value="<?php if(!empty($f_day)) { echo date('Y-m-d',strtotime($f_day)); }else{ echo date('Y-m-d') ;}?>" class="form-control" id="inputEmail3"  required>
            
        </div>
    
        <div class="col-sm-3" style="float: left;">
           
            <input type="date" name="end_date" placeholder="Enter End Date" value="<?php if(!empty($l_day)) { echo date('Y-m-d',strtotime($l_day)); }else{ echo date('Y-m-d') ;}?>" class="form-control" id="inputEmail3"  required>
            
        </div>
    
    <div class="col-sm-3" style="float: left;">
   
          <button class="btn btn-primary">Search</button>
    </div>
</form>
                            </div>
                        </div>

                        <!--<div class="card-header py-3">-->
                        <!--    <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>-->
                        <!--</div>-->
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="export_example" data-name='add_money' id="exmp">
                                    <thead>
                                        <tr>
                                          
                                                 
                                                    <th>Site Name</th>
                                                    <th>Voucher Code</th>
                                                    <th>Activation Date</th>
                                                    <th>Expiry Date</th>
                                                   
                                                    <th>Profile</th>
                                                     <th>Price</th>
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                      
                                         @if(!empty($show_site_details))
                                                  @php $i = 0; @endphp
                                                  @foreach($show_site_details as $info)
                                                  
                                                
                                                  @php $i++; @endphp

                                                <tr>
                                          
                                                       
                                          <td> 
                                          
                                           @if(!empty($api_name->site_id_name))
                                              {{ $api_name->site_id_name }}
                                              @else
                                              --
                                              @endif
                                             
                                            </td> 
                                          <?php if($info['api_type'] == '1'){?>
                                          <td>{{ $info['voucher_code'] }}</td>          
                                          <td>{{ date('d M y',strtotime($info['activation_date'])) }}</td>          
                                          <td>{{ date('d M y',strtotime($info['expiry_date'])) }}</td>       
                                          
                                          <td>{{ $info['profile'] }}</td> 
                                          <td>{{ $info['price'] }}</td> 
                                                    
                                          <?php }elseif($info['api_type'] == '2'){?>
                                          <td>-</td>          
                                          <td>{{ date('d M y',strtotime($info['activation_date'])) }}</td>          
                                          <td>-</td>       
                                          
                                          <td>-</td> 
                                          <td>{{ $info['price'] }}</td> 
                                          
                                          <?php }?>
                        
                                                   
                                                </tr>
                                                
                                                  @endforeach
                                            @endif
                                        
                                    </tbody>
        <!--                            <tfoot>-->
        <!--    <tr>-->
        <!--        <th colspan="6"></th>-->
        <!--    </tr>-->
        <!--</tfoot>-->
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                 <script src="https://owlok.in/jwpl/public/admin/assets/vendor/jquery/jquery.min.js"></script>
 <script>
//     $(document).ready(function() {
//     $('#exmp').DataTable( {
//         "footerCallback": function ( row, data, start, end, display ) {
//             var api = this.api();
 
//             // Remove the formatting to get integer data for summation
//             var intVal = function ( i ) {
//                 return typeof i === 'string' ?
//                     i.replace(/[\$,]/g, '')*1 :
//                     typeof i === 'number' ?
//                         i : 0;
//             };
 
//             // Total over all pages
//             total = api
//                 .column( 5 )
//                 .data()
//                 .reduce( function (a, b) {
//                     return intVal(a) + intVal(b);
//                 }, 0 );
 
//             // Total over this page
//             pageTotal = api
//                 .column( 5, { page: 'current'} )
//                 .data()
//                 .reduce( function (a, b) {
//                     return intVal(a) + intVal(b);
//                 }, 0 );
 
//             // Update footer
//             $( api.column( 5 ).footer() ).html(
//                 ' (Total : '+ total +' )'
//             );
//         }
//     } );
// } );

 </script> 
@endsection