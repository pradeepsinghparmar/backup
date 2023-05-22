@extends('admin.layout')
@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-md-10">
                <h1 class="h3 mb-2 text-gray-800">Edit Customer</h1>
            </div>
            <div class="col-md-2">
                <a href="{{ route('customer_list') }}" class="btn btn-dark btn-icon-split">
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
                            <form action="{{ route('update_customer',$editstaff->id) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row mb-3">
                                    <label for="validationCustom01" class="col-sm-3 col-form-label">Customer Id</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="customer_id" value="{{ $editstaff->customer_id }}" placeholder="Customer Id" class="form-control" for="validationCustom01" disabled>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="validationCustom01" class="col-sm-3 col-form-label required">Name</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="name" value="{{ $editstaff->name }}" placeholder="Name" class="form-control" for="validationCustom01" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="validationCustom01" class="col-sm-3 col-form-label">Address</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="address" value="{{ $editstaff->address }}" placeholder="Address" class="form-control" for="validationCustom01">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label required">Mobile</label>
                                    <div class="col-sm-9">
                                        <input type="number" name="phone" value="{{ $editstaff->phone }}"  placeholder="Mobile" class="form-control" id="inputEmail3" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label required">Email</label>
                                    <div class="col-sm-9">
                                        <input type="email" name="email" value="{{ $editstaff->email }}" placeholder="Email" class="form-control" id="inputEmail3" disabled>
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
    <style type="text/css">
        .required:after {
            content:" *";
            color: red;
          }
    </style>
@endsection