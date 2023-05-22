@extends('admin.layout')

@section('content')

  <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="row">
                                        <div class="col-md-9">
                                   <h1 class="h3 mb-2 text-gray-800">Site Name <?php echo $site_list->site_id_name;?> (<?php echo date('M Y',strtotime($from_date));?>)</h1>
                                    </div>
                                     <div class="col-md-3">
                                         <!--<h1 class="h3 mb-2 text-gray-800"></h1>-->
                                    <a href="{{ route('cash_reports') }}" class="btn btn-dark btn-icon-split">
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
         <a href="{{ route('cash_site_summary', $segment1) }}" class="btn btn-secondary">All</a>
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
                                                    <th>Date</th>
                                                    <th>Actual Balance</th>
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                         @php $i=0; @endphp
                                        @if(!empty($show_site_total_payment))
                                         @php $total=0 @endphp
                                         @foreach($show_site_total_payment as $key => $info)
                                    @php $i++; @endphp
                                                <tr>
                                                     <td>{{ $i }}</td>
                                                   
                                                    <td>{{ date('d M Y',strtotime($info->activation_date)) }}</td>
                                                  
                                               <td> @php
                                                  $sum_amount = \App\Models\Newapidata::where('site_id',$info->site_name)->where('activation_date',$info->activation_date)->where('month',date('m'))->where('year',date('Y'))->get()->sum('price');   
                                                $adjustment_pay = \App\Models\PaymentCollect::where('payment_adjustment','1')->where('site_id',$info->site_name)->where('date',$info->activation_date)->get()->sum('cash_received');   
                                                $totl_sumss = $sum_amount - $adjustment_pay;
                                                 @endphp  
                                               {{ $sum_amount - $adjustment_pay ?? '0' }} </td>
                                                
                                             
                
                                             
                                                  
                                                    
                                                  
                                      
                                                </tr>
                                                 @php
                                                 
                                                 $total= $total + $totl_sumss;
                                                 
                                                 @endphp
                                                 
                                                 
                                                  @endforeach
                                        @endif
                                        
                                    
                                     <tfoot>
                                        <tr>
                                            <th>--</th>
                                           <th>--</th>
                                           <th>{{ $total ?? '0' }}</th>
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
        $( api.column( 2 ).footer() ).html('' + total);
        
    }
    });
});
</script>