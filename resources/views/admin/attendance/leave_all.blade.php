@extends('admin.layout')
@section('content')
  <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-md-10">
                <h1 class="h3 mb-2 text-gray-800">All Leave List</h1>
            </div>
            <div class="col-md-2">
                @if(App\Models\Userpermission::get_permission('leave','is_create'))   
                    <a href="{{ route('create_all_leave') }}" class="btn btn-info btn-icon-split">
                        <span class="text">Create Leave</span>
                    </a>
                @endif
            </div>
       </div>
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
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
                            <th>S No.</th>
                            <th>User</th>
                            <th>From</th>
                            <th>To</th>
                            <th>Reason</th>
                            <th>Duration</th>
                            <th>Added On</th>
                            <th>Status</th>
                            @if(App\Models\Userpermission::get_permission('leave','is_edit') || App\Models\Userpermission::get_permission('leave','is_delete')) 
                                <th>Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @php $i=0; @endphp
                        @foreach($leave_list as $key => $customer)
                            @php $i++; @endphp
                            <tr>
                                <td>{{$i}}</td>
                                <td>@foreach($user as $us)
                                        @if($us->id == $customer->user_id) {{ $us->name }} {{ $us->last_name }} @endif 
                                    @endforeach</td>
                                <td>{{ date('d M y',strtotime($customer->from)) }}</td>
                                <td>{{ date('d M y',strtotime($customer->to)) }}</td>
                                <td>{{ $customer->occasion }}</td>
                                <td>{{ $customer->duration }}</td>
                                <td>{{ date('d M y H:i A',strtotime($customer->created_at)) }}</td>
                                <td>{{$customer->status}}</td>
                                @if(App\Models\Userpermission::get_permission('leave','is_edit') || App\Models\Userpermission::get_permission('leave','is_delete')) 
                                    <td>
                                        @if(App\Models\Userpermission::get_permission('leave','is_edit'))
                                        <a class="btn btn-success btn-circle btn-sm"  href="{{route('edit_all_leave', $customer->id)}}"  title="Edit"><i class="fas fa-edit"></i></a>
                                        @endif
                                        @if(App\Models\Userpermission::get_permission('leave','is_delete'))
                                        <a   class="btn btn-danger btn-circle btn-sm" onclick="if (!confirm('Are you sure? you want to delete this info')) return false;"   href="{{route('delete_leave', $customer->id)}}"  title="Delete">
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
<style type="text/css">
    /*#DataTables_Table_0_filter{
        display: none;
    }*/
    .dt-buttons .buttons-copy {
        display: none;
    }
    .dt-buttons .buttons-excel{
        display: none;
    }
    @media (min-width: 768px){
        .btn-info {
            font-size: 12px !important;
        }
    }
</style>
@endsection