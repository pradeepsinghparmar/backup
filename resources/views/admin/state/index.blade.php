@extends('admin.layout')
@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-md-10">
                <h1 class="h3 mb-2 text-gray-800">All State Registry</h1>
            </div>
            <div class="col-md-2">
                @if(App\Models\Userpermission::get_permission('state_registry','is_create'))
                    <a href="{{ route('create_state') }}" class="btn btn-info btn-icon-split">
                        <span class="text">Add State Registry</span>
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
                                    <th>State Name</th>
                                    <th>SIT</th>
                                    <th>Website</th>
                                    <th>SUI</th>
                                    <th>Website</th>
                                    <th>Update</th>
                                    <th>Next Task</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($states as $key => $staff)
                                    <tr>
                                        <td>{{ $staff->id }}</td>
                                        <td>{{ $staff->name }}</td>
                                        <td>{{ $staff->siu }}</td>
                                        <td><a href="{{ $staff->website }}" target="_blank">{{ $staff->website }}</a></td>
                                        <td>{{ $staff->su }}</td>
                                        <td><a href="{{ $staff->siu_website }}" target="_blank">{{ $staff->siu_website }}</a></td>
                                        <td>{{ $staff->updates }}</td>
                                        <td>{{ $staff->next_task }}</td>
                                        
                                            <td> 
                                                    <a class="btn btn-primary btn-circle btn-sm"  href="{{route('view_state', $staff->id)}}"  title="View"><i class="fas fa-eye"></i></a>
                                                    @if(App\Models\Userpermission::get_permission('state_registry','is_edit'))
                                                    <a class="btn btn-success btn-circle btn-sm"  href="{{route('edit_state', $staff->id)}}"  title="Edit"><i class="fas fa-edit"></i></a>
                                                    @endif
                                                    @if(App\Models\Userpermission::get_permission('state_registry','is_delete'))
                                                    <a   class="btn btn-danger btn-circle btn-sm" onclick="if (!confirm('Are you sure? you want to delete this info')) return false;" href="{{route('delete_state', $staff->id)}}"  title="Delete">
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
{{ csrf_field() }}
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
@endsection