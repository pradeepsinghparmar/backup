@extends('admin.layout')
@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-md-10">
                <h1 class="h3 mb-2 text-gray-800">Edit Leave</h1>
            </div>
            <div class="col-md-2">
                <a href="{{ route('leave_list') }}" class="btn btn-dark btn-icon-split">
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
                            <form action="{{ route('update_leave',$leave_edit->id) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label required">From</label>
                                    <div class="col-sm-9">
                                        <input type="date" name="from" value="{{ $leave_edit->from }}"  placeholder="Date" class="form-control" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label required">To</label>
                                    <div class="col-sm-9">
                                        <input type="date" name="to" value="{{ $leave_edit->to }}"  placeholder="Date" class="form-control" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label required">Reason</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="occasion" value="{{ $leave_edit->occasion }}" placeholder="Reason" class="form-control" id="validationCustom02" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label required">Duration</label>
                                    <div class="col-sm-9">
                                        <select name="duration" class="form-control">
                                            <option value="">Select</option>
                                            <option value="1" @if($leave_edit->duration=='1') Selected @endif>One Day</option>
                                            <option value="0.5"  @if($leave_edit->duration=='0.5') Selected @endif>Half Day</option>
                                        </select>
                                    </div>
                                </div>
                                <br>
                                &nbsp;&nbsp;&nbsp;<input type="submit" class="btn btn-primary" value="Update">
                            </form>
                        </div>                                
                    </div>
               </div>         
            </div>
        </div>
    </div>
@endsection