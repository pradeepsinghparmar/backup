@extends('admin.layout')
@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-md-10">
                <h1 class="h3 mb-2 text-gray-800">Edit Lead</h1>
            </div>
            <div class="col-md-2">
                <a href="{{ route('lead') }}" class="btn btn-dark btn-icon-split">
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
                            <form action="{{ route('update_lead',$editlead->id) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label required">First Name</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="first_name" value="{{ $editlead->first_name }}" placeholder="First Name" class="form-control"  required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label required">Last Name</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="last_name" value="{{ $editlead->last_name }}" placeholder="Last Name" class="form-control"  required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label">Mobile</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="phone" value="{{ $editlead->phone }}" placeholder="Name" class="form-control">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label">Email</label>
                                    <div class="col-sm-9">
                                        <input type="email" name="email" value="{{ $editlead->email }}" placeholder="Email" class="form-control">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label">Company</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="company_name" value="{{ $editlead->company_name }}" placeholder="Name" class="form-control">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label">Message</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="message" value="{{ $editlead->message }}" placeholder="Message" class="form-control">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label">Job Title</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="job_title" value="{{ $editlead->job_title }}" placeholder="Job Title" class="form-control">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label">Topic</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="topic" value="{{ $editlead->topic }}" placeholder="Topic" class="form-control">
                                    </div>
                                </div>
                                @php $user_id_arr = explode(',', $editlead->user_id); @endphp
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label">Assign To</label>
                                    <div class="col-sm-9">
                                        <select name="user_id[]" id="user_id" multiple class="form-control">
                                            @foreach($users as $rl)
                                            <option value="{{ $rl->id }}" @if(in_array($rl->id, $user_id_arr)) selected @endif>{{ $rl->name }} {{ $rl->last_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label">Notes</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="notes" value="{{ $editlead->notes }}" placeholder="Notes" class="form-control">
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!-- Select2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script>
        $("#user_id").select2({
          placeholder: "Select",
          allowClear: true,
      });
    </script>
@endsection