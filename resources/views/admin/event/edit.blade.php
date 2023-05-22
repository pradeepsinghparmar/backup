@extends('admin.layout')
@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-md-10">
                <h1 class="h3 mb-2 text-gray-800">Edit Event</h1>
            </div>
            <div class="col-md-2">
                <a href="{{ route('event') }}" class="btn btn-dark btn-icon-split">
                    <span class="text">Back</span>
                </a>
            </div>
        </div>
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
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
                            <form action="{{ route('update_event',$editevent->id) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label required">First Name</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="first_name" value="{{ $editevent->first_name }}" placeholder="First Name" class="form-control"  required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label required">Last Name</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="last_name" value="{{ $editevent->last_name }}" placeholder="Last Name" class="form-control"  required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label">Mobile</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="phone" value="{{ $editevent->phone }}" placeholder="Name" class="form-control">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label">Email</label>
                                    <div class="col-sm-9">
                                        <input type="email" name="email" value="{{ $editevent->email }}" placeholder="Email" class="form-control">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label">Company</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="company_name" value="{{ $editevent->company_name }}" placeholder="Name" class="form-control">
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