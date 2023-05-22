@extends('admin.layout')
@section('content')
    <div class="app-content">
        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <div class="page-description">
                            <div class="row">
                                <div class="col-md-9">
                                <h3>Edit Category</h3>
                                </div>
                                <div class="col-md-3">
                                    <button type="button" class="btn btn-dark"><i class="material-icons">arrow_back</i><a href="{{ route('categories.index') }}" style="color:#fff;text-decoration: auto !important;">Back</a></button>
                                </div>
                                <br>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="col-md-3"></div>
                                            <div class="col-md-9">
                                                <form action="{{ route('update_category',[$categories->category_id]) }}" method='post' enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="hidden" name="_method" value="put">
                                                    <div class="row mb-3">
                                                        <label for="inputEmail3" class="col-sm-3 col-form-label">Category Name</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" name="name"  class="form-control" id="inputEmail3" value="{{ $categories->category_name }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label for="inputPassword3" class="col-sm-3 col-form-label">Banner (200*200)</label>
                                                        <div class="col-sm-9">
                                                            <input type="file" name="banner" class="form-control" id="inputEmail3" value="{{ $categories->banner }}">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label for="inputPassword3" class="col-sm-3 col-form-label"></label>
                                                        <div class="col-sm-9">
                                                            @if($categories->cat_img_url != null)
                                                                <div class="avatar avatar-rounded">
                                                                    <img src="{{ $categories->cat_img_url }}" alt="Banner">
                                                                </div>
                                                            @else
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <input type="submit" class="btn btn-primary" value="Save">
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
@endsection