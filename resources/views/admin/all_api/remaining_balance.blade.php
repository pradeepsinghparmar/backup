@extends('admin.layout')

@section('content')

  <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="row">
                                        <div class="col-md-10">
                                   <h1 class="h3 mb-2 text-gray-800">Total Balance Summary (<?php echo date('M Y');?>)</h1>
                                    </div>
                                     <div class="col-md-2">
                                    <!-- <a href="{{ route('create_allapi') }}" class="btn btn-info btn-icon-split">-->
                                    <!--    <span class="text">Create API</span>-->
                                    <!--</a>-->
                                          
                                    </div>
                   </div>
                   

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        
                         <div class="row mt-3">
                                <div class="col-md-12">                        
<form>

<div class="col-sm-3" style="float: left;">
     <!--label ui selection fluid dropdown-->
          <select name="site_name[]" class="form-control multi_select" id="inputEmail3" required multiple data-selected-text-format="count > 3">
                @foreach($site_list as $hi)
                 @if(!empty($name) && in_array($hi->name,$name))
                <option value="{{ $hi->name }}" selected>Site {{ $hi->site_id_name }}</option>
                @else
                <option value="{{ $hi->name }}" >Site {{ $hi->site_id_name }}</option>
                @endif
                @endforeach
            </select>
        </div>
    
    <div class="col-sm-3" style="float: left;">
   
         <button class="btn btn-primary">Search</button>
         <a href="{{ route('cash_summary') }}" class="btn btn-secondary">All</a>
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
                                <table class="export_example1">
                                   
                                    <thead>
                                        <tr>
                                                    <th>S No</th>
                                                    <th>Site Name</th>
                                                    <th>Balance</th>
                                                    <!--<th>Adjustment Payment</th>-->
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                       
                                        @if(!empty($total_payment))
                                        
                                            @php $i=0; @endphp
                                         @foreach($total_payment as $key => $info)
                                    @php $i++; @endphp
                                                <tr>
                                                     <td>{{ $i }}</td>
                                                    <td> @foreach($site_list as $inf)
                                    @if($inf->name == $info->site_id)                
                                                      Site {{ $inf->site_id_name }}
                                  @endif
                                  @endforeach</td>
                                  
                                  
                                                    <td> 
                                                    @php
                                                    $adjustment_pay = \App\Models\PaymentCollect::where('payment_adjustment','1')->where('site_id',$info->site_id)->where('month',date('m'))->where('year',date('Y'))->get()->sum('cash_received');   
                                                    $due = $info->total_amount - $adjustment_pay;
                                                    @endphp
                                          
                                                    
                                                    @php
                                           $sum_received = \App\Models\PaymentCollect::where('payment_adjustment','0')->where('site_id',$info->site_id)->where('month',date('m'))->where('year',date('Y'))->get()->sum('cash_received');   
                                            @endphp  
                                              @php
                                           $sum_due = $due - $sum_received;
                                           
                                            @endphp 
                                            
                                            {{ $sum_due ?? '0'}} 
                                            </td>
                                            
                                          
                                                   
                                                  
                                                    
                                                  
                                      
                                                </tr>
                                                
                                                  @endforeach
                                        @endif
                                        
                                    
                                     <tfoot>
                                        <tr>
                                            <th>--</th>
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
        "lengthMenu": [
        [5, 10, 15, 20, 5000],
        [5, 10, 15, 20, "All"] // change per page values here
        ],
        
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
       
        // total = api
        //     .column( 2)
        //     .data()
        //     .reduce( function (a, b) {
        //         return intVal(a) + intVal(b);
        //     }, 0 );

        // // Update footer
        // $( api.column(2 ).footer() ).html('' + total);
        // total = api
        //     .column( 3)
        //     .data()
        //     .reduce( function (a, b) {
        //         return intVal(a) + intVal(b);
        //     }, 0 );

        // // Update footer
        // $( api.column(3 ).footer() ).html('' + total);
         total = api
            .column( 2)
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );

        // Update footer
        $( api.column(2 ).footer() ).html('' + total);
        
        //   total = api
        //     .column( 5)
        //     .data()
        //     .reduce( function (a, b) {
        //         return intVal(a) + intVal(b);
        //     }, 0 );

        // // Update footer
        // $( api.column(5 ).footer() ).html('' + total);
       
    }
    });
});
</script>