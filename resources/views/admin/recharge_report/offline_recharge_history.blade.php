@extends('admin.layout')

@section('content')

  <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Offline API Site</h1>
                   

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                         <div class="row mt-3">
                                <div class="col-md-12">                        

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
                                                    <th>Site Name</th>
                                                    <th>From API</th>
                                                    <th>Total Amount</th>
                                                    
                                                    <th>Added On</th>
                                                    <th>Action</th>
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                         @if(!empty($new_recharge_history))
                                                  @php $i = 0; @endphp
                                                  @foreach($new_recharge_history as $info)
                                                  
                                                
                                                  @php $i++; @endphp

                                                <tr>
                                          <td>{{ $i }}</td>
                                                
                                          <td>
                                              @if(!empty($info->site_id_name))
                                              {{ $info->site_id_name }}
                                              @else
                                              --
                                              @endif
                                              
                                              </td>   
                                          <?php if($info->type == '1'){?>
                                           <td>A</td>   
                                          
                                          <?php }elseif($info->type == '2'){?>
                                           <td>I</td>   
                                          <?php }?>
                                          <td>
                                           <?php
                                             $sum_site_details = App\Models\Newapidata::where('site_id',$info->name)->sum('price');
                                          
                                             if(!empty($sum_site_details)){
                                                 echo $sum_site_details;
                                             }else{
                                                 echo '0.00';
                                             }
                                              
                                             ?>
                                              </td>   
                                          
                                          
                                          <td>{{ date('d M y',strtotime($info->created_at)) }}</td>          
                                                    
                          <td>
                                                         <a class="btn btn-primary btn-circle btn-sm"  href="{{route('view_offline_site_details', $info->name)}}"  title="View"><i class="fas fa-eye"></i></a>
                                                       </td>
                        
                                                   
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