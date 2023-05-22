@extends('admin.layout')
@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-md-10">
                <h1 class="h3 mb-2 text-gray-800">Add Leave</h1>
            </div>
            <div class="col-md-2">
                <a href="{{ route('leave_all') }}" class="btn btn-dark btn-icon-split">
                    <span class="text">Back</span>
                </a>
            </div>
       </div>
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <!--<div class="card-header py-3">-->
            <!--    <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>-->
            <!--</div>-->
            <div class="card-body">
                @if(session('error'))
                    <div class="alert alert-custom alert-indicator-top indicator-danger" role="alert">
                        <div class="alert-content">
                            <span class="alert-title">Error!</span>
                            <span class="alert-text"> {{ session('error') }}</span>
                        </div>
                    </div>
                @endif
                <div class="row">
                    <div class="col-md-12">         
                        <div class="col-md-3"></div>            
                        <div class="col-md-9">                          
                            <form action="{{ route('store_all_leave') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label">User</label>
                                    <div class="col-sm-9">
                                        <select name="user_id" id="user_id" class="form-control">
                                            <option selected="" value="">Select</option>
                                            @foreach($user as $rl)
                                            <option value="{{ $rl->id }}">{{ $rl->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label required">From</label>
                                    <div class="col-sm-9">
                                        <input type="date" name="from"  placeholder="Date" class="form-control" value="{{date('Y-m-d')}}" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label required">To</label>
                                    <div class="col-sm-9">
                                        <input type="date" name="to"  placeholder="Date" class="form-control" value="{{date('Y-m-d')}}" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label required">Reason</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="occasion" placeholder="Reason" class="form-control" id="validationCustom02" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label required">Duration</label>
                                    <div class="col-sm-9">
                                        <select name="duration" class="form-control">
                                            <option value="">Select</option>
                                            <option value="1">One Day</option>
                                            <option value="0.5">Half Day</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label required">Status</label>
                                    <div class="col-sm-9">
                                        <select name="status" class="form-control">
                                            <option value="">Select</option>
                                            <option value="Applied">Applied</option>
                                            <option value="Approved">Approved</option>
                                            <option value="Decline">Decline</option>
                                        </select>
                                    </div>
                                </div>
                                <br>
                                &nbsp;&nbsp;&nbsp;<input type="submit" class="btn btn-primary" value="Add">
                            </form>
                        </div>                                
                    </div>
               </div>         
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script>
        $("#user_id").select2({
          placeholder: "Select",
          allowClear: true,
      });
    </script>
@endsection