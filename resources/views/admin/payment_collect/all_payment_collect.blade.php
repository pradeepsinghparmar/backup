@extends('admin.layout')

@section('content')

  <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="row">
                                        <div class="col-md-10">
                                   <h1 class="h3 mb-2 text-gray-800">All Site Cash Received List</h1>
                                    </div>
                                     <div class="col-md-2">
                                    <button type="button" class="btn btn-dark"><a href="{{ route('all_emp_payment_collect') }}" style="color:#fff;text-decoration: auto !important;">Back</a></button>
                                          
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
        
         
         <a href="{{ route('all_emp_payment_collect') }}" class="btn btn-secondary">All</a>
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
                                                     <th>Employee Name</th>
                                                     <th>Site Name</th>
                                                     <th>Total Amount</th>
                                                    <th>Cash Received</th>
                                                    <th>Cash Due</th>
                                                    <th>Added On</th>
                                                    <th>Action</th>
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                        @php $i=0; @endphp
                                         @foreach($clist as $key => $info)
                                            @php $i++; @endphp
                                                <tr>
                                                    <td>{{ $i }}</td>
                                                     <td>
                                                       @foreach($users as $us)
                                                        @if($us->id == $info->employee_id)
                                                        
                                                        {{ $us->name }}
                                                        @endif
                                                         @endforeach 
                                                        
                                                        </td>
                                                    <td>
                                                       
                                                        
                                                       @foreach($site_list as $inf)
                                    @if($inf->name == $info->site_id)                
                                                      Site {{ $inf->site_id_name }}
                                  @endif
                                  @endforeach
                                                        
                                                        </td>
                                                    <td>{{ $info->total_amount }}</td>
                                                    <td>{{ $info->cash_received }}</td>
                                                    <td>{{ $info->cash_due }}</td>
                                                    <td>{{ date('d M y',strtotime($info->date)) }}</td>
                                                 <td>
                                                         <a class="btn btn-primary btn-circle btn-sm"  href="{{route('view_all_payment_collect', $info->id)}}"  title="View"><i class="fas fa-eye"></i></a>
                                                      <a   class="btn btn-danger btn-circle btn-sm" onclick="if (!confirm('Are you sure? you want to delete this info')) return false;"   href="{{route('delete_all_payment_collect', $info->id)}}"  title="Delete">
                                         <i class="fas fa-trash"></i>
                                                    </a>  
                                                       </td> 
                                       
                                                </tr>
                                                
                                                  @endforeach

                                        
                                    </tbody>
                                     <tfoot>
                                        <tr>
                                            <th>--</th>
                                            <th>--</th>
                                            <th>--</th>
                                            <th>--</th>
                                           <th>--</th>
                                           <th>--</th>
                                           <th>--</th>
                                           <th>--</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
  
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
            // 'pdfHtml5'
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
        // total = api
        //     .column( 3 )
        //     .data()
        //     .reduce( function (a, b) {
        //         return intVal(a) + intVal(b);
        //     }, 0 );

        // // Update footer
        // $( api.column( 3 ).footer() ).html('' + total);
        
        total = api
            .column( 4 )
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );

        // Update footer
        $( api.column( 4 ).footer() ).html('' + total);
        
        total = api
            .column( 5 )
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );

        // Update footer
        $( api.column( 5 ).footer() ).html('' + total);
    }
    });
});
</script>
@endsection