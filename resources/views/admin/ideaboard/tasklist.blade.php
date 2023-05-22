@extends('admin.layout')
@section('content')
    <style>
        .dt-buttons{
            display: none;
        }
    </style>
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-md-10">
                <h1 class="h3 mb-2 text-gray-800">All Task</h1>
            </div>
             <div class="col-md-2">
                @if(App\Models\Userpermission::get_permission('daily_task','is_create'))
                    <a href="{{ route('create_dailytask') }}" class="btn btn-info btn-icon-split">
                        <span class="text">Add Task</span>
                    </a>
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
                                    <th>ID</th>
                                    <th>Task</th>
                                    <th>Comment</th>
                                    @if(App\Models\Userpermission::get_permission('daily_task','is_edit') || App\Models\Userpermission::get_permission('daily_task','is_delete'))
                                        <th>Action</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @php $i = 0;@endphp
                                @foreach($staff as $key => $staff)
                                @php $i++;@endphp
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $staff->task }}</td>
                                        <td>{{ $staff->comment }}</td>

                                        @if(App\Models\Userpermission::get_permission('daily_task','is_edit') || App\Models\Userpermission::get_permission('daily_task','is_delete'))
                                            <td>
                                                @if(App\Models\Userpermission::get_permission('daily_task','is_edit'))
                                                    <a class="btn btn-success btn-circle btn-sm"  href="{{route('edit_dailytask', $staff->id)}}"  title="Edit"><i class="fas fa-edit"></i></a>
                                                @endif
                                                @if(App\Models\Userpermission::get_permission('daily_task','is_delete'))    
                                                    <a class="btn btn-danger btn-circle btn-sm" onclick="if (!confirm('Are you sure? you want to delete this info')) return false;" href="{{route('delete_dailytask', $staff->id)}}" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                @endif
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
@endsection