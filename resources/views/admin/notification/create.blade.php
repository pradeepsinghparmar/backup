@extends('admin.layout')
@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-md-10">
                <h3>Create Notification</h3>
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
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-3"></div>
                        <div class="col-md-9">
                            <form action="{{ route('store_notification') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row mb-3">
                                    <label for="validationCustom04" class="col-sm-3 col-form-label required">Send Type</label>
                                    <div class="col-sm-9">
                                        <select name="type"  id="type" class="form-control" for="validationCustom04" required>
                                            <option selected="" disabled="" value="">Select Type</option>
                                            <option value="1">All</option>
                                            <option value="2">Individual</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3" style="display:none;" id="user_div">
                                    <label for="validationCustom05" class="col-sm-3 col-form-label required">Users</label>
                                    <div class="col-sm-9">
                                        <select name="user_id"  class="form-control" for="validationCustom05" required>
                                            <!--<option selected="" disabled="" value="">Select User</option>-->
                                            @foreach($user as $info)
                                                <option value="{{ $info->id }}">{{ $info->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label required">Title</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="title" placeholder="Enter Title" class="form-control" id="inputEmail3" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label required">Description</label>
                                    <div class="col-sm-9">
                                        <textarea name="description" maxlength="150" placeholder="Enter Description" class="form-control" id="inputEmail3" required></textarea>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="inputPassword3" class="col-sm-3 col-form-label">Banner (200*200)<br>
                                    <span style="font-size:11px;">PNG | JPG | JPEG |GIF (upload Image Size Max 2MB)</span></label>
                                    <div class="col-sm-9">
                                        <input type="file" name="banner" class="form-control" id="noti_image">
                                        <br>
                                        <div id="image-holder"></div>
                                    </div>
                                </div>
                                <input type="submit" class="btn btn-primary" value="Save">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
    <style>
        .imgsize{
            width:100px !important;
            height:100px !important;
        }
        .required:after {
            content:" *";
            color: red;
          }
    </style>
    <script src="{{ asset('admin/assets/vendor/jquery/jquery.min.js') }}"></script>
    <script>
        $('#type').change(function() {
            //Use $option (with the "$") to see that the variable is a jQuery object
            var $option = $(this).find('option:selected');
            //Added with the EDIT
            var value = $option.val(); //to get value
            //var text = $option.text();//to get Text

            if(value == '2'){
                $('#user_div').show();
            }else{
                $('#user_div').hide();
            }
        });
    </script>
    <script>
        $("#noti_image").on('change', function () {
            //Get count of selected files
            var countFiles = $(this)[0].files.length;
            if(countFiles < 2){
                 $('#image-holder').css('display','none');
                 const size = (this.files[0].size / 1024 / 1024).toFixed(2);
                if (size > 2 || size < 0) {
                    alert("Max File size 2 MB, check file size");
                    $('#noti_image').val('');
                    $('#image-holder').css('display','none');
            }else{
                var imgPath = $(this)[0].value;
                var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
                var image_holder = $("#image-holder");
                image_holder.empty();
                // mp4|avi|flv|wmv|
                if (extn == "gif" || extn == "png" || extn == "jpg" || extn == "jpeg") {
                    if (typeof (FileReader) != "undefined") {
                        //loop for each file selected for uploaded.
                        for (var i = 0; i < countFiles; i++) {
                            var reader = new FileReader();
                            reader.onload = function (e) {
                                $("<img />", {
                                    "src": e.target.result,
                                        "class": "imgsize"
                                }).appendTo(image_holder);
                            }
                            image_holder.show();
                            reader.readAsDataURL($(this)[0].files[i]);
                        }
                    } else {
                        alert("This browser does not support FileReader.");
                    }
                }else{
                    alert('Only allowed png, jpg, jpeg, gif');
                    $('#noti_image').val('');
                    $('#image-holder').css('display','none');
                }
            }
           }else{
               alert('you can only 1 image upload.');
            }
        });
    </script>
@endsection