@extends('admin.layout')
@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-md-10">
                <h1 class="h3 mb-2 text-gray-800">Edit Project</h1>
            </div>
            <div class="col-md-2">
                <a href="{{ route('project_list') }}" class="btn btn-dark btn-icon-split">
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
                        <div class="col-md-3">
                        </div>
                        <div class="col-md-9">
                            <form action="{{ route('update_project',$editstaff->id) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row mb-3">
                                    <label for="validationCustom01" class="col-sm-3 col-form-label">Project Id</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="project_id" value="{{ $editstaff->project_id }}" placeholder="Project Id" class="form-control" for="validationCustom01" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="validationCustom01" class="col-sm-3 col-form-label">Name</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="name" value="{{ $editstaff->name }}" placeholder="Name" class="form-control" for="validationCustom01" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Description</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="description" value="{{ $editstaff->description }}" placeholder="Description" class="form-control" id="description">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="validationCustom01" class="col-sm-3 col-form-label">Vendor</label>
                                    <div class="col-sm-9">
                                        <select name="vendor_id"  class="form-control" for="validationCustom04" required>
                                            <option selected="" disabled="" value="">Select</option>
                                            @foreach($vendor as $ve)
                                            <option value="{{ $ve->id }}" @if($ve->id==$editstaff->vendor_id) selected @endif>{{ $ve->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="validationCustom01" class="col-sm-3 col-form-label">Customer</label>
                                    <div class="col-sm-9">
                                        <select name="customer_id"  class="form-control" for="validationCustom04" required>
                                            <option selected="" disabled="" value="">Select</option>
                                            @foreach($customer as $rl)
                                            <option value="{{ $rl->id }}" @if($rl->id==$editstaff->customer_id) selected @endif>{{ $rl->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <input type="submit" class="btn btn-primary" value="Update">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection