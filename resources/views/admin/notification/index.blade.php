@extends('admin.layout')
@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-md-9">
                <h3>All Notification</h3>
            </div>
            <div class="col-md-3">
                @if(App\Models\Userpermission::get_permission('notification','is_create'))
                    <button type="button" class="btn btn-primary"><a href="{{ route('create_notification') }}" style="color:#fff;text-decoration: auto !important;">Create Notification</a></button> 
                @endif
            </div>
        </div>
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <!--<div class="card-header py-3">-->
                <!--    <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>-->
                <!--</div>-->
                <div class="container-fluid"><br>
                @if(session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('error') }}
                    </div>
                @endif
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="export_example">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Type</th>
                                    <th>Added On</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        <tbody>
                            @foreach($noti as $info)
                                <tr>
                                    <td>
                                        @if($info->file_name_url != null)
                                            <div class="avatar avatar-xl me-3 bg-gray-200"><img class="avatar-img img-fluid" src="{{ $info->file_name_url }}" alt="Banner"></div>
                                        @else
                                           <div class="avatar avatar-xl me-3 bg-gray-200"><img class="avatar-img img-fluid" src="{{ asset('admin/dummy_img.jpg') }}" alt="Banner"></div>
                                        @endif
                                    </td>
                                    <td>{{ $info->title }}</td>
                                    <td>{{ \Illuminate\Support\Str::limit($info->message, 40, '...') }}</td>
                                    <td> 
                                        @if($info->type == '1')
                                                All
                                        @elseif($info->type == '2')
                                           Individual
                                        @endif
                                    </td>
                                    <td>{{ date('d M y H:i A',strtotime($info->created_at)) }}</td>
                                    <td>
                                        <a class="btn btn-primary btn-circle btn-sm"  href="{{route('view_notification', $info->id)}}"  title="View"><i class="fas fa-eye"></i></a>
                                        @if(App\Models\Userpermission::get_permission('notification','is_delete'))
                                            <a class="btn btn-danger btn-circle btn-sm" onclick="if (!confirm('Are you sure? you want to delete this info')) return false;"   href="{{route('delete_notification', $info->id)}}"  title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection