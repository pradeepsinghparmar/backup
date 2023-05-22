@extends('admin.layout')

@section('content')
<?php use Illuminate\Support\Str;?>
  <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="row">
                                        <div class="col-md-10">
                                   <h1 class="h3 mb-2 text-gray-800">Site Name <?php echo $site_list->site_id_name;?> (<?php echo date('M Y',strtotime($from_date));?>)</h1>
                                    </div>
                                     <div class="col-md-2">
                                         <!--<h1 class="h3 mb-2 text-gray-800"></h1>-->
                                     <a href="{{ route('cash_summary') }}" class="btn btn-dark btn-icon-split">
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
            <input type="date" name="start_date" placeholder="Enter Start Date" value="<?php if(!empty($from_date)) { echo date('Y-m-d',strtotime($from_date)); }else{ echo date('Y-m-d') ;}?>" class="form-control" id="inputEmail3"  required>
        </div>
    
        <div class="col-sm-3" style="float: left;">
            <input type="date" name="end_date" placeholder="Enter End Date" value="<?php if(!empty($to_date)) { echo date('Y-m-d',strtotime($to_date)); }else{ echo date('Y-m-d') ;}?>" class="form-control" id="inputEmail3" required>
        </div> 
    <div class="col-sm-4" style="float: left;">
   
         <button class="btn btn-primary">Search</button>
         <?php $segment1 =  $site_id; ?>
         <a href="{{ route('cash_received_summary', $segment1) }}" class="btn btn-secondary">All</a>
    </div>
</form>
                                
                            </div>
                        </div>
                        
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
                                                    <th>S No</th>
                                                    <th>Date of Collection</th>
                                                    <th>Total Amount</th>
                                                    <th>Received</th>
                                                    <th>Balance</th>
                                                    <th>Employee Name</th>
                                                    <th>Location</th>
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                        <tr>
                                             <td>--</td>
                                            <td><?php echo date('M-Y',strtotime($from_date));?></td>
                                            
                                            <td><?php echo $system_amount->total_amount ?? '0';?></td>
                                           
                                            <td>--</td>
                                            <td><?php echo $system_amount->total_amount ?? '0';?></td>
                                            <td>--</td>
                                            <td>--</td>
                                        </tr>
                                         @php $i=0; @endphp
                                        @if(!empty($show_site_total_payment))
                                         @php  $total=0 @endphp
                                         @foreach($show_site_total_payment as $key => $info)
                                    @php $i++; @endphp
                                                <tr>
                                                     <td>{{ $i }}</td>
                                                   
                                                    <td>{{ date('d M Y',strtotime($info->date)) }}</td>
                                                    <td>--</td>
                                                    <td>  {{ $info->cash_received ?? '0'}} </td>
                                                    <td>  {{ $info->total_amount ?? '0'}} </td>
                                                    <td>
                                                         @foreach($users as $emp)
                                                         @if($emp->id == $info->employee_id)
                                                         
                                                         {{ $emp->name }}
                                                         @endif
                                                         @endforeach
                                                        
                                                         </td>
                                               <td>   {{ Str::limit($info->site_location, 40) }} </td>
                                      
                                                </tr>
                                              <?php
                                              
                                              if(!empty($from_date) && !empty($to_date))
                                              {
                                           $received = \App\Models\PaymentCollect::where('payment_adjustment','0')->where('site_id',$info->site_id)->where('date', '>=',$from_date)->where('date', '<=',$to_date)->get()->sum('cash_received');   
                                              }else{
                                            $received = \App\Models\PaymentCollect::where('payment_adjustment','0')->where('site_id',$info->site_id)->where('month',$from_date)->where('year',date('Y'))->get()->sum('cash_received');         
                                              }
                                           
                                           if(!empty($received))
                                           {
                                               $sum_received = $received;
                                           }else{
                                               $sum_received = '0';
                                           }
                                          
                                           ?>
                                                  @endforeach
                                                 
                                        @endif
                                        
                                    
                                     <tfoot>
                                        <tr>
                                           <th>--</th>
                                           <th>--</th>
                                           <th><?php echo $system_amount->total_amount ?? '0';?></th>
                                           <th><?php echo $sum_received ?? '0';?></th>
                                          <?php  if(!empty($received))
                                           {  
                                                $cash_due = $system_amount->total_amount - $sum_received;
                                           ?>
                                                <th><?php echo $cash_due;?></th>
                                          <?php }else{
                                          
                                               $cash_due = $system_amount->total_amount - 0;?>
                                               <th><?php echo $cash_due;?></th>
                                           <?php }?>
                                          
                                           <th>--</th>
                                           <th>--</th>
                                        </tr>
                                    </tfoot>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>



@endsection

 <script src="{{ asset('admin/assets/vendor/jquery/jquery.min.js') }}"></script> 
<script>
    $(document).ready(function() {
    $('.export_example1').DataTable( {
        order: [[ 0, "asc" ]],
        dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            // 'csvHtml5',
            // 'pdfHtml5',
            'print'
        ],
        alengthChange: true,
        alengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
        pageLength: 31,
        footerCallback: function ( row, data, start, end, display ) {
        var api = this.api(), data;

        // Remove the formatting to get integer data for summation
        var intVal = function ( i ) {
            return typeof i === 'string' ?
                i.replace(/[\$,]/g, '')*1 :
                typeof i === 'number' ?
                    i : 0;
        };

        // Total over all pages
     
     

        // Update footer
       
        total = api
            .column( 2)
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );

        // Update footer
        $( api.column(2 ).footer() ).html('' + total);
        total = api
            .column( 3)
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );

        // Update footer
        $( api.column(3 ).footer() ).html('' + total);
        //  total = api
        //     .column( 4)
        //     .data()
        //     .reduce( function (a, b) {
        //         return intVal(a) + intVal(b);
        //     }, 0 );

        // // Update footer
        // $( api.column(4 ).footer() ).html('' + total);
       
    }
    });
});
</script>