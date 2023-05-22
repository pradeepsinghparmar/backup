@extends('admin.layout')

@section('content')

  <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="row">
                                        <div class="col-md-10">
                                   <h1 class="h3 mb-2 text-gray-800">{{ $userdata->name ?? ' ' }} Recharge Summary </h1>
                                    </div>
                                     <div class="col-md-2">
                                    <!-- <a href="{{ route('create_allapi') }}" class="btn btn-info btn-icon-split">-->
                                    <!--    <span class="text">Create API</span>-->
                                    <!--</a>-->
                                          
                                    </div>
                   </div>
                   

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        @if(Auth::user()->role_status == 0)
                     
                          <div class="row mt-3">
                                <div class="col-md-12">                        
<form action="{{ route('received_voucher_filter') }}" method="post">
@csrf

<div class="col-sm-3" style="float: left;">
     <!--label ui selection fluid dropdown-->
          <select name="profile_name[]" class="form-control multi_select" id="inputEmail3" required multiple data-selected-text-format="count > 3">
             
                @foreach($data as $d)
                 <option value="{{ $d->profile }}">{{ $d->profile }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-sm-3" style="float: left;">
            <input type="date" name="start_date" placeholder="Enter Start Date" class="form-control" id="inputEmail3"  required>
        </div>
    
        <div class="col-sm-3" style="float: left;">
            <input type="date" name="end_date" placeholder="Enter End Date" class="form-control" id="inputEmail3" required>
        </div>
    
    <div class="col-sm-3" style="float: left;">
   
          <input type="submit" name="cmdSearch" class="btn btn-primary" value="Search">
           <a href="{{ route('cash_reports') }}" class="btn btn-secondary">All</a>
    </div>
</form>
                                
                            </div>
                        </div>
                      @endif
                       <div class="container-fluid"><br>
       
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="export_example1">
                                   
                                    <thead>
                                        <tr>
                                                    <th>S No</th>
                                                    <th>Site Name</th>
                                                    <th>User Name</th>
                                                    <th>Mobile</th>
                                                    <th>Price</th>
                                                    <th>Profile</th>
                                                    <th>Month</th>
                                                    <th>Year</th>
                                                
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                       
                                         @php $i=0; @endphp
                                         @foreach($data as $d)
                                       
                                    @php  $i++; @endphp
                                    
                                    <tr>
                                        <td>{{ $i}}</td>
                                      
                                      <td>{{$d->sitename }}</td>
                                      <td>{{ $d->username}}</td>
                                      <td>{{ $d->mobile}}</td>
                                      <td>{{ $d->price}}</td>
                                      <td>{{ $d->profile}}</td>
                                        <td>{{ $d->month}}</td>
                                         <td>{{ $d->year}}</td>
                                    </tr>
                                               
                                                  @endforeach
                                       
                                        
                                    
                                     <tfoot>
                                        <tr>
                                            <th>--</th>
                                             <th>--</th>
                                           <th></th>
                                           
                                           <th></th>
                                           <th></th>
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
            .column( 4)
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );

        // Update footer
        $( api.column(4 ).footer() ).html('' + total);
        
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