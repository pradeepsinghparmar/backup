@extends('admin.layout')
@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-md-10">
                <h1 class="h3 mb-2 text-gray-800">Create Holiday</h1>
            </div>
            <div class="col-md-2">
                <a href="{{ route('holiday_list') }}" class="btn btn-dark btn-icon-split">
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
                            <form action="{{ route('store_holiday') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="bs-form-wrapper">
                                    <div class="input-wrapper">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="col-sm-4" style="float:left;">
                                                    <input type="date" id="date" name="date[]"  placeholder="Date" class="form-control" for="validationCustom01" required>
                                                </div>
                                                <div class="col-sm-7" style="float:left;">
                                                    <input type="text" name="occasion[]"  placeholder="Occasion" class="form-control" id="validationCustom02" required>
                                                </div>
                                                <div class="col-sm-1" style="float:left;">
                                                    <button  style="height: 40px !important;margin: 5px; margin-top: -2px !important;" class="btn btn-success bs-add-button" type="button"><i class="fas fa-fw fa-plus"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                &nbsp;&nbsp;&nbsp;<input type="submit" class="btn btn-primary" value="Save">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            var maxLimit = 5;
            var appendHTML = '<div class="input-wrapper"><div class="row"><div class="col-sm-12"><div class="col-sm-4"  style="float:left;"><input type="date" name="date[]"  placeholder="Date" class="form-control" for="validationCustom01" required></div><div class="col-sm-7"  style="float:left;"><input type="text" name="occasion[]"  placeholder="Occasion" class="form-control" id="validationCustom02" required></div><div class="col-sm-1"  style="float:left;"><button  style="height: 40px !important;margin: 5px; margin-top: -2px !important;" class="btn btn-danger bs-remove-button" type="button"><i class="fas fa-fw fa-minus"></i></button></div></div></div></div>'; 
            var x = 1;
        
            // for addition
            $('.bs-add-button').click(function(e){
            	e.preventDefault();
                if(x < maxLimit){ 
                    $('.bs-form-wrapper').append(appendHTML);
                    x++;
                }
            });
            
            // for deletion
            $('.bs-form-wrapper').on('click', '.bs-remove-button', function(e){
                e.preventDefault();
                $(this).parents('.input-wrapper').remove();
                x--;
            });
        });
    </script>
@endsection