@extends('admin.layout')

@section('content')

  <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Daily Recharge Report</h1>
                   

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <!--<div class="card-header py-3">-->
                        <!--    <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>-->
                        <!--</div>-->
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="export_example">
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
                                         @if(!empty($api_list))
                                                  @php $i = 0; @endphp
                                                  @foreach($api_list as $info)
                                                  
                                                
                                                  @php $i++; @endphp

                                                <tr>
                                          <td>{{ $i }}</td>
                                          <td>{{ $info->site_id_name }}</td>          
                                                    
                            @php
                              $url = $info->api_url;
                              $ch = curl_init();
                              curl_setopt($ch, CURLOPT_URL, $url);
                              curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                              $result = curl_exec($ch);
                              $getlist = $result;
                              $show_list = json_decode($getlist,true);
                            @endphp
                        
                         
                         <td>
                             @if(!empty($show_list))
                              @foreach($show_list as $list)
                                    
                                     {{ $list['sale'] }}
                                     
                              @endforeach
                             @endif
                         </td>
                         <td>
                              @if(!empty($show_list))
                              @foreach($show_list as $list)
                                    
                                 {{ date('d M y',strtotime($list['date'])) }}
                                 
                              @endforeach
                             @endif
                            
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