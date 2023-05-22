@extends('admin.layout')
@section('content')
    <style>
        /*#DataTables_Table_0_filter{
            display: none;
        }*/
        .dt-buttons{
            display: none;
        }
        .export_example{
            border: 2px solid #c3c5e0;
        }
    </style>
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-md-10">
                <h1 class="h3 mb-2 text-gray-800">All Group</h1>
            </div>
            <div class="col-md-2">
                @if(App\Models\Userpermission::get_permission('group','is_create'))
                    <a href="{{ route('create_group') }}" class="btn btn-info btn-icon-split">
                        <span class="text">Add Group</span>
                    </a>
                @endif
            </div>
        </div>
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
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
                                    <th>Name</th>
                                    @if(App\Models\Userpermission::get_permission('group','is_edit') || App\Models\Userpermission::get_permission('group','is_delete')) 
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
                                        <td>{{ $staff->name }}</td>
                                        @if(App\Models\Userpermission::get_permission('group','is_edit') || App\Models\Userpermission::get_permission('group','is_delete')) 
                                            <td> 
                                                @if(App\Models\Userpermission::get_permission('group','is_edit')) 
                                                    <a class="btn btn-success btn-circle btn-sm"  href="{{route('edit_group', $staff->id)}}"  title="Edit"><i class="fas fa-edit"></i></a>
                                                @endif
                                                @if(App\Models\Userpermission::get_permission('group','is_delete'))    
                                                    <a class="btn btn-danger btn-circle btn-sm" onclick="if (!confirm('Are you sure? you want to delete this info')) return false;" href="{{route('delete_group', $staff->id)}}"  title="Delete">
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
{{ csrf_field() }}
<style>
    .export_example{
        border: 2px solid #c3c5e0;
    }
    table {
        table-layout:fixed;
        width:95% !important;
    }
    td{
        overflow:hidden;
        text-overflow: ellipsis;
    }
</style>
@endsection