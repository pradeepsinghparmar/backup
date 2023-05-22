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
                                    <h3>View Notification</h3>
                                    </div>
                                     <div class="col-md-2">
                                         <button type="button" class="btn btn-dark"><a href="{{ route('notification.index') }}" style="color:#fff;text-decoration: auto !important;">Back</a></button>   
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
                        <td><b>Image:</b></td>
                        <td> 
                        @if($view_notification->file_name_url != null)
                                                        
                             <div class="avatar avatar-xl me-3 bg-gray-200"><img class="avatar-img img-fluid" src="{{ $view_notification->file_name_url }}" alt="Banner"></div>
                                                        
                        @else
                             <div class="avatar avatar-xl me-3 bg-gray-200"><img class="avatar-img img-fluid" src="{{ asset('admin/dummy_img.jpg') }}" alt="Banner"></div>
                        @endif
                            </td>
                      </tr>
                      <tr>
                        <td><b>Title:</b></td>
                        <td>{{ $view_notification->title }}</td>
                      </tr>

                       <tr>
                        <td><b>Description:</b></td>
                        <td>{{ $view_notification->message}}</td>
                      </tr>
                        @if(Auth::user()->role == '1')
                        <tr>
                        <td><b>Type:</b></td>
                        <td>
                        @if($view_notification->type == '1')
                        All
                        @elseif($view_notification->type == '2')
                        Individual
                        @endif
                        </td>
                      </tr>
                    
                     @if($view_notification->type == '2')
                        <tr>
                        <td><b>Username:</b></td>
                        <td>
                            @foreach($user as $info)
                            @if($info->id == $view_notification->user_id)
                                    {{ $info->name }}
                            @endif
                            @endforeach
                            
                        </td>
                      </tr>
                      @endif
                         @endif

                      <tr>
                        <td><b>Added On:</b></td>
                        <td>{{ date('d M y H:i A',strtotime($view_notification->created_at)) }}</td>
                      </tr>

                      
                    </tbody>
                  </table>

      
            </div>
                                                
                                        
                                        
                                        
                                                                        
       </div>
                        </div>
                    </div>

  
@endsection