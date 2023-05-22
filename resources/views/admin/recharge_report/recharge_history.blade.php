@extends('admin.layout')

@section('content')

  <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Recharge History</h1>
                   

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                         <div class="row mt-3">
                                <div class="col-md-12">                        
<form action="{{ route('search_history') }}" method="post">
@csrf

        <div class="col-sm-3" style="float: left;">
            <select name="site_name" class="form-control" id="inputEmail3" required>
                @foreach($recharge_history as $hi)
                <option value="{{ $hi->id }}">{{ $hi->name }}</option>
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
           <a href="{{ route('recharge_history') }}" class="btn btn-secondary">Reset</a>
    </div>
</form>
                                
                            </div>
                        </div>

                        <!--<div class="card-header py-3">-->
                        <!--    <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>-->
                        <!--</div>-->
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="export_example" data-name='add_money'>
                                    <thead>
                                        <tr>
                                             <th>S No</th>
                                                    <th>Name</th>
                                                    
                                                    <th>Amount</th>
                                                    <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                             <th>S No</th>
                                                    <th>Name</th>
                                                    
                                                    <th>Amount</th>
                                                    <th>Date</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                         @if(!empty($show_list))
                                                  @php $i = 0; @endphp
                                                  @foreach($show_list as $info)
                                                  
                                                
                                                  @php $i++; @endphp

                                                <tr>
                                          <td>{{ $i }}</td>
                                          <td>
                                             @foreach($recharge_history as $hii)
                                              @if($hii->id == $name)
                                             {{ $hii->site_id_name }}
                                              @endif
                                              @endforeach
                                          </td>          
                                          <td>{{ $info['sale'] }}</td>          
                                          <td>{{ date('d M y',strtotime($info['date'])) }}</td>          
                                                    
                          
                        
                                                   
                                                </tr>
                                                
                                                  @endforeach
                                            @endif
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
  
@endsection