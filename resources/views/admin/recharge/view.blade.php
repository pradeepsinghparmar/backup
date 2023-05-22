@extends('admin.layout')

@section('content')
 <style>
    .tile {
    position: relative;
    background: #ffffff;
    border-radius: 3px;
    padding: 15px;
    height: auto;
    margin-bottom: 30px;
</style>

  <div class="container-fluid">

                    <!-- Page Heading -->
                                       <div class="row">
                                    <div class="col-md-10">
                                    <h3>View Recharge Voucher</h3>
                                    </div>
                                     <div class="col-md-2">
                                         <button type="button" class="btn btn-dark"><a href="{{ route('all_recharge_list.index') }}" style="color:#fff;text-decoration: auto !important;">Back</a></button>   
                                         </div>
                   
                                    </div>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <!--<div class="card-header py-3">-->
                        <!--    <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>-->
                        <!--</div>-->
                         @if(session('success'))
                                        <div class="alert alert-custom alert-indicator-top indicator-success" role="alert">
                                            <div class="alert-content">
                                                <span class="alert-title">Success!</span>
                                                <span class="alert-text"> {{ session('success') }}</span>
                                            </div>
                                        </div>
                                           
                                        @endif
                                          @if(session('error'))
                                        <div class="alert alert-custom alert-indicator-top indicator-danger" role="alert">
                                            <div class="alert-content">
                                                <span class="alert-title">Error!</span>
                                                <span class="alert-text"> {{ session('error') }}</span>
                                            </div>
                                        </div>
                                           
                                        @endif
                        <div class="card-body">
                                        
                                        <div class="tile">
            
                  <table class="table table-striped table-bordered">
                    <tbody>
                        
                        
                      <tr>
                        <td><b>Created By:</b></td>
                        <td>
                           <?php foreach($users as $us){
                            if($us->id == $recharge_list->user_id){?>
                            {{ $us->name }}
                            <?php } }?>
                        </td>
                      </tr> 
                      
                      <tr>
                        <td><b>Site Name:</b></td>
                        <td>
                            <?php foreach($site_list as $ids){
                            if($ids->name == $recharge_list->site_id){?>
                            {{ $ids->site_id_name }}
                            <?php } }?>
                        </td>
                      </tr>
                          <tr>
                        <td><b>Username:</b></td>
                        <td>{{ $recharge_list->username}}</td>
                      </tr>
                       <tr>
                        <td><b>Mobile:</b></td>
                        <td>{{ $recharge_list->mobile}}</td>
                      </tr>
                         <tr>
                        <td><b>Vouchar Code:</b></td>
                        <td>{{ $recharge_list->voucher_code}}</td>
                      </tr>
                        <tr>
                        <td><b>Status:</b></td>
                        <td>{{ $recharge_list->status}}</td>
                      </tr>
                        <tr>
                        <td><b>Profile:</b></td>
                        <td>{{ $recharge_list->profile}}</td>
                      </tr>
                        <tr>
                        <td><b>Price:</b></td>
                        <td>{{ $recharge_list->price}}</td>
                      </tr>
                    
                   
                      <tr>
                        <td><b>Added On:</b></td>
                        <td>{{ date('d M y H:i A',strtotime($recharge_list->created_at)) }}</td>
                      </tr>

                      
                    </tbody>
                  </table>

      
            </div>
                                                
                                        
                                        
                                        
                                                                        
       </div>
                        </div>
                    </div>

  
@endsection