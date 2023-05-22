@extends('admin.layout')

@section('content')

  <div class="container-fluid">
                                  <div class="row">
                                        <div class="col-md-10">
                                   <h1 class="h3 mb-2 text-gray-800">All Due Cash</h1>
                                    </div>
                                     <div class="col-md-2">
                                    
                                    </div>
                   </div>
                    <!-- Page Heading -->
                  
                   

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                         <div class="row mt-3">
                                <div class="col-md-12">                        
<form action="{{ route('search_cash_due_reports') }}" method="post">
@csrf

<div class="col-sm-3" style="float: left;">
            <select name="site_name" class="form-control" id="inputEmail3" required>
                 <option value="">All</option>
                @foreach($site_list as $hi)
                <option value="{{ $hi->name }}" {{  $api_site_info->name == $hi->name ? 'selected="selected"' : '' }} >Site {{ $hi->site_id_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-sm-3" style="float: left;">
            <input type="date" name="start_date" placeholder="Enter Start Date" value="<?php if(!empty($from_date)) { echo date('Y-m-d',strtotime($from_date)); }else{ echo date('Y-m-d') ;}?>" class="form-control" id="inputEmail3"  required>
        </div>
    
        <div class="col-sm-3" style="float: left;">
            <input type="date" name="end_date" placeholder="Enter End Date" value="<?php if(!empty($to_date)) { echo date('Y-m-d',strtotime($to_date)); }else{ echo date('Y-m-d') ;}?>" class="form-control" id="inputEmail3" required>
        </div>
    
    <div class="col-sm-3" style="float: left;">
   
          <input type="submit" name="cmdSearch" class="btn btn-primary" value="Search">
           <a href="{{ route('all_due_cash') }}" class="btn btn-secondary">All</a>
    </div>
</form>
                                
                            </div>
                        </div>

                        <!--<div class="card-header py-3">-->
                        <!--    <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>-->
                        <!--</div>-->
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="export_example1">
                                    <thead>
                                        <tr>
                                             <th>S No</th>
                                                    <th>Site Name</th>
                                                    <th>Date</th>
                                                    <th>Total Amount</th>
                                        </tr>
                                    </thead>
                                   
                                   
                                  
                                        
                                      
                                     
                                         <tbody>
                                         @if(!empty($show_site_total_payment))
                                                  @php $i = 0; @endphp
                                                  @foreach($show_site_total_payment as $info)
                                                  
                                                
                                                  @php $i++; @endphp

                                                <tr>
                                          <td>{{ $i }}</td>
                                          <td>Site {{ $api_site_info->site_id_name }}</td>  
                                          <td>
                                              {{ date('d M y',strtotime($info->date)) }}
                                              
                                          </td> 
                                          <td>
                                             
                                              {{ $info->cash_due }} 
                                              
                                          </td>     
                                                    
                          
                        
                                                   
                                                </tr>
                                                
                                                  @endforeach
                                            @endif
                                         <tfoot>
                                            <tr>
                                                 <th>--</th>
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
            .column( 3)
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );

        // Update footer
        $( api.column( 3 ).footer() ).html('' + total);
    }
    });
});
</script>