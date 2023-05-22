@extends('admin.layout')

@section('content')
 <style>
    .tile {
    position: relative;
    background: #ffffff;
    border-radius: 3px;
    padding: 15px;
    height: 500px;
    margin-bottom: 30px;
</style>

  <div class="container-fluid">

                    <!-- Page Heading -->
                                       <div class="row">
                                    <div class="col-md-10">
                                    <h3>View Activity Notification</h3>
                                    </div>
                                     <div class="col-md-2">
                                         <button type="button" class="btn btn-dark"><a href="{{ route('activity_list') }}" style="color:#fff;text-decoration: auto !important;">Back</a></button>   
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
                        <td><b>Employee Name:</b></td>
                        <td> @foreach($users as $inf)
                                    @if($inf->id == $view_activity_list->user_id)                
                                         {{ $inf->name }}
                                  @endif
                                  @endforeach</td>
                      </tr>
                       <tr>
                        <td><b>Account Type:</b></td>
                        <td> @foreach($role as $infs)
                                    @if($infs->role_id == $view_activity_list->user_type)                
                                         {{ $infs->name }}
                                  @endif
                                  @endforeach</td>
                      </tr>
                     
                       
                      <tr>
                        <td><b>Module:</b></td>
                        <td><?php echo $view_activity_list->module;?></td>
                      </tr>
                      <tr>
                        <td><b>Activity:</b></td>
                        <td><?php echo $view_activity_list->activity;?></td>
                      </tr>
                   <tr>
                        <td><b>Status:</b></td>
                        <td>
                            <?php if($view_activity_list->status == "read"){?> 
                            <span class="badge bg-light-success text-success rounded-pill">Read</span>
                         <?php }elseif($view_activity_list->status == "unread"){?>
                              <span class="badge bg-light-danger text-danger rounded-pill">Unread</span>
                        <?php  }?>
                            
                            
                            </td>
                      </tr>
                      <tr>
                        <td><b>Added On:</b></td>
                        <td><?php echo date('d M y H:i A',strtotime($view_activity_list->created_at)); ?></td>
                      </tr>

                      
                    </tbody>
                  </table>

      
            </div>
                                                
                                        
                                        
                                        
                                                                        
       </div>
                        </div>
                    </div>

  
@endsection